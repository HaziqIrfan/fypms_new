<?php

namespace App\Filament\Resources\EvaluatorResource\RelationManagers;

use App\Models\Evaluator;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\{Form, Table};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Tables\Filters\MultiSelectFilter;
use Filament\Resources\RelationManagers\RelationManager;
use Illuminate\Database\Eloquent\Model;

class EvaluationResultsRelationManager extends RelationManager
{
    protected static string $relationship = 'evaluationResults';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(['default' => 0])->schema([
                TextInput::make('mark')
                    ->rules(['max:255', 'string'])
                    ->placeholder('Mark')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                Select::make('evaluation_id')
                    ->rules(['exists:evaluations,id'])
                    ->relationship('evaluation', 'title')
                    ->searchable()
                    ->placeholder('Evaluation')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('mark')->limit(50),
                Tables\Columns\TextColumn::make('evaluation.title')->limit(50),
                Tables\Columns\TextColumn::make('evaluator.id')->limit(50),
            ])
            ->filters([
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from'),
                        Forms\Components\DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (
                                    Builder $query,
                                    $date
                                ): Builder => $query->whereDate(
                                    'created_at',
                                    '>=',
                                    $date
                                )
                            )
                            ->when(
                                $data['created_until'],
                                fn (
                                    Builder $query,
                                    $date
                                ): Builder => $query->whereDate(
                                    'created_at',
                                    '<=',
                                    $date
                                )
                            );
                    }),

                MultiSelectFilter::make('evaluation_id')->relationship(
                    'evaluation',
                    'title'
                ),

                MultiSelectFilter::make('evaluator_id')->relationship(
                    'evaluator',
                    'id'
                ),
            ])
            ->headerActions([Tables\Actions\CreateAction::make()])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
    }
}
