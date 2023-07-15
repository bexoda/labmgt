<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\LabResult;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\TrashedFilter;
use App\Filament\Resources\LabResultResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\LabResultResource\RelationManagers;

class LabResultResource extends Resource
{
    protected static ?string $model = LabResult::class;

    protected static ?string $navigationIcon = 'heroicon-o-scale';

    protected static ?string $navigationGroup = 'Operations';

    protected static bool $shouldRegisterNavigation = true;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\Select::make('lab_request_id')
                //     ->relationship('labRequest', 'id')
                //     ->required(),
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Forms\Components\TextInput::make('Mn')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('Sol_Mn')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('Fe')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('B')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('MnO2')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('SiO2')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('Al2O3')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('P')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('MgO')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('CaO')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('Au')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('labRequest.client.name')
                    ->sortable()
                    ->searchable()
                    ->label('Client Name'),
                Tables\Columns\TextColumn::make('user.name')
                    ->sortable()
                    ->searchable()
                    ->label('Result Prepared by'),
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
                    ->dateTime('D jS M Y, G:i:s'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->sortable()
                    ->searchable()
                    ->toggleable()
                    ->dateTime('D jS M Y, G:i:s'),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->toggleable()
                    ->dateTime('D jS M Y, G:i:s'),
            ])
            ->filters([
                TrashedFilter::make()
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLabResults::route('/'),
            'create' => Pages\CreateLabResult::route('/create'),
            'edit' => Pages\EditLabResult::route('/{record}/edit'),
        ];
    }
}
