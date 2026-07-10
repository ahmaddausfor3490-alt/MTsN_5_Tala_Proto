<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ContactMessageResource\Pages;
use App\Models\ContactMessage;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ContactMessageResource extends Resource
{
    protected static ?string $model = ContactMessage::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $navigationGroup = 'Communication';

    protected static ?string $navigationLabel = 'Pesan Kontak';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->readOnly()
                    ->required()
                    ->columnSpanFull(),

                TextInput::make('email')
                    ->email()
                    ->readOnly()
                    ->required()
                    ->columnSpanFull(),

                TextInput::make('subject')
                    ->readOnly()
                    ->required(),

                Textarea::make('message')
                    ->readOnly()
                    ->required()
                    ->columnSpanFull()
                    ->rows(5),

                Textarea::make('reply')
                    ->label('Balasan Admin')
                    ->columnSpanFull()
                    ->rows(5)
                    ->helperText('Ketik balasan untuk dikirim melalui email.'),
            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),

                TextColumn::make('subject')
                    ->searchable()
                    ->sortable()
                    ->limit(40),

                TextColumn::make('email')
                    ->searchable()
                    ->copyable()
                    ->limit(30),

                TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->date()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('replied_at')
                    ->label('Dibalas')
                    ->date()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([])
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
            'index' => Pages\ListContactMessages::route('/'),
            'create' => Pages\CreateContactMessage::route('/create'),
            'edit' => Pages\EditContactMessage::route('/{record}/edit'),
        ];
    }
}
