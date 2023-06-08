<?php

namespace App\Filament\Resources\EvaluationResource\RelationManagers;

use App\Models\Evaluator;
use App\Models\Student;
use BaconQrCode\Common\Mode;
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

    protected static ?string $recordTitleAttribute = 'mark';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(['default' => 0])->schema([
                Select::make('student_id')
                    ->rules(['exists:students,id'])
                    ->required()
                    ->Searchable()
                    ->relationship('student', 'name')
                    ->getSearchResultsUsing(function (string $search) {
                        return Student::whereHas('user', function ($q) use ($search) {
                            $q->where('name', 'LIKE', "%{$search}%");
                        })->get()->pluck('name', 'id');
                    })
                    ->getOptionLabelFromRecordUsing(function (Model $record) {
                        return $record->student->name;
                    })

                    ->placeholder('Student Name')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),
                TextInput::make('mark')
                    ->rules(['max:255', 'string'])
                    ->placeholder('Mark')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),
                TextInput::make('comment')
                    ->rules(['max:255', 'string'])
                    ->placeholder('Comments')
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
                Tables\Columns\TextColumn::make('comment')->limit(50),
                Tables\Columns\TextColumn::make('evaluation.title')->limit(50),
                Tables\Columns\TextColumn::make('student.name')->limit(50),
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
            ->headerActions([Tables\Actions\CreateAction::make()->mutateFormDataUsing(function (array $data): array {
                $data['evaluator_id'] = auth()->user()->evaluator->id;
         
                return $data;
            })])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
    }
}
