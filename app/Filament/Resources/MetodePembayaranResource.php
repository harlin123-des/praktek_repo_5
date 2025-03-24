<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MetodePembayaranResource\Pages;
use App\Models\MetodePembayaran;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;

class MetodePembayaranResource extends Resource
{
    protected static ?string $model = MetodePembayaran::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $navigationGroup = 'Metode Pembayaran';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_metode')
                    ->label('Nama Metode')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Select::make('metode')
                    ->label('Jenis Metode')
                    ->options([
                        'cash' => 'Cash',
                        'qris' => 'QRIS',
                    ])
                    ->required(),

                Forms\Components\Toggle::make('status')
                    ->label('Aktif')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_metode')
                    ->label('Nama Metode')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('metode')
                    ->label('Jenis Metode')
                    ->sortable(),

                Tables\Columns\IconColumn::make('status')
                    ->label('Status')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('metode')
                    ->label('Jenis Metode')
                    ->options([
                        'cash' => 'Cash',
                        'qris' => 'QRIS',
                    ]),
            ])
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
            'index' => Pages\ListMetodePembayarans::route('/'),
            'create' => Pages\CreateMetodePembayaran::route('/create'),
            'edit' => Pages\EditMetodePembayaran::route('/{record}/edit'),
        ];
    }
}
