<?php

namespace App\Filament\Personal\Resources\TimesheetResource\Pages;

use App\Filament\Personal\Resources\TimesheetResource;
use App\Imports\MyTimesheetsImport;
use App\Models\Timesheet;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Barryvdh\DomPDF\Facade\Pdf;


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
                // ->keyBindings(['command+s', 'ctrl+s'])
                ->visible($this->enableWorkButton())
                ->action(function () {
                    $this->startWorkTimeSheet();
                    Notification::make()
                        ->title('Started successfully')
                        ->icon('heroicon-o-document-text')
                        ->iconColor('success')
                        ->send();
                })
                ,
            Action::make('In Pause')
                ->label('Pausar trabajo')
                ->color('warning')
                ->requiresConfirmation()
                ->visible($this->enablePauseButton())
                ->action(function () {
                    $this->pauseWorkTimesheet();
                    Notification::make()
                        ->title('Paused successfully')
                        ->color('warning')
                        ->icon('heroicon-o-document-text')
                        ->iconColor('success')
                        ->send();
                }),
                \EightyNine\ExcelImport\ExcelImportAction::make()
                    ->color("primary")
                    ->slideOver()
                    ->use(MyTimesheetsImport::class)
                    ,
            Action::make('CreatePDF')
                ->label('Generar PDF')
                ->color('warning')
                ->requiresConfirmation()
                ->action(function () {
                    $pdf = Pdf::loadView('pdf.ListTimesheets' , ['timesheets' => auth()->user()->timesheets()->get()]);
                    // return $pdf->download('example.pdf');
                    return response()->streamDownload(function () use ($pdf) { echo $pdf->stream(); }, 'name.pdf');
                })



                // Action::make('stop Pause')
                // ->label('Terminar Pausa')
                // ->color('danger')
                // ->requiresConfirmation()
                // ->action(function () {
                //     $this->endPauseTimesheet();
                // }),
                // // Actions\CreateAction::make()
                // // ->mutateFormDataUsing(function (array $data): array {
                // //     $data['user_id'] = auth()->id();
                // //     return $data;
                // // }),
            ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    private function enableWorkButton(): bool
    {
        $user = auth()->user();
        $timesheet = Timesheet::where('user_id', $user->id)->orderBy('id', 'desc')->where('type', 'work')->first();
        if ($timesheet != null && $timesheet->day_out == null) {
            return false;
        }

        return true;

    }

    private function enablePauseButton(): bool
    {
        return !$this->enableWorkButton();
    }
    private function startWorkTimeSheet(): void
    {
        $timesheet = new Timesheet();
        $user = auth()->user();
        $timesheet->user_id = $user->id;
        $timesheet->calendar_id = 1;
        $timesheet->day_in = Carbon::now();
        $timesheet->type = 'work';
        $timesheet->save();
        $this->endPauseTimesheet();
    }
    private function pauseWorkTimesheet(): void
    {
        $user = auth()->user();
        $timesheet = Timesheet::where('user_id', $user->id)->orderBy('id', 'desc')->where('type', 'work')->first();
        if ($timesheet != null && $timesheet->day_out == null) {
            $timesheet->day_out = Carbon::now();
            $timesheet->save();
            $this->startPauseTimesheet();
        }
    }

    private function startPauseTimesheet(): void
    {
        $timesheet = new Timesheet();
        $user = auth()->user();
        $timesheet->user_id = $user->id;
        $timesheet->calendar_id = 1;
        $timesheet->day_in = Carbon::now();
        $timesheet->type = 'pause';
        $timesheet->save();
    }

    private function endPauseTimesheet(): void
    {
        $user = auth()->user();
        $timesheet = Timesheet::where('user_id', $user->id)->orderBy('id', 'desc')->where('type', 'pause')->first();
        if ($timesheet != null && $timesheet->day_out == null) {
            $timesheet->day_out = Carbon::now();
            $timesheet->save();
        }
    }

}
