<?php

namespace App\Filament\Resources;

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
// use Filament\Forms\Components\InputMask;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload; //untuk tipe file
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

class MenuResource extends Resource
{
    protected static ?string $model = Menu::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('id_menu')
                ->default(fn () => Menu::getIdMenu()) // Ambil default dari method getIdMenu
                ->label('Id Menu')
                ->required()
                ->readonly() // Membuat field menjadi read-only
            ,
            TextInput::make('nama_menu')
                ->required()
                ->placeholder('Masukkan nama menu') // Placeholder untuk membantu pengguna
            ,
            TextInput::make('harga_menu')
                ->numeric() // Pastikan input hanya angka
                ->required()
                ->minValue(0) // Nilai minimal 0 (opsional jika tidak ingin ada harga negatif)
                ->reactive() // Menjadikan input reaktif terhadap perubahan
                ->extraAttributes(['id' => 'harga-menu']) // Tambahkan ID untuk pengikatan JavaScript
                ->placeholder('Masukkan harga menu') // Placeholder untuk membantu pengguna
                ->live()
                ->afterStateUpdated(fn ($state, callable $set) => 
                    $set('harga_menu', number_format((int) str_replace('.', '', $state), 0, ',', '.'))
                )
            ,
            FileUpload::make('foto')
                ->directory('foto')
                ->required()
            ,
            TextInput::make('stok')
                ->required()
                ->placeholder('Masukkan stok menu') // Placeholder untuk membantu pengguna
                ->minValue(0)
            ,
            TextInput::make('satuan')
                ->required()
                ->placeholder('Masukkan satuan') // Placeholder untuk membantu pengguna
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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id_menu')
                ->searchable(),
            // agar bisa di search
            TextColumn::make('nama_menu')
                ->searchable()
                ->sortable(),
            TextColumn::make('harga_menu')
                ->label('Harga Menu')
                ->formatStateUsing(fn (string|int|null $state): string => 'Rp ' . number_format((int) $state, 0,',', '.'))
                ->extraAttributes(['class' => 'text-right']) // Tambahkan kelas CSS untuk rata kanan
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMenus::route('/'),
            'create' => Pages\CreateMenu::route('/create'),
            'edit' => Pages\EditMenu::route('/{record}/edit'),
        ];
    }
}
