<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaults = [
            // Site identity
            'site_name' => 'MTsN 5 Tanah Laut',
            'site_tagline' => 'Madrasah Tsanawiyah Negeri 5 Tanah Laut - Beriman, Berilmu, Berakhlak Mulia',
            'site_description' => 'Website resmi MTsN 5 Tanah Laut, Kalimantan Selatan.',
            'site_keywords' => 'madrasah, MTsN, Tanah Laut, pendidikan, Islam',

            // Contact
            'school_phone' => '0512-XXXXXX',
            'school_email' => 'info@mtsn5tanahlaut.sch.id',
            'school_address' => 'Kabupaten Tanah Laut, Kalimantan Selatan',
            'school_acronym' => 'MAN 5 TLA',

            // Social media
            'instagram_url' => '#',
            'youtube_channel' => '',
            'facebook_page' => '',
            'tiktok_username' => '',

            // Academics
            'academic_year' => '2026/2027',
            'school_npsn' => '',
            'school_status' => 'Negeri',
        ];

        foreach ($defaults as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                [
                    'value' => $value,
                    'type' => 'textarea' === in_array($key, ['site_description', 'school_address']) ? 'textarea' : 'text',
                    'description' => "Default {$key}",
                ]
            );
        }
    }
}
