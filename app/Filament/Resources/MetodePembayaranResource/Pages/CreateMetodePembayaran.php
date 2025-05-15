<?php

namespace App\Filament\Resources\MetodePembayaranResource\Pages;

use App\Filament\Resources\MetodePembayaranResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMetodePembayaran extends CreateRecord
{
    protected static string $resource = MetodePembayaranResource::class;

    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction(), // Hanya menampilkan tombol "Create"
            $this->getCancelFormAction(), // Tombol "Cancel"
        ];
    }
}
