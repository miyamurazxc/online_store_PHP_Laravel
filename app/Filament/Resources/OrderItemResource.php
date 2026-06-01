<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\OrderItem;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\OrderItemResource\Pages;
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;

class OrderItemResource extends Resource
{
    protected static ?string $model = OrderItem::class;

    protected static ?string $label = 'Позиция заказа';
    protected static ?string $pluralLabel = 'Позиции заказа';

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationGroup = 'Магазин';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Fieldset::make('product_id')
                    ->label('Информация о товаре')
                    ->relationship('product')
                    ->schema([
                        Forms\Components\TextInput::make('name')->label('Название')->disabled(),
                        Forms\Components\TextInput::make('SKU')->label('Артикул')->disabled(),
                        Forms\Components\TextInput::make('quantity')->label('Количество')->disabled(),
                        Forms\Components\TextInput::make('price')->label('Цена')->prefix('₸')->disabled(),
                    ]),
                Forms\Components\Fieldset::make('order_id')
                    ->relationship('order')
                    ->label('Информация о заказе')
                    ->schema([
                        Forms\Components\Fieldset::make('user_id')
                            ->label('Информация о покупателе')
                            ->relationship('user')
                            ->schema([
                                Forms\Components\TextInput::make('name')->label('Имя')->disabled(),
                                Forms\Components\TextInput::make('email')->label('Email')->disabled(),
                            ]),
                    ])
                    ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('product.image')->label('Изображение товара')->searchable(),
                Tables\Columns\TextColumn::make('product.SKU')->label('Артикул')->sortable(),
                Tables\Columns\TextColumn::make('product.name')->label('Название товара')->sortable(),
                Tables\Columns\TextColumn::make('quantity')->label('Количество')->sortable(),
                Tables\Columns\BadgeColumn::make('order.status')
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
                Tables\Columns\TextColumn::make('price')->label('Цена')->prefix('₸')->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('Просмотр'),
                Tables\Actions\EditAction::make()->label('Редактировать'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()->label('Удалить'),
                FilamentExportBulkAction::make('export')->label('Экспорт'),
            ])
            ->headerActions([
                FilamentExportHeaderAction::make('export')->label('Экспорт'),
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
            'index' => Pages\ListOrderItems::route('/'),
            'create' => Pages\CreateOrderItem::route('/create'),
            'edit' => Pages\EditOrderItem::route('/{record}/edit'),
        ];
    }
}
