<?php

namespace App\Filament\Resources;

use App\Models\StudentSubmission;
use Filament\{Tables, Forms};
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Filters\DateRangeFilter;
use App\Filament\Resources\StudentSubmissionResource\Pages;

class StudentSubmissionResource extends Resource
{
    protected static ?string $model = StudentSubmission::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $recordTitleAttribute = 'file_path';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                Grid::make(['default' => 0])->schema([
                    RichEditor::make('file_path')
                        ->rules(['max:255', 'string'])
                        ->required()
                        ->placeholder('File Path')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    Select::make('submission_id')
                        ->rules(['exists:submissions,id'])
                        ->required()
                        ->relationship('submission', 'title')
                        ->searchable()
                        ->placeholder('Submission')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    Select::make('student_id')
                        ->rules(['exists:students,id'])
                        ->required()
                        ->relationship('student', 'sv_name')
                        ->searchable()
                        ->placeholder('Student')
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
                Tables\Columns\TextColumn::make('file_path')
                    ->toggleable()
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('submission.title')
                    ->toggleable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('student.sv_name')
                    ->toggleable()
                    ->limit(50),
            ])
            ->filters([
                DateRangeFilter::make('created_at'),

                SelectFilter::make('submission_id')
                    ->relationship('submission', 'title')
                    ->indicator('Submission')
                    ->multiple()
                    ->label('Submission'),

                SelectFilter::make('student_id')
                    ->relationship('student', 'sv_name')
                    ->indicator('Student')
                    ->multiple()
                    ->label('Student'),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudentSubmissions::route('/'),
            'create' => Pages\CreateStudentSubmission::route('/create'),
            'view' => Pages\ViewStudentSubmission::route('/{record}'),
            'edit' => Pages\EditStudentSubmission::route('/{record}/edit'),
        ];
    }
}
