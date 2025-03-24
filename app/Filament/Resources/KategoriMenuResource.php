<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KategoriMenuResource\Pages;
use App\Filament\Resources\KategoriMenuResource\RelationManagers;
use App\Models\KategoriMenu;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Components\TextInput;
// use Filament\Forms\Components\InputMask;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

class KategoriMenuResource extends Resource
{
    protected static ?string $model = KategoriMenu::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('id_kategori')
                ->default(fn () => KategoriMenu::getKodeKategori()) // Ambil default dari method getKodeKategori
                ->label('ID Kategori')
                ->required()
                ->readonly(), // Membuat field menjadi read-only

                TextInput::make('nama_kategori')
                ->required()
                ->placeholder('Masukkan nama kategori'), // Placeholder untuk membantu pengguna

                TextInput::make('keterangan')
                ->required()
                ->placeholder('Masukkan keterangan kategori') // Placeholder untuk membantu pengguna
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id_kategori')
                    ->searchable(), // Agar bisa dicari

                TextColumn::make('nama_kategori')
                    ->searchable()
                    ->sortable(), // Bisa diurutkan

                TextColumn::make('keterangan')
                    ->searchable(), // Bisa dicari
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListKategoriMenus::route('/'),
            'create' => Pages\CreateKategoriMenu::route('/create'),
            'edit' => Pages\EditKategoriMenu::route('/{record}/edit'),
        ];
    }
}
