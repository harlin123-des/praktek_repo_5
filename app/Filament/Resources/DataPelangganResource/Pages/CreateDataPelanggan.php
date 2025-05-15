<?php

namespace App\Filament\Resources\DataPelangganResource\Pages;

use App\Filament\Resources\DataPelangganResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDataPelanggan extends CreateRecord
{
    protected static string $resource = DataPelangganResource::class;

    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction(), // Hanya tombol "Create"
            $this->getCancelFormAction(), // Tombol "Cancel"
        ];
    }
}
