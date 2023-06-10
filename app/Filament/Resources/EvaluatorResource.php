<?php

namespace App\Filament\Resources;

use App\Models\Evaluator;
use Filament\{Tables, Forms};
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Filters\DateRangeFilter;
use App\Filament\Resources\EvaluatorResource\Pages;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class EvaluatorResource extends Resource
{
    protected static ?string $model = Evaluator::class;

    protected static ?string $navigationIcon = 'heroicon-o-users'; //change icon navside-bar


    // protected static function shouldRegisterNavigation(): bool
    // {
    //     return false;
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
                        ->hiddenOn(['edit', 'view'])
                        ->dehydrateStateUsing(fn ($state) => \Hash::make($state)) //hash-auto encrypt password
                        ->required(
                            fn (Component $livewire) => $livewire instanceof
                                Pages\CreateEvaluator
                        )
                        ->placeholder('Password')
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
                    ->searchable() //search by name
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
            EvaluatorResource\RelationManagers\StudentsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvaluators::route('/'),
            'create' => Pages\CreateEvaluator::route('/create'),
            'view' => Pages\ViewEvaluator::route('/{record}'),
            'edit' => Pages\EditEvaluator::route('/{record}/edit'),
        ];
    }
}
