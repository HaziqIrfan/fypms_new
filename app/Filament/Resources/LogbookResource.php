<?php

namespace App\Filament\Resources;

use App\Models\Logbook;
use Filament\{Tables, Forms};
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Filters\DateRangeFilter;
use App\Filament\Resources\LogbookResource\Pages;
use App\Models\Student;
use Filament\Forms\Components\Textarea;
use Illuminate\Database\Eloquent\Model;

class LogbookResource extends Resource
{
    protected static ?string $model = Logbook::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open'; //change icon navside-bar 

    protected static ?string $navigationGroup = 'FYP';



    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                Grid::make(['default' => 0])->schema([
                    DatePicker::make('datetime')
                        ->rules(['date'])
                        ->required()
                        ->placeholder('Today Date')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('user.name')
                        ->rules(['max:255', 'string'])
                        ->required()
                        ->hiddenOn(['create', 'edit'])
                        ->placeholder('Name')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('user.matric_id')
                        ->rules(['max:255', 'string'])
                        ->required()
                        ->placeholder('Matric ID')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('student.psm_status')
                        ->rules(['max:255', 'string'])
                        ->required()
                        ->placeholder('PSM Status')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('week')
                        ->rules(['max:255', 'string'])
                        ->required()
                        ->placeholder('Week')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),


                    Textarea::make('description')
                        ->rows(5)
                        ->cols(20)
                        ->rules(['max:255', 'string'])
                        ->required()
                        ->placeholder('Description')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    DatePicker::make('approval_date')
                        ->rules(['date'])
                        // ->required()
                        ->placeholder('Approval Date by Supervisor')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ])
                        ->hidden(function (string $context) {
                            if ($context == "create" || $context == "edit") {
                                if (auth()->user()->hasRole('Student')) {
                                    return true;
                                }
                            }
                            return false;
                        }),

                    Textarea::make('comment')
                        ->rows(5)
                        ->cols(20)
                        ->rules(['max:255', 'string'])
                        // ->required()
                        ->placeholder('Comment by Supervisor')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ])
                        ->hidden(function (string $context) {
                            if ($context == "create" || $context == "edit") {
                                if (auth()->user()->hasRole('Student')) {
                                    return true;
                                }
                            }
                            return false;
                        }),


                ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->poll('60s')
            ->columns([
                Tables\Columns\TextColumn::make('datetime')
                    ->sortable()
                    ->toggleable()
                    ->date(),
                Tables\Columns\TextColumn::make('week')
                    ->sortable()
                    ->toggleable()
                    ->searchable()
                    ->limit(50),
                // Tables\Columns\TextColumn::make('description')
                //     ->toggleable()
                //     ->searchable()
                //     ->limit(50),
                Tables\Columns\TextColumn::make('approval_date')
                    ->toggleable()
                    ->date(),
                Tables\Columns\TextColumn::make('comment')
                    ->toggleable()
                    ->searchable()
                    ->limit(50),
            ])
            ->filters([
                DateRangeFilter::make('created_at'),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLogbooks::route('/'),
            'create' => Pages\CreateLogbook::route('/create'),
            'view' => Pages\ViewLogbook::route('/{record}'),
            'edit' => Pages\EditLogbook::route('/{record}/edit'),
        ];
    }
}
