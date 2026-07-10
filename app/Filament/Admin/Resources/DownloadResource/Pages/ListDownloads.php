<?php

namespace App\Filament\Admin\Resources\DownloadResource\Pages;

use App\Filament\Admin\Resources\DownloadResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDownloads extends ListRecords
{
    protected static string $resource = DownloadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
