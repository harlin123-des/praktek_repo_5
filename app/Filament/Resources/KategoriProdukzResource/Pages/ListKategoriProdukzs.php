<?php

namespace App\Filament\Resources\KategoriProdukzResource\Pages;

use App\Filament\Resources\KategoriProdukzResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKategoriProdukzs extends ListRecords
{
    protected static string $resource = KategoriProdukzResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
