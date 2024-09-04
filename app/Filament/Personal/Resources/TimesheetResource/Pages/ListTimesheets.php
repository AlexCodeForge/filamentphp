<?php

namespace App\Filament\Personal\Resources\TimesheetResource\Pages;

use Filament\Actions;
use App\Models\Timesheet;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Personal\Resources\TimesheetResource;
use Carbon\Carbon;

class ListTimesheets extends ListRecords
{
    protected static string $resource = TimesheetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('In work')
                ->label('Entrar a trabajar')
                ->color('success')
                ->requiresConfirmation()
                ->keyBindings(['command+s', 'ctrl+s'])
                ->action(function () {
                    $user = auth()->user();
                    $timesheet = new Timesheet();
                    $timesheet->user_id = $user->id;
                    $timesheet->calendar_id = 1;
                    $timesheet->day_in = Carbon::now();
                    $timesheet->day_out = Carbon::now();
                    $timesheet->type = 'work';
                    $timesheet->save();
                }),
            Action::make('In Pause')
                ->label('A la pausa')
                ->color('warning')
                ->requiresConfirmation(),
            Actions\CreateAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
