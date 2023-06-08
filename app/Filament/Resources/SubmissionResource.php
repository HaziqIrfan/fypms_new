<?php

namespace App\Filament\Resources;

use App\Models\Submission;
use Filament\{Tables, Forms};
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use App\Filament\Filters\DateRangeFilter;
use App\Filament\Resources\SubmissionResource\Pages;
use Filament\Forms\Components\FileUpload;

class SubmissionResource extends Resource
{
    protected static ?string $model = Submission::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text'; //change icon navside-bar

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                Grid::make(['default' => 0])->schema([
                    TextInput::make('title')
                        ->rules(['max:255', 'string'])
                        ->required()
                        ->placeholder('Title')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('description')
                        ->rules(['max:255', 'string'])
                        ->required()
                        ->placeholder('Description')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    DatePicker::make('start_date')
                        ->rules(['date'])
                        ->required()
                        ->placeholder('Start Date')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    DatePicker::make('due_date')
                        ->rules(['date'])
                        ->required()
                        ->placeholder('Due Date')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),
                    FileUpload::make('file_path') //Refer documentation filament: #File upload
                        ->disk('studentsubmissions')
                        ->enableReordering()
                        ->enableOpen()
                        ->enableDownload()
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),
                ]),


            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->poll('60s')
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->toggleable()
                    ->searchable()
                    ->limit(50),
                // Tables\Columns\TextColumn::make('description')
                //     ->toggleable()
                //     ->searchable()
                //     ->limit(50),
                Tables\Columns\TextColumn::make('start_date')
                    ->toggleable()
                    ->date(),
                Tables\Columns\TextColumn::make('due_date')
                    ->toggleable()
                    ->date(),
                // Tables\Columns\TextColumn::make('file_path')
                //     ->toggleable()
                //     ->searchable()
                //     ->limit(50),
            ])
            ->filters([DateRangeFilter::make('created_at')]);
    }

    public static function getRelations(): array
    {
        return [
            SubmissionResource\RelationManagers\StudentSubmissionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSubmissions::route('/'),
            'create' => Pages\CreateSubmission::route('/create'),
            'view' => Pages\ViewSubmission::route('/{record}'),
            'edit' => Pages\EditSubmission::route('/{record}/edit'),
        ];
    }
}
