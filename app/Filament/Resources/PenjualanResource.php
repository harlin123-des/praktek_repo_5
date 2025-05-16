<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PenjualanResource\Pages;
use App\Models\Penjualan;
use App\Models\Menu;
use App\Models\PenjualanMenu;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Forms\Get;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Hidden;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\Actions\Action as FormAction;
use Filament\Forms\Components\Actions;

class PenjualanResource extends Resource
{
    protected static ?string $model = Penjualan::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationLabel = 'Penjualan';
    protected static ?string $navigationGroup = 'Transaksi';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Wizard::make([
                Wizard\Step::make('Pesanan')
                    ->schema([
                        Forms\Components\Section::make('Faktur')
                            ->icon('heroicon-m-document-duplicate')
                            ->schema([
                                TextInput::make('no_faktur')
                                    ->default(fn () => Penjualan::getKodeFaktur())
                                    ->label('Nomor Faktur')
                                    ->required()
                                    ->readonly(),

                                DateTimePicker::make('tgl')
                                    ->default(now()),

                                TextInput::make('nama_pembeli')
                                    ->label('Nama Pembeli')
                                    ->required()
                                    ->placeholder('Masukkan Nama Pembeli'),

                                TextInput::make('email')
                                    ->label('Email Pembeli')
                                    ->email()
                                    ->required()
                                    ->placeholder('Masukkan email pembeli'),

                                Select::make('jenis_penjualan')
                                    ->label('Jenis Penjualan')
                                    ->options([
                                        'take_away' => 'Take Away',
                                        'dine_in' => 'Dine In',
                                    ])
                                    ->required()
                                    ->placeholder('Pilih Jenis Penjualan'),

                                TextInput::make('tagihan')->default(0)->hidden(),
                                TextInput::make('status')->default('pesan')->hidden(),
                            ])
                            ->columns(3)
                            ->collapsible()
                    ]),

                Wizard\Step::make('Pilih Menu')
                    ->schema([
                        Repeater::make('items')
                            ->relationship('penjualanMenu')
                            ->schema([
                                Select::make('menu_id')
                                    ->label('Menu')
                                    ->options(
                                        Menu::where('stok', '>', 0)->pluck('nama_menu', 'id')->toArray()
                                    )
                                    ->required()
                                    ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, $set) {
                                        $menu = Menu::find($state);
                                        $set('harga_beli', $menu?->harga_menu ?? 0);
                                        $set('harga_jual', $menu ? $menu->harga_menu * 1.2 : 0);
                                    })
                                    ->searchable(),

                                TextInput::make('harga_beli')
                                    ->label('Harga Beli')
                                    ->numeric()
                                    ->readonly()
                                    ->dehydrated()
                                    ->hidden(),

                                TextInput::make('harga_jual')
                                    ->label('Harga Menu')
                                    ->numeric()
                                    ->readonly()
                                    ->dehydrated(),

                                TextInput::make('jml')
                                    ->label('Jumlah')
                                    ->numeric()
                                    ->default(1)
                                    ->minValue(1)
                                    ->required()
                                    ->reactive(),

                                TextInput::make('catatan_menu')
                                    ->label('Catatan Menu')
                                    ->placeholder('Masukkan Catatan Menu'),

                                DatePicker::make('tgl')
                                    ->default(today())
                                    ->required(),
                            ])
                            ->columns(['md' => 4])
                            ->addable()
                            ->deletable()
                            ->reorderable()
                            ->createItemButtonLabel('Tambah Item')
                            ->minItems(1)
                            ->required(),

                        Actions::make([
                            FormAction::make('Simpan Sementara')
                                ->label('Proses')
                                ->color('primary')
                                ->action(function ($get) {
                                    $penjualan = Penjualan::updateOrCreate(
                                        ['no_faktur' => $get('no_faktur')],
                                        [
                                            'tgl' => $get('tgl'),
                                            'nama_pembeli' => $get('nama_pembeli'),
                                            'email' => $get('email'),
                                            'jenis_penjualan' => $get('jenis_penjualan'),
                                            'status' => 'pesan',
                                            'tagihan' => 0,
                                            'user_id' => auth()->id(),
                                        ]
                                    );

                                    foreach ($get('items') as $item) {
                                        PenjualanMenu::updateOrCreate(
                                            [
                                                'penjualan_id' => $penjualan->id,
                                                'menu_id' => $item['menu_id']
                                            ],
                                            [
                                                'harga_beli' => $item['harga_beli'],
                                                'harga_jual' => $item['harga_jual'],
                                                'jml' => (int) ($item['jml'] ?? 0),
                                                'catatan_menu' => $item['catatan_menu'] ?? '',
                                                'tgl' => $item['tgl'],
                                            ]
                                        );

                                        $menu = Menu::find($item['menu_id']);
                                        if ($menu) {
                                            $menu->decrement('stok', (int) ($item['jml'] ?? 0));
                                        }
                                    }

                                    $totalTagihan = PenjualanMenu::where('penjualan_id', $penjualan->id)
                                        ->sum(DB::raw('harga_jual * jml'));
                                    $penjualan->update(['tagihan' => $totalTagihan]);
                                }),
                        ]),
                    ]),

                Wizard\Step::make('Pembayaran')
                    ->schema([
                        Placeholder::make('Tabel Pembayaran')
                            ->content(fn (Get $get) => view('filament.components.penjualan-table', [
                                'pembayarans' => Penjualan::where('no_faktur', $get('no_faktur'))->get(),
                            ])),
                    ]),
            ])->columnSpan(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('no_faktur')->label('No Faktur')->searchable(),
                TextColumn::make('nama_pembeli')->label('Nama Pembeli')->sortable()->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'bayar' => 'success',
                        'pesan' => 'warning',
                        default => 'gray',
                    }),
                TextColumn::make('tagihan')
                    ->formatStateUsing(fn ($state) => rupiah($state))
                    ->alignment('end')
                    ->sortable(),
                TextColumn::make('jenis_penjualan')->label('Jenis Penjualan')->sortable()->searchable(),
                TextColumn::make('created_at')->label('Tanggal')->dateTime(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Filter Status')
                    ->options([
                        'pesan' => 'Pemesanan',
                        'bayar' => 'Pembayaran',
                    ])
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->headerActions([
                Tables\Actions\Action::make('downloadPdf')
                    ->label('Unduh PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('success')
                    ->action(function () {
                        $penjualan = Penjualan::with('penjualanMenu.menu')->get();
                        $pdf = Pdf::loadView('pdf.penjualan', ['penjualan' => $penjualan]);
                        return response()->streamDownload(
                            fn () => print($pdf->output()),
                            'penjualan-list.pdf'
                        );
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPenjualans::route('/'),
            'create' => Pages\CreatePenjualan::route('/create'),
            'edit' => Pages\EditPenjualan::route('/{record}/edit'),
        ];
    }
}
