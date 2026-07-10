<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\DownloadResource\Pages;
use App\Models\Download;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;

class DownloadResource extends Resource
{
    protected static ?string $model = Download::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-down-tray';

    protected static ?string $navigationGroup = 'Content Management';

    protected static ?string $navigationLabel = 'Dokumen & Unduhan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),

                FileUpload::make('file_path')
                    ->required()
                    ->disk('public')
                    ->directory('downloads')
                    ->visibility('public')
                    ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/zip', 'application/x-rar-compressed', 'text/plain', 'image/*'])
                    ->maxSize(10240) // 10MB
                    ->helperText('Maksimal 10MB. Format: PDF, DOC, DOCX, XLS, XLSX, ZIP, RAR, TXT'),

                TextInput::make('category')
                    ->required()
                    ->maxLength(100)
                    ->helperText('Kategori: Kurikulum, Formulir, Pengumuman, dll'),

                TextInput::make('download_count')
                    ->label('Jumlah Unduhan')
                    ->numeric()
                    ->default(0)
                    ->disabled()
                    ->dehydrateStateUsing(fn (Forms\Set $set, $state) => $set('download_count', $state + 1)),

                Textarea::make('description')
                    ->columnSpanFull()
                    ->rows(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(40),

                TextColumn::make('file_path')
                    ->label('File')
                    ->getStateUsing(fn ($record) => basename($record->file_path)),

                TextColumn::make('category')
                    ->badge()
                    ->searchable(),

                IconColumn::make('is_published')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('download_count')
                    ->numeric()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_published'),
                Tables\Filters\SelectFilter::make('category')
                    ->options([
                        'Kurikulum' => 'Kurikulum',
                        'Formulir' => 'Formulir',
                        'Pengumuman' => 'Pengumuman',
                        'Lainnya' => 'Lainnya',
                    ])
                    ->searchable()
                    ->preload(),
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
            'index' => Pages\ListDownloads::route('/'),
            'create' => Pages\CreateDownload::route('/create'),
            'edit' => Pages\EditDownload::route('/{record}/edit'),
        ];
    }
}
