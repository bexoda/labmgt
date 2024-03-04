<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use Filament\Forms\Get;
use App\Models\LabResult;
use Filament\Tables\Table;
use Illuminate\Support\Collection;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Indicator;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Columns\Summarizers\Sum;
use App\Filament\Resources\LabResultResource;
use App\Http\Controllers\DownloadPdfController;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Columns\Summarizers\Average;
use Illuminate\Contracts\Database\Eloquent\Builder;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class MetReportsWidget extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                LabResultResource::getEloquentQuery()
            )
            ->defaultPaginationPageOption(5)
            ->defaultSort('time', 'asc')
            ->columns([
                // TextColumn::make('time'),
                TextColumn::make('created_at')
                    ->label('Production Date')
                    // ->sortable()
                    // ->searchable()
                    ->dateTime('D jS M Y'),
                // ->toggleable(isToggledHiddenByDefault: false),
                // TextColumn::make('sample_name')
                //     ->label('Sample Name')
                //     ->searchable()
                //     ->sortable(),
                // TextColumn::make('labRequest.id')
                //     ->sortable()
                //     ->searchable()
                //     ->label('Job Number'),
                // TextColumn::make('labRequest.client.name')
                //     ->sortable()
                //     ->searchable()
                //     ->label('Client Name'),
                TextColumn::make('Al2O3')
                    ->label('Al2O3')
                    ->summarize([
                        Sum::make()->label('Total'),
                    ]),
                TextColumn::make('CaO')
                    ->label('CaO')
                    ->summarize([
                        Sum::make()->label('Total'),
                    ]),
                TextColumn::make('Fe')
                    ->summarize([
                        Sum::make()->label('Total'),
                    ]),
                TextColumn::make('MgO')
                    ->label('MgO')
                    ->summarize([
                        Sum::make()->label('Total'),
                    ]),
                TextColumn::make('Mn')
                    ->summarize([
                        Sum::make()->label('Total'),
                    ]),
                TextColumn::make('P')
                    ->summarize([
                        Sum::make()->label('Total'),
                    ]),
                TextColumn::make('SiO2')
                    ->label('SiO2')
                    ->summarize([
                        Sum::make()->label('Total'),
                    ]),
                // TextColumn::make('Sol_Mn'),
                // TextColumn::make('B'),
                // TextColumn::make('MnO2'),
                // TextColumn::make('Au'),
                // TextColumn::make('updated_at')
                //     ->sortable()
                //     ->searchable()
                //     ->toggleable()
                //     ->dateTime('D jS M Y, G:i:s')
                //     ->toggleable(isToggledHiddenByDefault: true),
                // TextColumn::make('deleted_at')
                //     ->toggleable()
                //     ->dateTime('D jS M Y, G:i:s')
                //     ->toggleable(isToggledHiddenByDefault: true),

                // TextColumn::make('id')
                // ->searchable(),
                // TextColumn::make('name')
                //     ->searchable(),
                // TextColumn::make('labrequests_count')->counts('labrequests')
                //     ->label('Number of Samples Received')
                //     ->summarize([
                //         Sum::make(),
                //         Average::make(),
                //     ]),
                // TextColumn::make('labrequests.created_at')
                // ->label('Number of Samples Received'),
            ])
            ->filters([
                // SelectFilter::make('name')
                // ->options(fn (): array => PlantSource::query()->pluck('name', 'id')->all())->label('Plant Source'),
                SelectFilter::make('labRequest.id')
                    // ->multiple()
                    ->preload()
                    ->relationship('labRequest', 'id')
                    ->label('Job Number'),
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from')->native(false)->displayFormat('D, jS M Y')->closeOnDateSelection()->default(now()->startofMonth()),
                        DatePicker::make('created_until')->native(false)->displayFormat('D, jS M Y')->closeOnDateSelection()->default(now()->endofMonth()),
                    ])->columns(2)->columnSpan(2)
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if ($data['created_from'] ?? null) {
                            $indicators[] = Indicator::make('Created from ' . Carbon::parse($data['created_from'])->toFormattedDateString())
                                ->removeField('created_from');
                        }

                        if ($data['created_until'] ?? null) {
                            $indicators[] = Indicator::make('Created until ' . Carbon::parse($data['created_until'])->toFormattedDateString())
                                ->removeField('created_until');
                        }

                        return $indicators;
                    }),
            ], layout: FiltersLayout::AboveContentCollapsible)->filtersFormColumns(3)
            ->bulkActions([
                // BulkAction::make('Print'),
                ExportBulkAction::make()
                    ->label('Export XLSX'),
                BulkAction::make('Download Pdf')
                    ->label('Download PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->action(fn(Collection $records, array $data) => (new DownloadPdfController())->download($records))
            ])->emptyStateHeading('No Met Report found.')->emptyStateDescription('Consider making changes to the filtered date range.');

    }
}
