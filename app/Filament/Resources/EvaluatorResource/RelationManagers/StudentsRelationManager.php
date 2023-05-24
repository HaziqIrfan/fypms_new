<?php

namespace App\Filament\Resources\EvaluatorResource\RelationManagers;

use App\Models\Evaluator;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Contracts\HasRelationshipTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentsRelationManager extends RelationManager
{
    protected static string $relationship = 'Students';

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('id')
                    ->rules(['exists:students,id'])
                    ->required()
                    ->Searchable()
                    ->getSearchResultsUsing(function (string $search) {
                        return Student::whereHas('user', function ($q) use ($search) {
                            $q->where('name', 'LIKE', "%{$search}%");
                        })->get()->pluck('name', 'id');
                    })->getOptionLabelFromRecordUsing(fn (Model $record) => $record->name)
                    ->placeholder('ex: Mohsin')->label('Student')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->using(function (HasRelationshipTable $livewire, array $data): Model {
                     $livewire->ownerRecord->students()->attach($data['id']);

                     return new Student;
                }),
                // Tables\Actions\AttachAction::make(),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Tables\Actions\DetachAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\DetachBulkAction::make(),
                // Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
