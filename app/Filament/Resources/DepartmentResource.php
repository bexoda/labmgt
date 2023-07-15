<?php

namespace App\Filament\Resources;

use Closure;
use Filament\Forms;
use Filament\Tables;
use App\Models\Department;
use Illuminate\Support\Str;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\TrashedFilter;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\DepartmentResource\Pages;
use App\Filament\Resources\DepartmentResource\RelationManagers\UserRelationManager;
use App\Filament\Resources\DepartmentResource\RelationManagers\UsersRelationManager;

class DepartmentResource extends Resource
{
    protected static ?string $model = Department::class;

    protected static ?string $navigationIcon = 'heroicon-o-chip';

    protected static ?string $navigationGroup = 'Staff';

    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }


    public static function form(Form $form): Form
    {
        return $form
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
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable()
                    ->label('Department Name'),
                Tables\Columns\TextColumn::make('department_slug')
                    ->sortable()
                    ->searchable()
                    ->label('Department Initials'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('D j M Y, G:i:s'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('D j M Y, G:i:s'),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->toggleable()
                    ->dateTime('D j M Y, G:i:s'),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            UsersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDepartments::route('/'),
            'create' => Pages\CreateDepartment::route('/create'),
            'view' => Pages\ViewDepartment::route('/{record}'),
            'edit' => Pages\EditDepartment::route('/{record}/edit'),
        ];
    }
}
