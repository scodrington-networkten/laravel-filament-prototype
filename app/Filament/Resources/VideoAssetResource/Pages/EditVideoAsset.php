<?php

namespace App\Filament\Resources\VideoAssetResource\Pages;

use App\Filament\Resources\VideoAssetResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVideoAsset extends EditRecord
{
    protected static string $resource = VideoAssetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
