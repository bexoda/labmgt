<?php

namespace App\Filament\Resources;

use Closure;
use Filament\Forms;
use Filament\Tables;
use App\Models\Client;
use App\Models\LabRequest;
use Illuminate\Support\Str;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\TrashedFilter;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\LabRequestResource\Pages;
use App\Filament\Resources\LabRequestResource\RelationManagers;
use App\Filament\Resources\LabRequestResource\RelationManagers\LabResultsRelationManager;
use App\Filament\Resources\LabRequestResource\RelationManagers\LabSamplesRelationManager;

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
                Forms\Components\Section::make('Client Details')
                    ->schema([
                        Forms\Components\Select::make('client_id')
                            ->relationship('client', 'name')
                            ->searchable()
                            ->label('Client Name')
                            ->preload()
                            ->required()
                            ->afterStateUpdated(function (Closure $get, Closure $set, ?string $state) {
                                if (!$get('is_delivered_by_slug') && filled($state)) {
                                    $set('delivered_by', Client::find($state)->name);
                                }
                            })
                            ->reactive()
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
                            ->helperText('Modify if the client isn\'t the patient')
                            ->maxLength(255)
                            ->afterStateUpdated(function (Closure $set) {
                                $set('is_delivered_by_slug', true);
                            }),
                    ])->columns(2)
                    ->collapsible(),

                Forms\Components\Section::make('AssayLab Staff Details')
                    ->schema([
                        Forms\Components\Select::make('department_id')
                            ->relationship('department', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->createOptionForm([
                                Forms\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('name')
                                            ->required()
                                            ->maxLength(255)
                                            ->afterStateUpdated(function (Closure $get, Closure $set, ?string $state) {
                                                if (!$get('is_department_slug') && filled($state)) {
                                                    $set('department_slug', substr(strtoupper(Str::slug($state)), 0, 3));
                                                }
                                            })
                                            ->reactive()
                                            ->label('Department Name'),
                                        Forms\Components\TextInput::make('department_slug')
                                            ->required()
                                            ->maxLength(5)
                                            ->disabled()
                                            ->afterStateUpdated(function (Closure $set) {
                                                $set('is_department_slug', true);
                                            })
                                            ->label('Department Code'),
                                    ])
                            ]),
                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->label('Request Received by')
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
                                            ->afterStateUpdated(function (Closure $get, Closure $set, ?string $state) {
                                                if (!$get('is_initials') && filled($state)) {
                                                    $words = explode(" ", $state);
                                                    $initials = "";
                                                    foreach ($words as $word) {
                                                        $initials .= substr($word, 0, 1);
                                                    }
                                                    $set('initials', substr(strtoupper(Str::slug($initials)), 0, 5));
                                                }
                                            })
                                            ->reactive()
                                            ->required(),
                                        Forms\Components\TextInput::make('initials')
                                            ->required()
                                            ->maxLength(5)
                                            ->disabled()
                                            ->afterStateUpdated(function (Closure $set) {
                                                $set('is_initials', true);
                                            })
                                            ->label('Initials'),
                                        Forms\Components\TextInput::make('email')
                                            ->required()
                                            ->email()
                                            ->unique(table: User::class, ignorable: fn ($record) => $record)
                                            ->label('Email'),
                                        Forms\Components\TextInput::make('password')
                                            ->same('passwordConfirmation')
                                            ->password()
                                            ->maxLength(255)
                                            ->required(fn ($component, $get, $livewire, $model, $record, $set, $state) => $record === null)
                                            ->dehydrateStateUsing(fn ($state) => !empty($state) ? Hash::make($state) : '')
                                            ->label('Password'),
                                        Forms\Components\TextInput::make('passwordConfirmation')
                                            ->password()
                                            ->dehydrated(false)
                                            ->maxLength(255)
                                            ->label('Confirm Password'),
                                        Forms\Components\Select::make('roles')
                                            ->multiple()
                                            ->relationship('roles', 'name')
                                            ->preload()
                                            ->label('Roles'),
                                    ])
                            ]),
                    ])->columns(2)
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('client.name')
                    ->label('Client Name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('delivered_by')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('department.name')
                    ->colors([
                        'primary',
                        // 'secondary' => 'draft',
                    ])
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Request Received by')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Request Date')
                    ->dateTime('D jS M Y, G:i:s'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('D jS M Y, G:i:s'),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->toggleable()
                    ->dateTime('D jS M Y, G:i:s'),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            LabSamplesRelationManager::class,
            LabResultsRelationManager::class,
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
