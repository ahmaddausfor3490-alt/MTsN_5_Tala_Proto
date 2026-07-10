<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TeacherResource\Pages;
use App\Models\Teacher;
use Filament\Forms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class TeacherResource extends Resource
{
    protected static ?string $model = Teacher::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Content Management';

    protected static ?string $navigationLabel = 'Data Guru';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Guru')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('name')
                                ->required()
                                ->maxLength(255),
                            TextInput::make('nip')
                                ->label('NIP')
                                ->nullable(),
                        ]),
                        Grid::make(2)->schema([
                            TextInput::make('education')
                                ->label('Pendidikan Terakhir')
                                ->required()
                                ->maxLength(255),
                            TextInput::make('position')
                                ->label('Jabatan Struktural')
                                ->nullable(),
                        ]),
                        TextInput::make('subjects')
                            ->label('Mata Pelajaran')
                            ->placeholder('Matematika, Fisika, Bahasa Indonesia, dll')
                            ->helperText('Pisahkan dengan koma untuk multiple mata pelajaran.'),
                        Textarea::make('bio')
                            ->label('Biografi Singkat')
                            ->columnSpanFull()
                            ->rows(4),
                    ])->columns(1),

                Section::make('Foto')
                    ->schema([
                        FileUpload::make('photo')
                            ->image()
                            ->disk('public')
                            ->directory('teachers')
                            ->visibility('public')
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('1:1')
                            ->helperText('Upload foto guru (disarankan 400x400px)'),
                    ])->collapsible(),

                Section::make('Status Kepegawaian')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('designation')
                                ->label('Tugas Tambahan')
                                ->options([
                                    'guru' => 'Guru',
                                    'wakil_kepala_sekolah' => 'Wakil Kepala Sekolah',
                                    'staf' => 'Staf Administrasi',
                                    'kepala_sekolah' => 'Kepala Sekolah',
                                ])
                                ->default('guru'),
                            Toggle::make('is_principal')
                                ->label('Kepala Sekolah (Prinsipal)')
                                ->helperText('Centang hanya untuk Kepala Sekolah'),
                        ]),
                    ])->collapsible(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo')
                    ->disk('public')
                    ->circular()
                    ->size(40),

                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('subjects')
                    ->searchable()
                    ->limit(20),

                TextColumn::make('position')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('education')
                    ->label('Pendidikan')
                    ->searchable()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('education')
                    ->options([
                        'S1' => 'S1',
                        'S2' => 'S2',
                        'S3' => 'S3',
                        'D3' => 'D3',
                        'SMA' => 'SMA/SMK',
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
            'index' => Pages\ListTeachers::route('/'),
            'create' => Pages\CreateTeacher::route('/create'),
            'edit' => Pages\EditTeacher::route('/{record}/edit'),
        ];
    }
}
