<?php

namespace App\Filament\Resources\KategoriProdukzResource\Pages;

use App\Filament\Resources\KategoriProdukzResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKategoriProdukz extends EditRecord
{
    protected static string $resource = KategoriProdukzResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
