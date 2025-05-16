<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PresensiResource\Pages;
use App\Models\Presensi;
use App\Models\Pegawai;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class PresensiResource extends Resource
{
    protected static ?string $model = Presensi::class;
    protected static ?string $navigationIcon = 'heroicon-o-clock';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\DatePicker::make('tanggal')->required(),
            Forms\Components\TextInput::make('jam_masuk'),
            Forms\Components\TextInput::make('jam_keluar'),
            Forms\Components\Select::make('status')->options([
                'Hadir' => 'Hadir',
                'Izin' => 'Izin',
                'Sakit' => 'Sakit',
                'Alpha' => 'Alpha',
            ]),
            Forms\Components\Textarea::make('keterangan'),
            Forms\Components\Select::make('pegawai_id')
                ->relationship('pegawai', 'nama')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tanggal')->date(),
                TextColumn::make('jam_masuk'),
                TextColumn::make('jam_keluar'),
                TextColumn::make('status'),
                TextColumn::make('keterangan'),
                TextColumn::make('pegawai.nama')->label('Nama Pegawai'),
            ])
            ->actions([]); // Kosongkan karena tombol sudah dipindah ke header
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPresensis::route('/'),
        ];
    }
}
