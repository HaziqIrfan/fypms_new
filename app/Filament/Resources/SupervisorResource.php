<?php

namespace App\Filament\Resources;

use App\Models\Supervisor;
use Filament\{Tables, Forms};
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Filters\DateRangeFilter;
use App\Filament\Resources\SupervisorResource\Pages;
use App\Models\Student;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SupervisorResource extends Resource
{
    protected static ?string $model = Supervisor::class;

    protected static ?string $slug = "lecturers"; //change navigation label

    protected static ?string $navigationIcon = 'heroicon-o-users'; //change icon navside-bar

    protected static ?string $recordTitleAttribute = 'user.name';


    public static function getPluralModelLabel(): string
    {

        return "Lecturers";
    }

    public static function getModelLabel(): string
    {
        return "Lecturer";
    }

    // protected static function shouldRegisterNavigation(): bool
    // {
    //     if (Auth::user()->hasRole('Coordinator') || Auth::user()->hasRole('Super Admin')|| Auth::user()->hasRole('Student')) {

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
                        ->dehydrateStateUsing(fn ($state) => \Hash::make($state)) //hash-auto encrypt password
                        ->required(
                            fn (Component $livewire) => $livewire instanceof
                                Pages\CreateSupervisor
                        )
                        ->placeholder('Password')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('background')
                        ->rules(['max:255', 'string'])
                        ->required()
                        ->placeholder('Background')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('availability')
                        ->rules(['max:255', 'string'])
                        ->required()
                        ->placeholder('Availability')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    // Select::make('user_id')
                    //     ->rules(['exists:users,id'])
                    //     ->required()
                    //     ->relationship('user', 'name')
                    //     ->searchable()
                    //     ->placeholder('User')
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
                Tables\Columns\TextColumn::make('background')
                    ->toggleable()
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('availability')
                    ->toggleable()
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('user.name')
                    ->toggleable()
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

    public static function getRelations(): array
    {
        return [
            SupervisorResource\RelationManagers\StudentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSupervisors::route('/'),
            'create' => Pages\CreateSupervisor::route('/create'),
            'view' => Pages\ViewSupervisor::route('/{record}'),
            'edit' => Pages\EditSupervisor::route('/{record}/edit'),
        ];
    }
}
