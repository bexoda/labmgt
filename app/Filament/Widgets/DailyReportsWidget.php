<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\PlantSourceResource;
use App\Models\PlantSource;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\Summarizers\Average;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Indicator;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Contracts\Database\Eloquent\Builder;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class DailyReportsWidget extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                PlantSourceResource::getEloquentQuery())
            ->defaultPaginationPageOption(5)
            ->defaultSort('name', 'asc')
            ->columns([
                // TextColumn::make('id')
                // ->searchable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('labrequests_count')->counts('labrequests')
                    ->label('Number of Samples Received')
                    ->summarize([
                        Sum::make(),
                        Average::make(),
                    ]),
                // TextColumn::make('labrequests.created_at')
                // ->label('Number of Samples Received'),
            ])
            ->filters([
                // SelectFilter::make('name')
                // ->options(fn (): array => PlantSource::query()->pluck('name', 'id')->all())->label('Plant Source'),
                SelectFilter::make('name')
                    ->multiple()
                    ->options([
                        'crushing plant' => 'Crushing Plant',
                        'geology' => 'Geology',
                        'shipment sample' => 'Shipment Sample',
                        'special' => 'Special',
                        'truck sample' => 'Truck Sample',
                    ])->label('Plant Source'),
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from')->native(false)->displayFormat('D, jS M Y')->closeOnDateSelection()->default(now()->startofMonth()),
                        DatePicker::make('created_until')->native(false)->displayFormat('D, jS M Y')->closeOnDateSelection()->default(now()->endofMonth()),
                    ])->columns(2)->columnSpan(2)
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if ($data['created_from'] ?? null) {
                            $indicators[] = Indicator::make('Created from '.Carbon::parse($data['created_from'])->toFormattedDateString())
                                ->removeField('created_from');
                        }

                        if ($data['created_until'] ?? null) {
                            $indicators[] = Indicator::make('Created until '.Carbon::parse($data['created_until'])->toFormattedDateString())
                                ->removeField('created_until');
                        }

                        return $indicators;
                    }),
            ], layout: FiltersLayout::AboveContentCollapsible)->filtersFormColumns(3)
            ->bulkActions([
                // BulkAction::make('Print'),
                ExportBulkAction::make(),
            ]);

    }
}
