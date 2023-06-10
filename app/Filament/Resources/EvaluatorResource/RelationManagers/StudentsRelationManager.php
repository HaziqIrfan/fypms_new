<?php

namespace App\Filament\Resources\EvaluatorResource\RelationManagers;

use App\Models\Student;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\AttachAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentsRelationManager extends RelationManager
{
    protected static string $relationship = 'students';

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user_id')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label("Student Name"),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
                Tables\Actions\AttachAction::make()->form(fn (AttachAction $action): array => [
                    Select::make('recordId')
                        ->required()
                        ->Searchable()
                        ->relationship('user', 'name')
                        ->getSearchResultsUsing(function (string $search) use($action){
                            // dd($action->getRecordSelect());
                            // dd(Student::whereHas('user', function ($q) use ($search) {
                            //     $q->where('name', 'LIKE', "%{$search}%");
                            // })->get());
                            return Student::whereHas('user', function ($q) use ($search) {
                                $q->where('name', 'LIKE', "%{$search}%");
                            })->get()->pluck('name', 'user_id');
                        })->getOptionLabelFromRecordUsing(fn (Model $record) => $record->name)
                        ->label('Student')
                        ->dehydrateStateUsing(fn ($state) => User::find($state)->student->id)
                       ,
                ]),
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
