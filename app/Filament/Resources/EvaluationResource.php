<?php

namespace App\Filament\Resources;

use App\Models\Evaluation;
use Filament\{Tables, Forms};
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use App\Filament\Filters\DateRangeFilter;
use App\Filament\Resources\EvaluationResource\Pages;
use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Facades\Auth;

class EvaluationResource extends Resource
{
    protected static ?string $model = Evaluation::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-list'; //change icon navside-bar

    protected static ?string $recordTitleAttribute = 'title';

    // protected static function shouldRegisterNavigation(): bool
    // {
    //     if (Auth::user()->hasRole('Coordinator') || Auth::user()->hasRole('Super Admin')|| Auth::user()->hasRole('Evaluators')) {

    //         return true;
    //     } else {
    //         return false;
    //     }
    // }
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

                    // RichEditor::make('rubric_file_path')
                    //     ->rules(['max:255', 'string'])
                    //     ->required()
                    //     ->placeholder('Rubric File Path')
                    //     ->columnSpan([
                    //         'default' => 12,
                    //         'md' => 12,
                    //         'lg' => 12,
                    //     ]),

                    DatePicker::make('start_date')
                        ->rules(['date'])
                        ->required()
                        ->placeholder('Start Date')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    DatePicker::make('end_date')
                        ->rules(['date'])
                        ->required()
                        ->placeholder('End Date')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),
                    FileUpload::make('rubric_file_path') //Refer documentation filament: #File upload
                        ->disk('posts')
                        // ->multiple()
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
                // Tables\Columns\TextColumn::make('rubric_file_path')
                //     ->toggleable()
                //     ->searchable()
                //     ->limit(50),
                Tables\Columns\TextColumn::make('start_date')
                    ->toggleable()
                    ->date(),
                Tables\Columns\TextColumn::make('end_date')
                    ->toggleable()
                    ->date(),
            ])
            ->filters([DateRangeFilter::make('created_at')]);
    }

    public static function getRelations(): array
    {
        return [
            EvaluationResource\RelationManagers\EvaluationResultsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvaluations::route('/'),
            'create' => Pages\CreateEvaluation::route('/create'),
            'view' => Pages\ViewEvaluation::route('/{record}'),
            'edit' => Pages\EditEvaluation::route('/{record}/edit'),
        ];
    }
}
