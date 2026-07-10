<?php

namespace Tests\Feature;

use App\Models\Setting;
use Tests\TestCase;

class SettingFormTest extends TestCase
{
    public function test_create_setting_saves_value_correctly(): void
    {
        // Direct model test - skip Livewire/Filament for now
        $setting = Setting::create([
            'key' => 'test_number_direct',
            'label' => 'Test Number Direct',
            'type' => 'number',
            'value' => '1250',
            'options' => '',
        ]);

        $this->assertEquals('1250', $setting->value);
        $this->assertEquals('number', $setting->type);

        // Re-read from DB
        $saved = Setting::where('key', 'test_number_direct')->first();
        $this->assertEquals('1250', $saved->value);
        $this->assertEquals('number', $saved->type);
    }

    public function test_integer_value_saved_as_string(): void
    {
        $setting = Setting::create([
            'key' => 'test_int_direct',
            'label' => 'Test Int Direct',
            'type' => 'number',
            'value' => 1250, // int, not string
            'options' => '',
        ]);

        $saved = Setting::where('key', 'test_int_direct')->first();
        $this->assertEquals('1250', $saved->value);
    }
}
