<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KategoriProdukzResource\Pages;
use App\Filament\Resources\KategoriProdukzResource\RelationManagers;
use App\Models\KategoriProdukz;
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


class KategoriProdukzResource extends Resource
{
    protected static ?string $model = KategoriProdukz::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('id')
                ->default(fn() => KategoriProdukz::getKodeKategori()) // Auto-generate kode produk
                ->label('id')
                ->required()
                ->readonly(),
                
                TextInput::make('nama_produk')
                ->required()
                ->label('Nama Produk'),
                
                TextInput::make('harga_produk')
                ->label('Harga Produk')
                ->required()
                ->placeholder('Masukkan harga produk'),
                
                TextInput::make('stok')
                ->label('Stok Produk')
                ->required()
                ->placeholder('Masukkan jumlah stok'),
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kode_produk')
                ->searchable(),

                TextInput::make('nama_produk')
                ->searchable()
                ->sortable(),

                TextColumn::make('harga_produk')
                ->sortable()
                ->label('Harga Produk')
                ->money('IDR'), // Format sebagai mata uang

                TextColumn::make('stok')
                ->sortable()
                ->label('Stok Produk'),
          
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
            'index' => Pages\ListKategoriProdukzs::route('/'),
            'create' => Pages\CreateKategoriProdukz::route('/create'),
            'edit' => Pages\EditKategoriProdukz::route('/{record}/edit'),
        ];
    }
}
