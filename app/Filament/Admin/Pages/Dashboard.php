<?php

namespace App\Filament\Admin\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    /**
     * @return array<class-string<\Filament\Widgets\Widget>|string|null>
     */
    public function getWidgets(): array
    {
        return array_merge(
            parent::getWidgets(),
            [
                \App\Filament\Admin\Widgets\DashboardStatsWidget::class,
                \App\Filament\Admin\Widgets\StatsChartWidget::class,
            ]
        );
    }
}
