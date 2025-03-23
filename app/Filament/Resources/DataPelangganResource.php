<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DataPelangganResource\Pages;
use App\Models\DataPelanggan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;

class DataPelangganResource extends Resource
{
    protected static ?string $model = DataPelanggan::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_pelanggan')
                    ->label('Nama Pelanggan')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id_pelanggan')
                    ->label('ID Pelanggan')
                    ->sortable(),

                Tables\Columns\TextColumn::make('nama_pelanggan')
                    ->label('Nama Pelanggan')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDataPelanggan::route('/'),
            'create' => Pages\CreateDataPelanggan::route('/create'),
            'edit' => Pages\EditDataPelanggan::route('/{record}/edit'),
        ];
    }
}
