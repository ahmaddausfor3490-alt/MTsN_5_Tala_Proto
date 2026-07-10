<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\FaqResource\Pages;
use App\Models\Faq;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class FaqResource extends Resource
{
    protected static ?string $model = Faq::class;

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';

    protected static ?string $navigationGroup = 'Content Management';

    protected static ?string $navigationLabel = 'FAQ';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('question')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),

                Textarea::make('answer')
                    ->required()
                    ->rows(5)
                    ->columnSpanFull(),

                Grid::make(2)->schema([
                    Select::make('category')
                        ->options([
                            'akademik'  => 'Akademik',
                            'ppdb'      => 'PPDB',
                            'keuangan'  => 'Keuangan',
                            'kegiatan'  => 'Kegiatan',
                            'umum'      => 'Umum',
                        ])
                        ->default('umum')
                        ->required(),

                    TextInput::make('order')
                        ->label('Order / Urutan')
                        ->numeric()
                        ->default(0),
                ]),

                Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('question')
                    ->limit(60)
                    ->searchable()
                    ->sortable(),

                TextColumn::make('answer')
                    ->limit(80),

                TextColumn::make('category')
                    ->badge()
                    ->searchable()
                    ->sortable(),

                TextColumn::make('order')
                    ->sortable(),

                IconColumn::make('is_active')
                    ->boolean()
                    ->label('Status')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->options([
                        'akademik'  => 'Akademik',
                        'ppdb'      => 'PPDB',
                        'keuangan'  => 'Keuangan',
                        'kegiatan'  => 'Kegiatan',
                        'umum'      => 'Umum',
                    ]),

                TernaryFilter::make('is_active')
                    ->label('Status Aktif')
                    ->placeholder('Semua')
                    ->options([
                        true  => 'Aktif',
                        false => 'Nonaktif',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index'  => Pages\ListFaqs::route('/'),
            'create' => Pages\CreateFaq::route('/create'),
            'edit'   => Pages\EditFaq::route('/{record}/edit'),
        ];
    }
}
