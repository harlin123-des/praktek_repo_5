<?php

namespace App\Filament\Resources; //bagian dari Filament Admin Panel yang digunakan untuk membuat dan mengelola resource "Menu" dalam aplikasi Laravel.

use App\Filament\Resources\MenuResource\Pages;
use App\Filament\Resources\MenuResource\RelationManagers;
use App\Models\Menu;
use Filament\Forms; 
use Filament\Forms\Form; 
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Components\TextInput; 

use Filament\Forms\Components\Select; //menginput select diformn
use Filament\Forms\Components\FileUpload; 
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

class MenuResource extends Resource 
{
    protected static ?string $model = Menu::class; 
    protected static ?string $navigationIcon = 'heroicon-o-pencil-square'; 
    public static function form(Form $form): Form 
    {
        return $form
            ->schema([
                TextInput::make('id_menu')
                ->default(fn () => Menu::getIdMenu()) 
                ->label('Id Menu') 
                ->required()
                ->readonly() 
            ,
            TextInput::make('nama_menu')
                ->required()
                ->placeholder('Masukkan nama menu')  
            ,
            TextInput::make('harga_menu')
                ->numeric() 
                ->required()
                ->minValue(0) 
                ->reactive() 
                ->extraAttributes(['id' => 'harga-menu'])  
                ->placeholder('Masukkan harga menu') 
                ->live() 
                ->afterStateUpdated(fn ($state, callable $set) =>  
                    $set('harga_menu', number_format((int) str_replace('.', '', $state), 0, ',', '.'))
                )  
            ,
            FileUpload::make('foto')
                ->directory('foto') 
                ->image()
                ->required()
            ,
            TextInput::make('stok')
                ->required()
                ->placeholder('Masukkan stok menu') 
                ->minValue(0)
            ,
            TextInput::make('satuan')
                ->required()
                ->placeholder('Masukkan satuan') 
                ->minValue(0)
            ,
            Select::make('status')  
                ->label('status') 
                ->options([
                'Aktif' => 'Aktif',
                'Tidak Aktif' => 'Tidak Aktif',
                ])
                ->required()                  
          ,
            Textarea::make('deskripsi')
            ->label('Deskripsi')
            ->maxLength(500)  
            ->required()
            ,
            ]);
    }

    public static function table(Table $table): Table //untuk mendefinisikan dan mengonfigurasi tampilan tabel dalam aplikasi Laravel
    {
        return $table
            ->columns([
            TextColumn::make('id_menu')
                ->searchable(),
           
            TextColumn::make('nama_menu')
                ->searchable() 
                ->sortable(),
            TextColumn::make('harga_menu')
                ->label('Harga Menu')
                ->formatStateUsing(fn (string|int|null $state): string => 'Rp ' . number_format((int) $state, 0,',', '.'))
                ->extraAttributes(['class' => 'text-right']) 
                ->sortable(),
            TextColumn::make('status')
                ->label('status')
                ->badge() 
                ->color(fn (string $state): string => match ($state) { 
                    'Tidak Aktif' => 'danger',
                    'Aktif' => 'info',
        
}),
            TextColumn::make('Deskripsi')
                ->label('Deskripsi'),

            ImageColumn::make('foto'),
            TextColumn::make('stok'),
            TextColumn::make('satuan'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array //mendefinisikan dan mengembalikan hubungan (relations) antara model dalam aplikasi Laravel,
    {
        return [
            //
        ];
    }

    public static function getPages(): array//deklarasi fungsi yang mengembalikan sebuah array yang berisi halaman-halaman yang dapat diakses
    {//get pages mendaftarkan halaman
        return [
            'index' => Pages\ListMenus::route('/'), 
            'create' => Pages\CreateMenu::route('/create'), 
            'edit' => Pages\EditMenu::route('/{record}/edit'), 
        ];
    }
}
