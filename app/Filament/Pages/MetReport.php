<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\MetReportsWidget;
use Filament\Pages\Page;

class MetReport extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.met-report';

    // protected static ?string $title = 'Custom Page Title';

    protected static ?string $navigationGroup = 'Reports';

    // protected function getTablePage(): string
    // {
    //     return ListLabRequests::class;
    // }

    protected function getHeaderWidgets(): array
    {
        return [
            MetReportsWidget::class,
        ];
    }
}
