<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PembelianBahanBakuResource\Pages;
use App\Models\PembelianBahanBaku;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Set;

class PembelianBahanBakuResource extends Resource
{
    protected static ?string $model = PembelianBahanBaku::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationGroup = 'Transaksi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('Informasi Vendor')->schema([
                        Select::make('vendor_id')
                            ->relationship('vendor', 'nama_vendor')
                            ->required()
                            ->label('Pilih Vendor'),
                        DatePicker::make('tanggal')
                            ->required()
                            ->label('Tanggal Pembelian'),
                    ]),

                    Step::make('Detail Pembelian')->schema([
                        Repeater::make('details')
                            ->relationship()
                            ->schema([
                                Select::make('bahan_baku_id')
                                    ->relationship('bahanBaku', 'nama')
                                    ->required()
                                    ->label('Bahan Baku'),
                                TextInput::make('jumlah')
                                    ->numeric()
                                    ->required()
                                    ->label('Jumlah'),
                                TextInput::make('harga_satuan')
                                    ->numeric()
                                    ->required()
                                    ->label('Harga Satuan'),
                            ])
                           ->afterStateUpdated(function ($state, Set $set) {
                                $total = collect($state)->sum(function ($item) {
                                    return ($item['jumlah'] ?? 0) * ($item['harga_satuan'] ?? 0);
                                });
                                $set('total_pembelian', $total);
                            })
                            ->createItemButtonLabel('Tambah Item')
                            ->label('Daftar Bahan Baku'),
                    ]),

                    Step::make('Review & Total')->schema([
                        TextInput::make('total_pembelian')
                            ->disabled()
                            ->numeric()
                            ->dehydrated()
                            ->reactive()
                            ->label('Total Pembelian (otomatis)'),
                    ]),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('vendor.nama_vendor')->label('Vendor'),
                TextColumn::make('tanggal')->date()->label('Tanggal Pembelian'),
                TextColumn::make('total_pembelian')->money('IDR')->label('Total Pembelian'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPembelianBahanBakus::route('/'),
            'create' => Pages\CreatePembelianBahanBaku::route('/create'),
            'edit' => Pages\EditPembelianBahanBaku::route('/{record}/edit'),
        ];
    }

    public static function mutateFormDataBeforeCreate(array $data): array
    {
        $total = 0;

        foreach ($data['details'] as $detail) {
            $total += $detail['harga_satuan'] * $detail['jumlah'];
        }

        $data['total_pembelian'] = $total;

        return $data;
    }

    public static function mutateFormDataBeforeSave(array $data): array
    {
        $total = 0;

        foreach ($data['details'] as $detail) {
            $total += $detail['harga_satuan'] * $detail['jumlah'];
        }

        $data['total_pembelian'] = $total;

        return $data;
    }
}
