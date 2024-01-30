<?php

namespace App\Filament\Widgets;

use Filament\Tables\Table;
use App\Models\PlantSource;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\Summarizers\Count;
use App\Filament\Resources\PlantSourceResource;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Columns\Summarizers\Average;

class DailyReportsWidget extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                PlantSourceResource::getEloquentQuery())
            ->defaultPaginationPageOption(5)
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('name')
                ->searchable(),
            TextColumn::make('labrequests_count')->counts('labrequests')
                ->label('Number of Samples Received')
                ->summarize([
                    Sum::make(),
                    Average::make(),
                    ]),
                    TextColumn::make('labrequests.created_at'),
                    // ->label('Number of Samples Received'),
            ])
            ->filters([
                Filter::make('name')
                    ->query(fn (Builder $query) => $query->where('Crushing Plant', true)),
                    SelectFilter::make('name')
                    ->options(fn (): array => PlantSource::query()->pluck('name', 'id')->all())->label('Plant Source'),
                    // SelectFilter::make('status')
                    // ->options([
                    //     'draft' => 'Draft',
                    //     'reviewing' => 'Reviewing',
                    //     'published' => 'Published',
                    // ]),
            ], layout: FiltersLayout::AboveContent);
    }
}
