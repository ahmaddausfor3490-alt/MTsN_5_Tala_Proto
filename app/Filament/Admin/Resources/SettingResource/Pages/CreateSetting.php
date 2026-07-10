<?php

namespace App\Filament\Admin\Resources\SettingResource\Pages;

use App\Filament\Admin\Resources\SettingResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSetting extends CreateRecord
{
    protected static string $resource = SettingResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Consolidate unique value fields into 'value' based on selected type
        $type = $data['type'] ?? '';
        $inverseMapping = [
            'textarea' => 'value_textarea',
            'file' => 'value_file', 'image' => 'value_file',
            'boolean' => 'value_boolean', 'select' => 'value_select',
        ];

        if (isset($inverseMapping[$type]) && isset($data[$inverseMapping[$type]])) {
            $data['value'] = $data[$inverseMapping[$type]];
            unset($data[$inverseMapping[$type]]);
        }

        // Cast boolean explicitly
        if ($type === 'boolean') {
            $data['value'] = (bool) $data['value'];
        } else {
            $data['value'] = (string) ($data['value'] ?? '');
        }

        return $data;
    }
}
