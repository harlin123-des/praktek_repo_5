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

use App\Filament\Resources\PresensiResource\RelationManagers;
use App\Models\Presensi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\{TextInput, Select, DatePicker};
use Filament\Tables\Columns\{TextColumn, BadgeColumn};


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



    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Transaksi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
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

                TextColumn::make('pegawai.nama')
                    ->label('Nama Pegawai')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->date()
                    ->sortable(),
                TextColumn::make('jam_masuk')
                    ->label('Jam Masuk')
                    ->sortable(),
                TextColumn::make('jam_keluar')
                    ->label('Jam Keluar')
                    ->sortable(),
                BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'success' => 'Hadir',
                        'warning' => 'Tidak Hadir',
                    ]),
                TextColumn::make('keterangan')
                    ->label('Keterangan'),
            ])
            ->filters([
                // Tambahkan filter jika diperlukan
            ])
            ->actions([
            ])
            ->bulkActions([
                // Tidak ada aksi hapus
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
            'index' => Pages\ListPresensis::route('/'),
        ];
    }

}

}
