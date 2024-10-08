<?php

namespace App\Filament\Personal\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Timesheet;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Resources\Resource;
use Filament\Tables\Actions\ActionGroup;
use pxlrbt\FilamentExcel\Columns\Column;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use App\Filament\Personal\ExcelExport\CustomExport;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use App\Filament\Personal\Resources\TimesheetResource\Pages;
use App\Filament\Personal\Resources\TimesheetResource\RelationManagers;


class TimesheetResource extends Resource
{
    protected static ?string $model = Timesheet::class;

    protected static ?string $navigationIcon = 'heroicon-o-table-cells';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->orderBy('id', 'desc')->where('user_id', auth()->user()->id);
    }



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('calendar_id')
                    ->relationship('calendar', 'name')
                    ->required(),
                Forms\Components\select::make('type')
                    ->options([
                        'work' => 'Working',
                        'pause' => 'In pause',
                    ])
                    ->required(),
                Forms\Components\DateTimePicker::make('day_in')
                    ->required(),
                Forms\Components\DateTimePicker::make('day_out')
                    ->required()
                    ->after('day_in'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('calendar.name')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('day_in')
                    ->dateTime()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('day_out')
                    ->dateTime()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->options([
                        'work' => 'Working',
                        'pause' => 'In pause',
                    ]),

            ])
            ->actions([
                // ActionGroup::make([
                //     Tables\Actions\EditAction::make()
                //         ->label('Editar'),
                //     Tables\Actions\DeleteAction::make(),
                //     // Tables\Actions\Action::make('Create')
                //     //     ->form([
                //     //         Forms\Components\Select::make('calendar_id')
                //     //             ->relationship('calendar', 'name')
                //     //             ->required(),
                //     //         Forms\Components\select::make('type')
                //     //             ->options([
                //     //                 'work' => 'Working',
                //     //                 'pause' => 'In pause',
                //     //             ])
                //     //             ->required(),
                //     //         Forms\Components\DateTimePicker::make('day_in')
                //     //             ->required(),
                //     //         Forms\Components\DateTimePicker::make('day_out')
                //     //             ->required()
                //     //             ->after('day_in'),
                //     //     ])
                // ])->iconButton()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make()->exports([
                        ExcelExport::make('table')
                            ->fromTable()
                            ->withFilename( 'Timesheet ' . date('Y-m-d') . ' - export')
                            // ->askForFilename()
                            // ->askForWriterType()
                            // ->only([
                            //     'user.name',
                            //     'type'
                            // ])
                            ->queue(),
                        // CustomExport::make('table')->fromTable()
                        //     ->queue(),
                        ExcelExport::make('form')->fromForm(),
                    ]),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTimesheets::route('/'),
            // 'create' => Pages\CreateTimesheet::route('/create'),
            // 'edit' => Pages\EditTimesheet::route('/{record}/edit'),
        ];
    }
}
