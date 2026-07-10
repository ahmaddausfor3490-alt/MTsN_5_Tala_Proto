<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\AgendaResource\Pages;
use App\Models\Agenda;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\TimePicker;

class AgendaResource extends Resource
{
    protected static ?string $model = Agenda::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationGroup = 'Content Management';

    protected static ?string $navigationLabel = 'Agenda Kegiatan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),

                Select::make('category')
                    ->options(self::getCategories())
                    ->required()
                    ->selectablePlaceholder(false),

                DatePicker::make('event_date')
                    ->required(),

              TimePicker::make('event_time')
                 ->seconds(false)
                 ->nullable(),

                TextInput::make('location')
                    ->maxLength(255)
                    ->columnSpanFull(),

                Textarea::make('description')
                    ->columnSpanFull()
                    ->rows(5),

                Toggle::make('is_recurring')
                    ->label('Berulang')
                    ->live()
                    ->afterStateUpdated(fn (callable $set, bool $state) => $state || $set('recurrence_pattern', null)),

                TextInput::make('recurrence_pattern')
                    ->placeholder('Mis. Mingguan, Bulanan')
                    ->visible(fn (callable $get) => (bool) $get('is_recurring')),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(40),

                TextColumn::make('event_date')
                    ->date()
                    ->sortable(),

                TextColumn::make('event_time')
                    ->time()
                    ->getStateUsing(fn ($record) => $record->event_time ? \Carbon\Carbon::parse($record->event_time)->format('H:i') : null),

                TextColumn::make('category')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'seremonial' => 'blue',
                        'akademik' => 'green',
                        'ekstrakurikuler' => 'amber',
                        default => 'gray',
                    }),

                IconColumn::make('is_recurring')
                    ->boolean()
                    ->label('Berulang')
                    ->sortable(),
            ])
            ->filters([
                Filter::make('upcoming')
                    ->label('Akan Datang')
                    ->query(fn (Builder $query) => $query->where('event_date', '>=', now()->toDateString())),

                SelectFilter::make('category')
                    ->options(self::getCategories()),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListAgendas::route('/'),
            'create' => Pages\CreateAgenda::route('/create'),
            'edit' => Pages\EditAgenda::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->orderBy('event_date', 'asc');
    }

    protected static function getCategories(): array
    {
        return [
            'seremonial' => 'Seremonial',
            'akademik' => 'Akademik',
            'ekstrakurikuler' => 'Ekstrakurikuler',
            'umum' => 'Umum',
        ];
    }
}
