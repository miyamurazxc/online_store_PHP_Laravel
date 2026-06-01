<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Livewire\TemporaryUploadedFile;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\CheckboxList;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\ProductResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Filament\Resources\ProductResource\Pages\EditProduct;
use App\Filament\Resources\ProductResource\Pages\ListProducts;
use App\Filament\Resources\ProductResource\Pages\CreateProduct;
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;
use App\Filament\Resources\CategoryResource\RelationManagers\CategoriesRelationManager;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $navigationGroup = 'Магазин';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Название')
                    ->required(),
                Forms\Components\TextInput::make('SKU')
                    ->label('Артикул (SKU)')
                    ->helperText('Формат: SKU-####')
                    ->regex('/SKU-\d{4}/')
                    ->required(),
                Forms\Components\TextInput::make('price')
                    ->label('Цена')
                    ->numeric()
                    ->prefix('₸')
                    ->rules(['min:0'])
                    ->required(),
                Forms\Components\TextInput::make('old_price')
                    ->label('Старая цена')
                    ->numeric()
                    ->prefix('₸')
                    ->rules(['min:0'])
                    ->required(),
                Forms\Components\TextInput::make('quantity')
                    ->label('Количество')
                    ->numeric(),
                Forms\Components\TextInput::make('brief_description')
                    ->label('Краткое описание')
                    ->rules(['min:10', 'max:100'])
                    ->required(),
                Forms\Components\Select::make('stock_status')
                    ->label('Статус на складе')
                    ->options([
                        'instock' => 'В наличии',
                        'outstock' => 'Нет в наличии',
                    ])
                    ->default('instock'),
                Forms\Components\FileUpload::make('image')
                    ->label('Главное изображение')
                    ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                        $fileName = $file->hashName();
                        $name = explode('.', $fileName);
                        return (string) str('images/products/main_image/' . $name[0] . '.' . $name[1]);
                    })
                    ->maxSize(3072)
                    ->image()
                    ->imageResizeMode('cover')
                    ->imageCropAspectRatio('1:1')
                    ->imageResizeTargetWidth('450')
                    ->imageResizeTargetHeight('450')
                    ->required(),
                Forms\Components\FileUpload::make('images')
                    ->label('Дополнительные изображения')
                    ->columnSpan('full')
                    ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                        $fileName = $file->hashName();
                        $name = explode('.', $fileName);
                        return (string) str('images/products/alt_images/' . $name[0] . '.' . $name[1]);
                    })
                    ->maxSize(3072)
                    ->image()
                    ->imageResizeMode('cover')
                    ->imageCropAspectRatio('1:1')
                    ->imageResizeTargetWidth('450')
                    ->imageResizeTargetHeight('450')
                    ->required(),
                Forms\Components\RichEditor::make('description')
                    ->label('Полное описание')
                    ->maxLength(1000)
                    ->columnSpan('full')
                    ->toolbarButtons([
                        'blockquote',
                        'bold',
                        'bulletList',
                        'codeBlock',
                        'h2',
                        'h3',
                        'italic',
                        'link',
                        'orderedList',
                        'redo',
                        'strike',
                        'undo',
                    ]),
                Forms\Components\CheckboxList::make('categories')
                    ->label('Категории')
                    ->columnSpan('full')
                    ->relationship('categories', 'name'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->headerActions([
                FilamentExportHeaderAction::make('export')->label('Экспорт'),
            ])
            ->columns([
                Tables\Columns\ImageColumn::make('image')->label('Изображение'),
                Tables\Columns\TextColumn::make('name')->label('Название')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('SKU')->label('Артикул')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('price')->label('Цена')->prefix('₸')->sortable(),
                Tables\Columns\TextColumn::make('quantity')->label('Количество')->sortable(),
                Tables\Columns\TextColumn::make('created_at')->label('Дата создания')->sortable()->date('d M H:i'),
                Tables\Columns\TextColumn::make('updated_at')->label('Дата обновления')->sortable()->date('d M H:i'),
            ])
            ->filters([
                //
            ])
            ->actions([
                ViewAction::make()->label('Просмотр'),
                EditAction::make()->label('Редактировать'),
            ])
            ->bulkActions([
                DeleteBulkAction::make()->label('Удалить'),
                FilamentExportBulkAction::make('export')->label('Экспорт'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            CategoriesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProducts::route('/'),
            'create' => CreateProduct::route('/create'),
            'edit' => EditProduct::route('/{record}/edit'),
        ];
    }
}
