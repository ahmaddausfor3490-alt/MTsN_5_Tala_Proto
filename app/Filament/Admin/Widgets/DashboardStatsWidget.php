<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Announcement;
use App\Models\ContactMessage;
use App\Models\Gallery;
use App\Models\Post;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Berita', Post::count())
                ->description('Total berita/artikel')
                ->descriptionIcon('heroicon-o-newspaper'),

            Stat::make('Pengumuman', Announcement::count())
                ->description('Total pengumuman')
                ->descriptionIcon('heroicon-o-megaphone'),

            Stat::make('Pesan Kontak', ContactMessage::count())
                ->description('Total pesan masuk')
                ->descriptionIcon('heroicon-o-envelope'),

            Stat::make('Galeri', Gallery::count())
                ->description('Total foto galeri')
                ->descriptionIcon('heroicon-o-photo'),
        ];
    }
}
