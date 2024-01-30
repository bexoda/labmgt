<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LabRequestResource\Pages;
use App\Filament\Resources\LabRequestResource\RelationManagers\LabResultsRelationManager;
use App\Models\LabRequest;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class LabRequestResource extends Resource
{
    protected static ?string $model = LabRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-beaker';

    protected static ?string $navigationGroup = 'Operations';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Select::make('client_id')
                            ->relationship('client', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->createOptionForm([
                                Forms\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('name')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('email')
                                            ->email()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('phone_number')
                                            ->tel()
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('location')
                                            ->maxLength(255),
                                    ]),
                            ]),
                        Forms\Components\Select::make('department_id')
                            ->relationship('department', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\DatePicker::make('request_date')
                            ->required(),
                        Forms\Components\Select::make('delivered_by')
                            ->options(User::all()->pluck('name'))
                            ->searchable()
                            ->preload()
                            ->label('Delivered By'),
                        Forms\Components\DateTimePicker::make('time_delivered')
                            ->required(),
                        Forms\Components\TextInput::make('sample_number')
                            ->required()
                            ->numeric(),
                    ])->columns(2)
                    ->collapsible(),

                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Select::make('received_by')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->label('Received By'),
                        Forms\Components\DateTimePicker::make('time_received')
                            ->required(),
                        Forms\Components\Select::make('prepared_by')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->label('Prepared By'),
                        Forms\Components\DateTimePicker::make('time_prepared')
                            ->required(),
                        Forms\Components\DatePicker::make('production_date')
                            ->required(),
                        Forms\Components\DatePicker::make('date_reported')
                            ->required(),
                        Forms\Components\Select::make('weighed_by')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->label('Weighed By'),
                        Forms\Components\Select::make('digested_by')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->label('Digested By'),
                        Forms\Components\Select::make('entered_by')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->label('Entered By'),
                        Forms\Components\Select::make('titration_by')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->label('AAS/Titration By'),
                        Forms\Components\Select::make('plant_source_id')
                            ->relationship('plantSource', 'name')
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')->label('Name of Plant Source'),
                            ])
                            ->label('Plant Source'),
                        Forms\Components\RichEditor::make('description')
                            ->disableToolbarButtons([
                                'attachFiles',
                                // 'blockquote',
                                // 'bold',
                                // 'bulletList',
                                // 'codeBlock',
                                // 'h2',
                                // 'h3',
                                // 'italic',
                                // 'link',
                                // 'orderedList',
                                // 'redo',
                                // 'strike',
                                // 'undo',
                            ])
                            ->maxLength(65535)
                            ->columnSpanFull(),
                    ])->columns(2)
                    ->collapsible(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Job Number')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('client.name')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('department.name')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('request_date')
                    ->date()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('delivered_by')
                    ->searchable(),
                Tables\Columns\TextColumn::make('time_delivered')
                    ->dateTime()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sample_number')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('received_by')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('time_received')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('prepared_by')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('time_prepared')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('production_date')
                    ->date()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_reported')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('weighed_by')
                    ->searchable(),
                Tables\Columns\TextColumn::make('digested_by')
                    ->searchable(),
                Tables\Columns\TextColumn::make('entered_by')
                    ->searchable(),
                Tables\Columns\TextColumn::make('titration_by')
                    ->searchable(),
                Tables\Columns\TextColumn::make('plantSource.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
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
            LabResultsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLabRequests::route('/'),
            'create' => Pages\CreateLabRequest::route('/create'),
            'view' => Pages\ViewLabRequest::route('/{record}'),
            'edit' => Pages\EditLabRequest::route('/{record}/edit'),
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
