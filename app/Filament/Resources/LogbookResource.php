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

class LogbookResource extends Resource
{
    protected static ?string $model = Logbook::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $recordTitleAttribute = 'datetime';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                Grid::make(['default' => 0])->schema([
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

                    DatePicker::make('approval_date')
                        ->rules(['date'])
                        ->required()
                        ->placeholder('Approval Date')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    DatePicker::make('description')
                        ->rules(['date'])
                        ->required()
                        ->placeholder('Description')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('comment')
                        ->rules(['max:255', 'string'])
                        ->required()
                        ->placeholder('Comment')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    Select::make('student_id')
                        ->rules(['exists:students,id'])
                        ->required()
                        ->relationship('student', 'sv_name')
                        ->searchable()
                        ->placeholder('Student')
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
                    ->searchable(true, null, true)
                    ->limit(50),
                Tables\Columns\TextColumn::make('approval_date')
                    ->toggleable()
                    ->date(),
                Tables\Columns\TextColumn::make('description')
                    ->toggleable()
                    ->date(),
                Tables\Columns\TextColumn::make('comment')
                    ->toggleable()
                    ->searchable(true, null, true)
                    ->limit(50),
                Tables\Columns\TextColumn::make('student.sv_name')
                    ->toggleable()
                    ->limit(50),
            ])
            ->filters([
                DateRangeFilter::make('created_at'),

                SelectFilter::make('student_id')
                    ->relationship('student', 'sv_name')
                    ->indicator('Student')
                    ->multiple()
                    ->label('Student'),
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
