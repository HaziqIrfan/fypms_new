<?php

namespace App\Filament\Resources\SupervisorResource\RelationManagers;

use App\Models\Student;
use App\Models\Supervisor;
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
                    return Student::whereHas('user', function ($q) use ($search){
                        $q->where('name','LIKE', "%{$search}%");
                    })->get()->pluck('name','id');

                })->getOptionLabelFromRecordUsing(fn(Model $record)=>$record->name)
                ->placeholder('Student')
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
                Tables\Columns\TextColumn::make('user.name')->label('Supervisee'),
                                
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make() ->using(function (HasRelationshipTable $livewire, array $data): Model {
                //     $supervisor = Supervisor::find($livewire->ownerRecord->id); 
                //     $supervisor->students()->syncWithoutDetaching($data['id']);

                //     return $supervisor;
                // }),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\DeleteBulkAction::make(),
            ]);
    }    
}
