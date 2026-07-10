<?php

namespace App\Support;

final class Navigation
{
    public static function items(): array
    {
        return [
            ['key' => 'home', 'label' => 'Beranda', 'href' => '/', 'active' => true],
            ['key' => 'profile', 'label' => 'Profil', 'href' => '/profile'],
            ['key' => 'vm', 'label' => 'Visi & Misi', 'href' => '/visi-misi'],
            ['key' => 'teachers', 'label' => 'Guru & Staf', 'href' => '/guru-staf'],
            ['key' => 'news', 'label' => 'Berita', 'href' => '/berita'],
            ['key' => 'agenda', 'label' => 'Agenda', 'href' => '/agenda'],
            ['key' => 'downloads', 'label' => 'Unduhan', 'href' => '/unduh'],
            ['key' => 'faq', 'label' => 'FAQ', 'href' => '/faq'],
            ['key' => 'contact', 'label' => 'Hubungi Kami', 'href' => route('contact')],
        ];
    }

    public static function setActive(string $key): array
    {
        return array_map(function ($item) use ($key) {
            if (($item['key'] ?? '') === $key) {
                $item['active'] = true;
            } else {
                unset($item['active']);
            }
            return $item;
        }, static::items());
    }
}
