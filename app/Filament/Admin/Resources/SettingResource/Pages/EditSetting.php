<?php

namespace App\Filament\Admin\Resources\SettingResource\Pages;

use App\Filament\Admin\Resources\SettingResource;
use App\Models\Setting;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSetting extends EditRecord
{
    protected static string $resource = SettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Translate DB 'value' to unique field names for form pre-fill
        $mapping = [
            'text' => 'value', 'number' => 'value',
            'email' => 'value', 'url' => 'value',
            'textarea' => 'value_textarea',
            'file' => 'value_file', 'image' => 'value_file',
            'boolean' => 'value_boolean', 'select' => 'value_select',
        ];
        $type = $data['type'] ?? '';
        if (isset($mapping[$type]) && isset($data['value'])) {
            $data[$mapping[$type]] = $data['value'];
        }
        unset($data['value']);
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
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
        } elseif (! in_array($type, ['textarea', 'file', 'image', 'boolean', 'select'])) {
            // text/number/email/url use the single 'value' field — no consolidation needed
        } else {
            $data['value'] = null;
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
