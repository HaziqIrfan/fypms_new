<?php

namespace App\Filament\Resources\EvaluationResource\RelationManagers;

use App\Models\Evaluator;
use App\Models\Student;
use App\Models\Supervisor;
use BaconQrCode\Common\Mode;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\{Form, Table};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Filters\MultiSelectFilter;
use Filament\Resources\RelationManagers\RelationManager;
use Illuminate\Database\Eloquent\Model;

class EvaluationResultsRelationManager extends RelationManager
{
    protected static string $relationship = 'evaluationResults';

    protected function getTableQuery(): Builder
    {
        if (auth()->user()->hasRole('Student')){

            return $this->ownerRecord->evaluationResults()->where('student_id', auth()->user()->student->id)->getQuery();
         }
         else if(auth()->user()->hasRole('Coordinator')){
           return $this->ownerRecord->evaluationResults()->getQuery();
       }
         else if(auth()->user()->hasRole('Supervisor')){
              $students_id=auth()->user()->supervisors->students->pluck('id');
             return $this->ownerRecord->evaluationResults()->whereIn('student_id', $students_id)->getQuery();
             
         }
        
    }



    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(['default' => 0])->schema([
                Select::make('student_id')
                    ->rules(['exists:students,id'])
                    ->required()
                    ->Searchable()
                    ->relationship('student', 'id', function (Builder $query, $record) {
                        if (
                            $record == null
                        ) {
                            // For create page
                            return $query->whereHas('user');
                        } else {
                            // For edit page
                            return $query->whereHas('user');
                        }
                    })
                    ->getSearchResultsUsing(function (string $search) {
                        return Student::whereHas('user', function ($q) use ($search) {
                            $q->where('name', 'LIKE', "%{$search}%");
                            $q->orWhere('matric_id', 'LIKE', "%{$search}%");
                        })->with('user')->get()->pluck('matric_name', 'id');
                    })->getOptionLabelFromRecordUsing(fn (Model $record) => $record->matric_name)
                    ->placeholder('Student')
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
                Textarea::make('comment')
                    ->rules(['max:255', 'string'])
                    ->rows(5)
                    ->cols(20)
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
                Tables\Columns\TextColumn::make('mark')
                    ->sortable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('evaluation.title')
                    ->sortable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('student.user.matric_id')
                    ->label('Matric ID')
                    ->limit(50),
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
