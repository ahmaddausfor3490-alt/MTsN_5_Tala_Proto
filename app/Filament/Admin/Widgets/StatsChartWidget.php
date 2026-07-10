<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Post;
use App\Models\Announcement;
use Filament\Widgets\ChartWidget;

class StatsChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Statistik Konten';

    protected static ?string $description = 'Ringkasan berita dan pengumuman';

    protected function getData(): array
    {
        $labels = ['Berita', 'Pengumuman'];
        $startOfMonth = now()->startOfMonth();

        // Count items created this month
        $newsCount = Post::whereBetween('created_at', [$startOfMonth, now()])
            ->count();

        $announcementCount = Announcement::whereBetween('created_at', [$startOfMonth, now()])
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Konten Dibuat',
                    'data' => [$newsCount, $announcementCount],
                    'backgroundColor' => ['#3b82f6', '#f59e0b'],
                    'borderColor' => ['#2563eb', '#d97706'],
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
