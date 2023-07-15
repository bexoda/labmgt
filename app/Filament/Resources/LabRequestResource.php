<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LabRequestResource\Pages;
use App\Filament\Resources\LabRequestResource\RelationManagers;
use App\Models\LabRequest;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LabRequestResource extends Resource
{
    protected static ?string $model = LabRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-beaker';

    protected static ?string $navigationGroup = 'Operations';

    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('client_id')
                    ->relationship('client', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->createOptionForm([
                        Forms\Components\Grid::make(
                            2
                            // [
                            // 'default' => 1,
                            // 'sm' => 2,
                            // 'md' => 3,
                            // 'lg' => 4,
                            // 'xl' => 6,
                            // '2xl' => 8,
                            // ]
                        )
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('email')
                                    ->email()
                                    ->maxLength(255),
                                Forms\Components\Select::make('gender_id')
                                    ->relationship('gender', 'gender')
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                                Forms\Components\DatePicker::make('date_of_birth')
                                    ->required(),
                                Forms\Components\TextInput::make('phone_number')
                                    ->tel()
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('location')
                                    ->maxLength(255),
                            ])
                    ]),
                Forms\Components\TextInput::make('delivered_by')
                    ->maxLength(255),
                Forms\Components\Select::make('department_id')
                    ->relationship('department', 'name')
                    ->required(),
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->label('Request Received by')
                    ->required()
                    ->createOptionForm([

                    ]),
                Forms\Components\TextInput::make('request_date')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('client.name'),
                Tables\Columns\TextColumn::make('delivered_by'),
                Tables\Columns\TextColumn::make('department.name'),
                Tables\Columns\TextColumn::make('user.name'),
                Tables\Columns\TextColumn::make('request_date'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListLabRequests::route('/'),
            'create' => Pages\CreateLabRequest::route('/create'),
            'edit' => Pages\EditLabRequest::route('/{record}/edit'),
        ];
    }
}
