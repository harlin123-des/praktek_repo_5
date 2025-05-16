<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PegawaiResource\Pages;


use App\Filament\Resources\PegawaiResource\RelationManagers;

use App\Models\Pegawai;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;


use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Components\{TextInput, Select, DatePicker};
use Filament\Tables\Columns\{TextColumn, BadgeColumn};

class PegawaiResource extends Resource
{
    protected static ?string $model = Pegawai::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('id')
                    ->label('ID Pegawai')

                    ->default(fn() => Pegawai::generateKodePegawai()) // Panggil method static yang benar
                    ->required()
                    ->disabledOn('edit') // hanya isi saat create

                    ->default(fn() => Pegawai::getKodePegawai())
                    ->required()
                    ->disabledOn('edit')

                    ->placeholder('ID Pegawai akan diisi otomatis'),

                TextInput::make('nama')
                    ->label('Nama Pegawai')
                    ->required()
                    ->placeholder('Masukkan nama pegawai'),


                TextInput::make('email')
                    ->label('Email')
                    ->required()
                    ->email()
                    ->placeholder('Masukkan email pegawai')
                    ->visibleOn('create'),

                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->required()
                    ->placeholder('Masukkan password user')
                    ->visibleOn('create'),


                Select::make('jenis_kelamin')
                    ->options([
                        'Laki-laki' => 'Laki-laki',
                        'Perempuan' => 'Perempuan',
                    ])
                    ->required()
                    ->label('Jenis Kelamin'),

                TextInput::make('no_hp')
                    ->label('No. HP')
                    ->tel()
                    ->required()
                    ->placeholder('Contoh: 081234567890'),

                TextInput::make('posisi')
                    ->label('Posisi')
                    ->required()
                    ->placeholder('Contoh: Staff Gudang'),

                Select::make('shift')
                    ->options([
                        'Pagi' => 'Pagi',
                        'Sore' => 'Sore',
                    ])
                    ->required()
                    ->label('Shift'),

                DatePicker::make('tanggal_masuk')
                    ->label('Tanggal Masuk')
                    ->required(),

                Select::make('status_karyawan')
                    ->options([
                        'Tetap' => 'Tetap',
                        'Kontrak' => 'Kontrak',
                    ])
                    ->label('Status Karyawan')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID Pegawai')
                    ->sortable(),

                TextColumn::make('nama')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('jenis_kelamin')
                    ->label('Jenis Kelamin'),

                TextColumn::make('no_hp')
                    ->label('No. HP'),

                TextColumn::make('posisi')
                    ->label('Posisi'),

                TextColumn::make('shift')
                    ->label('Shift'),

                TextColumn::make('tanggal_masuk')
                    ->label('Masuk')
                    ->date()
                    ->sortable(),

                BadgeColumn::make('status_karyawan')
                    ->label('Status')
                    ->colors([
                        'success' => 'Tetap',
                        'warning' => 'Kontrak',
                    ]),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime()
                    ->sortable(),
            ])


            ->filters([
                //
            ])

            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([

                Tables\Actions\DeleteBulkAction::make(),

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
            'index' => Pages\ListPegawais::route('/'),
            'create' => Pages\CreatePegawai::route('/create'),
            'edit' => Pages\EditPegawai::route('/{record}/edit'),
        ];
    }
}
