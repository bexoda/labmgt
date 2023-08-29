<?php

namespace App\Filament\Resources\DepartmentResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\TrashedFilter;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class UsersRelationManager extends RelationManager
{
    protected static string $relationship = 'users';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Get $get, Set $set, ?string $state) {
                        if (!$get('is_initials') && filled($state)) {
                            $words = explode(" ", $state);
                            $initials = "";
                            foreach ($words as $word) {
                                $initials .= substr($word, 0, 1);
                            }
                            $set('initials', substr(strtoupper(Str::slug($initials)), 0, 5));
                        }
                    }),
                Forms\Components\TextInput::make('initials')
                    ->required()
                    ->maxLength(5)
                    ->readOnly()
                    ->afterStateUpdated(function (Set $set) {
                        $set('is_initials', true);
                    })
                    ->label('Initials'),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('staffId')
                    ->required()
                    ->label('Staff ID'),
                Forms\Components\Select::make('department_id')
                    ->relationship('department', 'name')
                    ->searchable()
                    ->preload(),
                Forms\Components\Select::make('roles')
                    ->multiple()
                    ->relationship('roles', 'name')
                    ->preload()
                    ->label('Roles'),
                Forms\Components\TextInput::make('password')
                    ->same('passwordConfirmation')
                    ->password()
                    ->maxLength(255)
                    ->required(fn ($record) => $record === null)
                    ->dehydrateStateUsing(fn ($state) => !empty($state) ? Hash::make($state) : '')
                    ->label('Password'),
                Forms\Components\TextInput::make('passwordConfirmation')
                    ->password()
                    ->dehydrated(false)
                    ->maxLength(255)
                    ->label('Confirm Password'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('staffId')
                    ->label('Staff ID')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('initials')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\IconColumn::make('email_verified_at')
                    ->icons([
                        'heroicon-o-check-badge',
                        'heroicon-o-x-mark' => fn ($state): bool => $state === null,
                    ])
                    ->colors([
                        'success',
                        'danger' => fn ($state): bool => $state === null,
                    ])
                    ->label('Verified'),
                Tables\Columns\TextColumn::make('department.name')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'AssayLab' => 'gray',
                        'Geology' => 'warning',
                        'Metallurgy' => 'success',
                        // 'rejected' => 'danger',
                    })->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('D jS M Y, G:i:s')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('D jS M Y, G:i:s')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime('D jS M Y, G:i:s')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('New User'),
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
            Tables\Actions\CreateAction::make()
            ->label('New User'),
        ]);
    }
}
