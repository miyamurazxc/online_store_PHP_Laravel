<?php

namespace App\Filament\Resources;

use App\Models\Order;
use App\Events\OrderStatusChanged;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $label = 'Заказ';
    protected static ?string $pluralLabel = 'Заказы';
    protected static ?string $navigationLabel = 'Заказы';
    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $navigationGroup = 'Магазин';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('status')
                    ->label('Статус заказа')
                    ->options([
                        'pending' => 'Ожидает',
                        'processing' => 'В обработке',
                        'completed' => 'Завершён',
                        'canceled' => 'Отменён',
                    ])
                    ->required(),
                Forms\Components\Fieldset::make('user_id')
                    ->relationship('user')
                    ->label('Покупатель')
                    ->schema([
                        Forms\Components\TextInput::make('name')->label('Имя')->disabled(),
                        Forms\Components\TextInput::make('email')->label('Email')->disabled(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.id')->searchable()->label('ID покупателя'),
                Tables\Columns\TextColumn::make('user.name')->searchable()->label('Имя покупателя'),
                Tables\Columns\TextColumn::make('user.email')->searchable()->label('Email покупателя')->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Статус заказа')
                    ->enum([
                        'pending' => 'Ожидает',
                        'processing' => 'В обработке',
                        'completed' => 'Завершён',
                        'canceled' => 'Отменён',
                    ])
                    ->colors([
                        'secondary' => 'pending',
                        'warning' => 'processing',
                        'success' => 'completed',
                        'danger' => 'canceled',
                    ])
                    ->sortable(),
                Tables\Columns\TextColumn::make('total')->label('Итого')->prefix('₸')->sortable(),
                Tables\Columns\TextColumn::make('created_at')->label('Создан')->sortable()->date('d M H:i'),
                Tables\Columns\TextColumn::make('updated_at')->label('Обновлён')->sortable()->date('d M H:i'),
            ])
            ->filters([
                // можно добавить фильтры
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('Просмотр'),
                Tables\Actions\EditAction::make()->label('Редактировать'),
            ])
            ->bulkActions([
                FilamentExportBulkAction::make('export')->label('Экспорт'),
            ])
            ->headerActions([
                FilamentExportHeaderAction::make('export')->label('Экспорт'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // RelationManagers, если есть
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
