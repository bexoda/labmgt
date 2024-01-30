<?php

namespace App\Filament\Resources\LabRequestResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class LabResultsRelationManager extends RelationManager
{
    protected static string $relationship = 'labResults';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\Select::make('lab_request_id')
                //     ->relationship('labRequest', 'id')
                //     ->required(),
                Forms\Components\TimePicker::make('time')
                    ->default(now()),
                Forms\Components\TextInput::make('sample_name')
                    ->label('Sample Name'),
                Forms\Components\TextInput::make('Mn')
                    ->numeric(),
                Forms\Components\TextInput::make('Sol_Mn')
                    ->numeric(),
                Forms\Components\TextInput::make('Fe')
                    ->numeric(),
                Forms\Components\TextInput::make('B')
                    ->numeric(),
                Forms\Components\TextInput::make('MnO2')
                    ->numeric(),
                Forms\Components\TextInput::make('SiO2')
                    ->numeric(),
                Forms\Components\TextInput::make('Al2O3')
                    ->numeric(),
                Forms\Components\TextInput::make('P')
                    ->numeric(),
                Forms\Components\TextInput::make('MgO')
                    ->numeric(),
                Forms\Components\TextInput::make('CaO')
                    ->numeric(),
                Forms\Components\TextInput::make('Au')
                    ->numeric(),
            ])->columns(5);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('sampleId')
            ->columns([
                Tables\Columns\TextColumn::make('labRequest.id')
                    ->sortable()
                    ->searchable()
                    ->label('Job Number'),
                Tables\Columns\TextColumn::make('time'),
                Tables\Columns\TextColumn::make('sample_name')
                    ->label('Sample Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('labRequest.client.name')
                    ->sortable()
                    ->searchable()
                    ->label('Client Name'),
                Tables\Columns\TextColumn::make('Mn'),
                Tables\Columns\TextColumn::make('Sol_Mn'),
                Tables\Columns\TextColumn::make('Fe'),
                Tables\Columns\TextColumn::make('B'),
                Tables\Columns\TextColumn::make('MnO2'),
                Tables\Columns\TextColumn::make('SiO2'),
                Tables\Columns\TextColumn::make('Al2O3'),
                Tables\Columns\TextColumn::make('P'),
                Tables\Columns\TextColumn::make('MgO'),
                Tables\Columns\TextColumn::make('CaO'),
                Tables\Columns\TextColumn::make('Au'),
                Tables\Columns\TextColumn::make('created_at')
                    ->sortable()
                    ->searchable()
                    ->dateTime('D jS M Y, G:i:s')
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('updated_at')
                    ->sortable()
                    ->searchable()
                    ->toggleable()
                    ->dateTime('D jS M Y, G:i:s')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->toggleable()
                    ->dateTime('D jS M Y, G:i:s')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }
}
