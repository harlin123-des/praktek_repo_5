<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PenggajianResource\Pages;
use App\Models\Pegawai;
use App\Models\Penggajian;
use App\Models\Presensi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\{Select, TextInput, DatePicker};
use Filament\Tables\Columns\TextColumn;

class PenggajianResource extends Resource
{
    protected static ?string $model = Penggajian::class;
    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('pegawai_id')
                    ->label('Nama Pegawai')
                    ->options(Pegawai::all()->pluck('nama', 'id'))
                    ->searchable()
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn ($set, $get) => static::hitungTotalGaji($set, $get)),

                TextInput::make('bulan')
                    ->label('Bulan')
                    ->numeric()
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn ($set, $get) => static::hitungTotalGaji($set, $get)),

                TextInput::make('tahun')
                    ->label('Tahun')
                    ->numeric()
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn ($set, $get) => static::hitungTotalGaji($set, $get)),

                TextInput::make('gaji_pokok')
                    ->label('Gaji Pokok')
                    ->numeric()
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn ($set, $get) => static::hitungTotalGaji($set, $get)),

                TextInput::make('tunjangan')
                    ->label('Tunjangan')
                    ->numeric()
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn ($set, $get) => static::hitungTotalGaji($set, $get)),

                TextInput::make('potongan')
                    ->label('Potongan')
                    ->numeric()
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn ($set, $get) => static::hitungTotalGaji($set, $get)),

                TextInput::make('total_gaji')
                    ->label('Total Gaji')
                    ->numeric()
                    ->disabled()
                    ->dehydrated(true),

                DatePicker::make('created_at')
                    ->label('Tanggal Dibuat')
                    ->default(now())
                    ->disabled(),
            ]);
    }

    public static function hitungTotalGaji($set, $get)
    {
        $pegawaiId = $get('pegawai_id');
        $bulan = $get('bulan');
        $tahun = $get('tahun');
        $gajiPokok = (int) $get('gaji_pokok');
        $tunjangan = (int) $get('tunjangan');
        $potongan = (int) $get('potongan');

        if (!$pegawaiId || !$bulan || !$tahun || !$gajiPokok) {
            $set('total_gaji', 0);
            return;
        }

        // Hitung jumlah hari hadir
        $jumlahHadir = Presensi::where('pegawai_id', $pegawaiId)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->where('status', 'Hadir')
            ->count();

        // Hitung gaji harian, asumsi 30 hari kerja
        $gajiHarian = $gajiPokok / 30;
        $total = ($jumlahHadir * $gajiHarian) + $tunjangan - $potongan;

        $set('total_gaji', (int) $total);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('pegawai.nama')
                    ->label('Nama Pegawai')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('bulan')
                    ->label('Bulan')
                    ->sortable(),

                TextColumn::make('tahun')
                    ->label('Tahun')
                    ->sortable(),

                TextColumn::make('gaji_pokok')
                    ->label('Gaji Pokok')
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.'))
                    ->sortable(),

                TextColumn::make('tunjangan')
                    ->label('Tunjangan')
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.'))
                    ->sortable(),

                TextColumn::make('potongan')
                    ->label('Potongan')
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.'))
                    ->sortable(),

                TextColumn::make('total_gaji')
                    ->label('Total Gaji')
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.'))
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Tanggal Dibuat')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPenggajians::route('/'),
            'create' => Pages\CreatePenggajian::route('/create'),
            'edit' => Pages\EditPenggajian::route('/{record}/edit'),
        ];
    }
}
