<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\SettingResource\Pages;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'Management';

    protected static ?string $navigationLabel = 'Pengaturan';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('key')
                    ->required()
                    ->maxLength(100)
                    ->unique(ignoreRecord: true),

                TextInput::make('label')
                    ->required()
                    ->maxLength(255),

                Select::make('type')
                    ->required()
                    ->options([
                        'text'      => 'Teks',
                        'textarea'  => 'Area Teks',
                        'number'    => 'Angka',
                        'email'     => 'Email',
                        'url'       => 'URL',
                        'file'      => 'File',
                        'image'     => 'Gambar',
                        'boolean'   => 'Ya/Tidak',
                        'select'    => 'Dropdown',
                    ])
                    ->reactive(),

                // ── Text input (handles text/number/email/url) ──
                TextInput::make('value')
                    ->type(fn (Forms\Get $get): string => match ($get('type')) {
                        'number'  => 'number',
                        'email'   => 'email',
                        'url'     => 'url',
                        default   => 'text',
                    })
                    ->label(fn (Forms\Get $get): string => match ($get('type')) {
                        'number'  => 'Nilai Angka',
                        'email'   => 'Alamat Email',
                        'url'     => 'Alamat URL',
                        default   => 'Nilai',
                    })
                    ->required(fn (Forms\Get $get): bool => in_array($get('type'), ['text', 'number', 'email', 'url']))
                    ->visible(fn (Forms\Get $get): bool => in_array($get('type'), ['text', 'number', 'email', 'url']))
                    ->columnSpanFull(),

                // ── Textarea (textarea type only) ──
                Textarea::make('value_textarea')
                    ->required(fn (Forms\Get $get): bool => $get('type') === 'textarea')
                    ->label('Nilai')
                    ->rows(4)
                    ->columnSpanFull()
                    ->visible(fn (Forms\Get $get): bool => $get('type') === 'textarea'),

                // ── File upload (file/image types only) ──
                Forms\Components\FileUpload::make('value_file')
                    ->disk('public')
                    ->directory('settings')
                    ->visibility('public')
                    ->image(fn (Forms\Get $get): bool => $get('type') === 'image')
                    ->required(fn (Forms\Get $get): bool => in_array($get('type'), ['file', 'image']))
                    ->label(fn (Forms\Get $get): string => $get('type') === 'image' ? 'Gambar' : 'File')
                    ->columnSpanFull()
                    ->visible(fn (Forms\Get $get): bool => in_array($get('type'), ['file', 'image'])),

                // ── Toggle (boolean type only) ──
                Forms\Components\Toggle::make('value_boolean')
                    ->required(fn (Forms\Get $get): bool => $get('type') === 'boolean')
                    ->label('Aktif')
                    ->columnSpanFull()
                    ->visible(fn (Forms\Get $get): bool => $get('type') === 'boolean'),

                // ── Select (dropdown type only) ──
                Select::make('value_select')
                    ->options(fn (Forms\Get $get): array => collect(explode(',', $get('options') ?? ''))
                        ->mapWithKeys(fn ($opt) => explode(':', trim($opt)))
                        ->toArray())
                    ->searchable()
                    ->required(fn (Forms\Get $get): bool => $get('type') === 'select')
                    ->label('Pilihan')
                    ->placeholder('Pilih opsi...')
                    ->columnSpanFull()
                    ->visible(fn (Forms\Get $get): bool => $get('type') === 'select'),

                // ── Options field ──
                TextInput::make('options')
                    ->label('Opsi (format: key1:value1,key2:value2)')
                    ->helperText('Wajib diisi jika tipe adalah Dropdown')
                    ->visible(fn (Forms\Get $get): bool => $get('type') === 'select'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('key')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('label')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('type')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'text'      => 'Teks',
                        'textarea'  => 'Area Teks',
                        'number'    => 'Angka',
                        'email'     => 'Email',
                        'url'       => 'URL',
                        'file'      => 'File',
                        'image'     => 'Gambar',
                        'boolean'   => 'Ya/Tidak',
                        'select'    => 'Dropdown',
                        default     => $state,
                    }),

                TextColumn::make('updated_at')
                    ->date()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->mutateRecordDataUsing(function (array $data): array {
                        // Fill: translate DB 'value' to unique field names
                        $mapping = [
                            'textarea' => 'value_textarea',
                            'file' => 'value_file', 'image' => 'value_file',
                            'boolean' => 'value_boolean', 'select' => 'value_select',
                        ];
                        $type = $data['type'] ?? '';
                        if (isset($mapping[$type]) && isset($data['value'])) {
                            $data[$mapping[$type]] = $data['value'];
                        }
                        unset($data['value']);
                        return $data;
                    })
                    ->action(function ($form) {
                        $record = $this->getRecord();
                        $data = $form->getState();

                        $type = $data['type'] ?? '';

                        // Determine the unique field based on type
                        $valueField = match ($type) {
                            'textarea' => 'value_textarea',
                            'file', 'image' => 'value_file',
                            'boolean' => 'value_boolean',
                            'select' => 'value_select',
                            default => 'value', // text/number/email/url already use 'value'
                        };

                        $data['value'] = $valueField === 'value_boolean'
                            ? (bool) ($data[$valueField] ?? false)
                            : (string) ($data[$valueField] ?? '');

                        unset($data['value_text'], $data['value_textarea'],
                              $data['value_file'], $data['value_boolean'],
                              $data['value_select']);

                        $record->update($data);
                        $this->success();
                    }),
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
            'index'  => Pages\ListSettings::route('/'),
            'create' => Pages\CreateSetting::route('/create'),
            'edit'   => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}
