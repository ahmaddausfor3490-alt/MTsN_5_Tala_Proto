<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PostResource\Pages;
use App\Models\Post;
use App\Models\Category;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Filament\Forms\Get;


class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Content Management';

    protected static ?string $navigationLabel = 'Berita';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Jenis Konten')
                    ->description('Pilih tipe konten yang akan dibuat.')
                    ->schema([
                        Radio::make('content_type')
                            ->default('news')
                            ->options([
                                'news' => 'Berita',
                                'gallery' => 'Galeri',
                            ])
                            ->live()
                            ->required(),
                    ])
                    ->columnSpanFull(),
                Tabs::make('Tabs')
                    ->tabs([
                        Tab::make('Informasi Utama')
                            ->schema([
                                TextInput::make('title')
                                    ->required(fn (Get $get) => $get('content_type') === 'news')
                                    ->maxLength(255)
                                    ->columnSpanFull()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (string $operation, $state, Set $set) =>
                                        $operation === 'create' && filled($state) ? $set('slug', Str::slug($state)) : null),

                                TextInput::make('slug')
                                    ->maxLength(255)
                                    ->disabled()
                                    ->dehydrated(fn ($state) => filled($state))
                                    ->prefix(fn (): string => url('/berita/'))
                                    ->helperText('URL-friendly slug untuk postingan'),

                                Select::make('status')
                                    ->default('draft')
                                    ->options([
                                        'draft' => 'Draft',
                                        'published' => 'Dipublikasikan',
                                        'archived' => 'Arsip',
                                    ])
                                    ->required(),

                                Textarea::make('excerpt')
                                    ->visible(fn (Get $get) => $get('content_type') === 'news')
                                    ->required(fn (Get $get) => $get('content_type') === 'news')
                                    ->columnSpanFull()
                                    ->rows(3)
                                    ->helperText('Ringkasan pendek untuk tampilan grid/list'),

                                RichEditor::make('body')
                                    ->hidden(fn (Get $get) => $get('content_type') === 'gallery')
                                    ->label(fn (Get $get) => $get('content_type') === 'gallery' ? 'Deskripsi' : 'Isi Berita')
                                    ->placeholder(fn (Get $get) => $get('content_type') === 'gallery' ? 'Deskripsi singkat tentang galeri ini (opsional)' : null)
                                    ->columnSpanFull()
                                    ->required(fn (Get $get) => $get('content_type') === 'news')
                                    ->fileAttachmentsDirectory('news')
                                    ->fileAttachmentsVisibility('public'),

                                FileUpload::make('cover_image')
                                    ->image()
                                    ->directory('posts/covers')
                                    ->visibility('public')
                                    ->preserveFilenames()
                                    ->helperText('Gambar utama / thumbnail untuk postingan')
                                    ->required(fn (Get $get) => $get('content_type') === 'news')
                                    ->hidden(fn (Get $get) => $get('content_type') === 'gallery'),

                                Select::make('author_id')
                                    ->label('Penulis')
                                    ->relationship('author', 'name')
                                    ->default(auth()->id())
                                    ->searchable()
                                    ->preload()
                                    ->required(),

                                DatePicker::make('published_at')
                                    ->label('Tanggal Terbit')
                                    ->default(now()),
                            ]),

                        Tab::make('Gambar Galeri')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                FileUpload::make('gallery_images')
                                    ->label('Foto Galeri')
                                    ->image()
                                    ->directory('posts/galleries')
                                    ->visibility('public')
                                    ->preserveFilenames()
                                    ->multiple()
                                    ->columnSpanFull()
                                    ->helperText('Foto tambahan dalam postingan ini')
                                    ->required(fn (Get $get) => $get('content_type') === 'gallery')
                                    ->validationAttribute('foto'),
                            ]),

                        Tab::make('Kategori & SEO')
                            ->icon('heroicon-o-tag')
                            ->schema([
                                Select::make('category_ids')
                                    ->relationship('categories', 'name', modifyQueryUsing: fn (Builder $query) => $query->orderBy('name'))
                                    ->multiple()
                                    ->searchable()
                                    ->preload()
                                    ->default(function (Get $get) {
                                        if ($get('content_type') !== 'gallery') {
                                            return null;
                                        }
                                        $galleryCat = Category::where('slug', 'gallery')->first();
                                        return $galleryCat ? [$galleryCat->id] : null;
                                    })
                                    ->label('Kategori'),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(40)
                    ->weight('medium'),

                TextColumn::make('content_type')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state === 'gallery' ? 'Galeri' : 'Berita')
                    ->colors([
                        'primary' => 'gallery',
                        'success' => 'news',
                    ])
                    ->sortable(),

                TextColumn::make('categories')
                    ->label('Kategori')
                    ->badge()
                    ->getStateUsing(fn ($record) => $record->categories->pluck('name'))
                    ->separator(', '),

                TextColumn::make('author.name')
                    ->label('Penulis')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'success' => 'published',
                        'warning' => 'draft',
                        'gray'    => 'archived',
                    ])
                    ->sortable(),

                TextColumn::make('published_at')
                    ->date()
                    ->sortable(),

                ToggleColumn::make('is_published')
                    ->sortable(),
            ])
            ->filters([
                TrashedFilter::make(),

                SelectFilter::make('author_id')
                    ->relationship('author', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('content_type')
                    ->options([
                        'news' => 'Berita',
                        'gallery' => 'Galeri',
                    ])
                    ->default('news')
                    ->query(fn (Builder $query, array $data) => $data['value'] ? $query->where('content_type', $data['value']) : $query)
                    ->indicateUsing(fn (array $data): ?string => $data['value'] ? 'Tipe: ' . ucfirst($data['value']) : null),

                SelectFilter::make('category_id')
                    ->label('Kategori')
                    ->relationship('categories', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                RestoreAction::make(),
                DeleteAction::make(),
                ForceDeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    ForceDeleteBulkAction::make(),
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'view' => Pages\ViewPost::route('/{record}'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('title')
                    ->size('lg')
                    ->weight('bold'),
                TextEntry::make('slug'),
                TextEntry::make('status')
                    ->badge()
                    ->colors([
                        'success' => 'published',
                        'warning' => 'draft',
                        'gray'    => 'archived',
                    ]),
                TextEntry::make('excerpt')
                    ->columnSpanFull(),
                TextEntry::make('body')
                    ->html()
                    ->columnSpanFull(),
                ImageEntry::make('cover_image')
                    ->columnSpanFull(),
                ViewEntry::make('gallery_images')
                    ->view('filament.entries.gallery-images')
                    ->columnSpanFull(),
                TextEntry::make('author.name')
                    ->label('Penulis'),
                TextEntry::make('published_at')
                    ->dateTime(),
                TextEntry::make('created_at')
                    ->dateTime(),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('author');
    }
}
