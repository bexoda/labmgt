<?php

namespace App\Filament\Resources\DepartmentResource\RelationManagers;

use Closure;
use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Illuminate\Support\Str;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class UsersRelationManager extends RelationManager
{
    protected static string $relationship = 'users';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
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
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('initials')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('department.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable()
                    ->label('Email'),
                Tables\Columns\IconColumn::make('email_verified_at')
                    ->options([
                        'heroicon-o-check-circle',
                        'heroicon-o-x-circle' => fn ($state): bool => $state === null,
                    ])
                    ->colors([
                        'success',
                        'danger' => fn ($state): bool => $state === null,
                    ])
                    ->label('Verified'),
                Tables\Columns\TagsColumn::make('roles.name')
                    ->label('Roles'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('D jS M Y, G:i:s')
                    ->toggleable()
                    ->label('Joined'),

            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
