<?php

namespace App\Filament\Resources;

use App\Models\Student;
use Filament\{Tables, Forms};
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Filters\DateRangeFilter;
use App\Filament\Resources\StudentResource\Pages;
use App\Models\Supervisor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap'; //change icon navside-bar

    

    // protected static function shouldRegisterNavigation(): bool
    // {
    //     if (Auth::user()->hasRole('Coordinator') || Auth::user()->hasRole('Super Admin') || Auth::user()->hasRole('Supervisor')) {

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

                    TextInput::make('user.name') //user.name = table user, column name 
                        ->rules(['max:255', 'string'])
                        ->required()
                        ->placeholder('Name')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('user.email') //user.email = table user, column email 
                        ->rules(['email'])
                        ->required()
                        ->unique(
                            'users',
                            'email',
                            function (?Model $record) {
                                if ($record != null) {
                                    return $record->user;
                                }
                            }
                        )
                        ->email()
                        ->placeholder('Email')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('user.password')
                        ->required()
                        ->password()
                        ->hiddenOn(['edit','view'])
                        ->dehydrateStateUsing(fn ($state) => \Hash::make($state)) //hash-auto encrypt password
                        ->required(
                            fn (Component $livewire) => $livewire instanceof
                                Pages\CreateStudent
                        )
                        ->placeholder('Password')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),
                    TextInput::make('project_title')
                        ->rules(['max:255', 'string'])
                        ->required()
                        ->placeholder('Project Title')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('psm_status')
                        ->rules(['max:255', 'string'])
                        ->required()
                        ->placeholder('Psm Status')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('year')
                        ->rules(['max:255', 'string'])
                        ->required()
                        ->placeholder('Year')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('program')
                        ->rules(['max:255', 'string'])
                        ->required()
                        ->placeholder('Program')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('pa_name')
                        ->rules(['max:255', 'string'])
                        ->required()
                        ->placeholder('Pa Name')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    Select::make('supervisor_id')
                        ->rules(['exists:supervisors,id'])
                        ->required()
                        ->Searchable()
                        ->relationship('supervisor', 'name')
                        ->getSearchResultsUsing(function (string $search) {
                            return Supervisor::whereHas('user', function ($q) use ($search) {
                                $q->where('name', 'LIKE', "%{$search}%");
                            })->get()->pluck('name', 'id');
                        })->getOptionLabelFromRecordUsing(fn (Model $record) => $record->name)
                        ->placeholder('Supervisor')
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
                Tables\Columns\TextColumn::make('user.name')
                ->toggleable()
                ->searchable()
                ->limit(50),
                Tables\Columns\TextColumn::make('project_title')
                    ->toggleable()
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('psm_status')
                    ->toggleable()
                    ->searchable()
                    ->limit(50),
                // Tables\Columns\TextColumn::make('year')
                //     ->toggleable()
                //     ->searchable()
                //     ->limit(50),
                Tables\Columns\TextColumn::make('program')
                    ->toggleable()
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('pa_name')
                    ->toggleable()
                    ->searchable()
                    ->limit(50),

            ])
            ->filters([
                DateRangeFilter::make('created_at'),

                SelectFilter::make('user_id')
                    ->relationship('user', 'name')
                    ->indicator('User')
                    ->multiple()
                    ->label('User'),
            ]);
    }

    // public static function getRelations(): array
    // {
    //     return [
    //          StudentResource\RelationManagers\LogbooksRelationManager::class,
    //         StudentResource\RelationManagers\StudentSubmissionsRelationManager::class,
    //         StudentResource\RelationManagers\EvaluationResultsRelationManager::class,
    //     ];
    // }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'view' => Pages\ViewStudent::route('/{record}'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}
