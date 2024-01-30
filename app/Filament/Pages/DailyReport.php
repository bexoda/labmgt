<?php

namespace App\Filament\Pages;

use App\Filament\Resources\LabRequestResource\Pages\ListLabRequests;
use App\Filament\Widgets\DailyReportsWidget;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Pages\Page;

class DailyReport extends Page
{
    // use ExposesTableToWidgets;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.daily-report';

    // protected static ?string $title = 'Custom Page Title';

    protected static ?string $navigationGroup = 'Reports';

    // protected function getTablePage(): string
    // {
    //     return ListLabRequests::class;
    // }

    protected function getHeaderWidgets(): array
    {
        return [
            DailyReportsWidget::class,
        ];
    }

    public function getExtraBodyAttributes(): array
    {
        return [
            'class' => 'settings-page',
        ];
    }
}
