<?php

namespace App\Filament\Resources;

use App\Models\EvaluationResult;
use Filament\{Tables, Forms};
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Filters\DateRangeFilter;
use App\Filament\Resources\EvaluationResultResource\Pages;
use App\Models\Evaluator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class EvaluationResultResource extends Resource
{
    protected static ?string $model = EvaluationResult::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-check'; //change icon navside-bar

    protected static ?string $navigationGroup = 'FYP';

    protected static function shouldRegisterNavigation(): bool
    {
        if (Auth::user()->hasRole('Student') || Auth::user()->hasRole('Supervisor')) {

            return false;
        } else {
            return true;
        }
    }
    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                Grid::make(['default' => 0])->schema([
                    TextInput::make('mark')
                        ->rules(['max:255', 'string'])
                        ->required()
                        ->placeholder('Mark')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    Select::make('evaluation_id')
                        ->rules(['exists:evaluations,id'])
                        ->required()
                        ->relationship('evaluation', 'title')
                        ->searchable()
                        ->placeholder('Evaluation')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),


                    // Select::make('evaluator_id')
                    //     ->rules(['exists:evaluators,id'])
                    //     ->required()
                    //     ->Searchable()
                    //     ->relationship('evaluator', 'name')
                    //     ->getSearchResultsUsing(function (string $search) {
                    //         return Evaluator::whereHas('user', function ($q) use ($search) {
                    //             $q->where('name', 'LIKE', "%{$search}%");
                    //         })->get()->pluck('name', 'id');
                    //     })->getOptionLabelFromRecordUsing(fn (Model $record) => $record->name)
                    //     ->placeholder('Evaluators')
                    //     ->columnSpan([
                    //         'default' => 12,
                    //         'md' => 12,
                    //         'lg' => 12,
                    //     ]),
                ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->poll('60s')
            ->columns([
                Tables\Columns\TextColumn::make('mark')
                    ->sortable()
                    ->toggleable()
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('evaluation.title')
                    ->sortable()
                    ->toggleable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('evaluator.id')
                    ->sortable()
                    ->toggleable()
                    ->limit(50),
            ])
            ->filters([
                DateRangeFilter::make('created_at'),

                SelectFilter::make('evaluation_id')
                    ->relationship('evaluation', 'title')
                    ->indicator('Evaluation')
                    ->multiple()
                    ->label('Evaluation'),

                SelectFilter::make('evaluator_id')
                    ->relationship('evaluator', 'id')
                    ->indicator('Evaluator')
                    ->multiple()
                    ->label('Evaluator'),

                // SelectFilter::make('evaluator_id')
                //     ->relationship('evaluator', 'name') // Modify 'id' to 'name'
                //     ->displayUsing(fn ($value) => $value->name) // Display the evaluator's name
                //     ->searchable() // Enable searching by evaluator's ID
                //     ->indicator('Evaluator')
                //     ->multiple()
                //     ->label('Evaluator'),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvaluationResults::route('/'),
            'create' => Pages\CreateEvaluationResult::route('/create'),
            'view' => Pages\ViewEvaluationResult::route('/{record}'),
            'edit' => Pages\EditEvaluationResult::route('/{record}/edit'),
        ];
    }
}
