<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Клиенты';

    protected static ?string $navigationLabel = 'Пользователи';

    public static function getModelLabel(): string
    {
        return 'пользователь';
    }

    public static function getPluralModelLabel(): string
    {
        return 'пользователи';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->label('Имя')
                ->required(),

            Forms\Components\TextInput::make('email')
                ->label('Электронная почта')
                ->required(),

            Forms\Components\Toggle::make('is_admin')
                ->label('Администратор')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name')
                ->label('Имя')
                ->searchable()
                ->sortable(),

            Tables\Columns\TextColumn::make('email')
                ->label('Электронная почта')
                ->searchable()
                ->sortable(),

            Tables\Columns\ToggleColumn::make('is_admin')
                ->label('Админ')
                ->sortable(),

            Tables\Columns\TextColumn::make('created_at')
                ->label('Создан')
                ->sortable()
                ->date('d.m.Y H:i'),

            Tables\Columns\TextColumn::make('updated_at')
                ->label('Обновлён')
                ->sortable()
                ->date('d.m.Y H:i'),
        ])
        ->filters([
            //
        ])
        ->actions([
            Tables\Actions\EditAction::make()->label('Редактировать'),
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make()->label('Удалить выбранное'),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
