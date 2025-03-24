<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KategoriProdukResource\Pages;
use App\Filament\Resources\KategoriProdukResource\RelationManagers;
use App\Models\KategoriProduk;
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

class KategoriProdukResource extends Resource
{
    protected static ?string $model = KategoriProduks::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('kode_produk')
                ->default(fn() => KategoriProduk::getKodeKategori()) // Auto-generate kode produk
                ->label('Kode Produk')
                ->required()
                ->readonly(),
                
                TextInput::make('nama_produk')
                ->label('Nama Produk')
                ->required()
                ->placeholder('Masukkan nama produk'),
                
                NumberInput::make('harga_produk')
                ->label('Harga Produk')
                ->required()
                ->placeholder('Masukkan harga produk'),
                
                NumberInput::make('stok')
                ->label('Stok Produk')
                ->required()
                ->placeholder('Masukkan jumlah stok'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kode_produk')
                ->searchable(),

                TextColumn::make('nama_produk')
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
            'index' => Pages\ListKategoriProduks::route('/'),
            'create' => Pages\CreateKategoriProduk::route('/create'),
            'edit' => Pages\EditKategoriProduk::route('/{record}/edit'),
        ];
    }
}
