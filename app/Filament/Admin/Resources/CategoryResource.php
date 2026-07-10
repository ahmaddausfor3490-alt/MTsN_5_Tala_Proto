<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CategoryResource\Pages;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationGroup = 'Content Management';

    protected static ?string $navigationLabel = 'Kategori';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Kategori')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn(string $operation, $state, Set $set) =>
                                $operation === 'create' ? $set('slug', Str::slug($state)) : null),

                        TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->disabled()
                            ->dehydrated(fn($state) => filled($state)),

                        TextInput::make('color')
                            ->label('Warna Badge')
                            ->hexColor()
                            ->default('#3b82f6'),

                        Textarea::make('description')
                            ->columnSpanFull()
                            ->rows(3),

                        TextInput::make('order')
                            ->label('Urutan')
                            ->integer()
                            ->default(0),
                    ]),

                Section::make('Artikel Terkait')
                    ->schema([
                        Repeater::make('posts')
                            ->relationship('posts')
                            ->grid([
                                'default' => 1,
                                'lg' => 3,
                            ])

                            ->disabled()
                            ->simple(
                                TextInput::make('title')
                                    ->label('Judul Artikel')
                                    ->disabled()
                            ),
                    ])
                    ->collapsed()
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('slug')
                    ->searchable(),

                ColorColumn::make('color')
                    ->label('Warna'),

                TextColumn::make('order')
                    ->label('Urutan')
                    ->sortable()
                    ->alignCenter(),

                TextColumn::make('posts_count')
                    ->label('Artikel')
                    ->counts('posts')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit'   => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
