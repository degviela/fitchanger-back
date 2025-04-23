<?php

namespace App\Filament\Resources\OutfitResource\Pages;

use App\Filament\Resources\OutfitResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOutfits extends ListRecords
{
    protected static string $resource = OutfitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
