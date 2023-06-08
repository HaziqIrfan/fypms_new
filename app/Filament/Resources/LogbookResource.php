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
use Illuminate\Database\Eloquent\Model;

class LogbookResource extends Resource
{
    protected static ?string $model = Logbook::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open'; //change icon navside-bar 

    protected static ?string $recordTitleAttribute = '';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
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
                        })->getOptionLabelFromRecordUsing(fn (Model $record) => $record->name)
                        ->placeholder('Student')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    DatePicker::make('datetime')
                        ->rules(['date'])
                        ->required()
                        ->placeholder('Datetime')
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


                    TextInput::make('description')
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
                        ]),

                    TextInput::make('comment')
                        ->rules(['max:255', 'string'])
                        // ->required()
                        ->placeholder('Comment by Supervisor')
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
                Tables\Columns\TextColumn::make('datetime')
                    ->toggleable()
                    ->date(),
                Tables\Columns\TextColumn::make('week')
                    ->toggleable()
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('description')
                    ->toggleable()
                    ->searchable()
                    ->limit(50),
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
