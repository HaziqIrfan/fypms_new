<?php

namespace App\Filament\Resources\SubmissionResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\{Form, Table};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Filters\MultiSelectFilter;
use Filament\Resources\RelationManagers\RelationManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class StudentSubmissionsRelationManager extends RelationManager
{
    protected static string $relationship = 'studentSubmissions';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(['default' => 0])->schema([

                FileUpload::make('file_path') //Refer documentation filament: #File upload
                    ->disk('studentsubmissions')
                    ->enableReordering()
                    ->enableOpen()
                    ->preserveFilenames()
                    ->enableDownload()
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
        if (Auth::user()->hasRole('Student')) {
            $table->headerActions([
                Tables\Actions\CreateAction::make()->mutateFormDataUsing(function (array $data, RelationManager $livewire): array {
                    $data['student_id'] = auth()->user()->student->id;
                    $data['submission_id'] = $livewire->ownerRecord->id;
                    return $data;
                }),
            ]);
        }

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('student.user.name')->label("Student Name")->limit(50)->searchable(),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->label("Submission Date"),
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
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date)
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date)
                            );
                    }),
                MultiSelectFilter::make('submission_id')->relationship('submission', 'title'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
