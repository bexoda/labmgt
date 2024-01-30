<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LabResultResource\Pages;
use App\Models\LabResult;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class LabResultResource extends Resource
{
    protected static ?string $model = LabResult::class;

    protected static ?string $navigationIcon = 'heroicon-o-scale';

    protected static bool $shouldRegisterNavigation = true;

    protected static ?string $navigationGroup = 'Operations';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
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
                    ->numeric()
                    ->inputMode('decimal'),
                // ->maxLength(255),
                Forms\Components\TextInput::make('Sol_Mn')
                    ->numeric()
                    ->inputMode('decimal'),
                // ->maxLength(255),
                Forms\Components\TextInput::make('Fe')
                    ->numeric()
                    ->inputMode('decimal'),
                Forms\Components\TextInput::make('B')
                    ->numeric()
                    ->inputMode('decimal'),
                Forms\Components\TextInput::make('MnO2')
                    ->numeric()
                    ->inputMode('decimal'),
                Forms\Components\TextInput::make('SiO2')
                    ->numeric()
                    ->inputMode('decimal'),
                Forms\Components\TextInput::make('Al2O3')
                    ->numeric()
                    ->inputMode('decimal'),
                Forms\Components\TextInput::make('P')
                    ->numeric()
                    ->inputMode('decimal'),
                Forms\Components\TextInput::make('MgO')
                    ->numeric()
                    ->inputMode('decimal'),
                Forms\Components\TextInput::make('CaO')
                    ->numeric()
                    ->inputMode('decimal'),
                Forms\Components\TextInput::make('Au')
                    ->numeric()
                    ->inputMode('decimal'),
            ])->columns(5);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('time'),
                Tables\Columns\TextColumn::make('sample_name')
                    ->label('Sample Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('labRequest.id')
                    ->sortable()
                    ->searchable()
                    ->label('Job Number'),
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
                Tables\Filters\TrashedFilter::make(),

            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    ExportBulkAction::make(),
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
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
            'view' => Pages\ViewLabResult::route('/{record}'),
            'edit' => Pages\EditLabResult::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
