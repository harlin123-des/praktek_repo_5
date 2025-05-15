<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CoaResource\Pages;
use App\Filament\Resources\CoaResource\RelationManagers;
use App\Models\Coa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CoaResource extends Resource
{
    protected static ?string $model = Coa::class;
    protected static ?string $navigationIcon = 'heroicon-o-folder-open';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('kode_akun')
                ->required()
                ->unique()
                ->label('Kode Akun'),

            Forms\Components\TextInput::make('header_akun')
                ->required(),

            Forms\Components\TextInput::make('nama_akun')
                ->required(),

            Forms\Components\Toggle::make('posisi_debit')
                ->label('Posisi Debit'),

            Forms\Components\Toggle::make('posisi_kredit')
                ->label('Posisi Kredit'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('kode_akun')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('header_akun'),
            Tables\Columns\TextColumn::make('nama_akun'),
            Tables\Columns\IconColumn::make('posisi_debit')->boolean(),
            Tables\Columns\IconColumn::make('posisi_kredit')->boolean(),
        ])->filters([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCoas::route('/'),
            'create' => Pages\CreateCoa::route('/create'),
            'edit' => Pages\EditCoa::route('/{record}/edit'),
        ];
    }
}