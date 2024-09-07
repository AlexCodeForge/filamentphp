<?php

namespace App\Filament\Resources\HolidayResource\Pages;

use App\Filament\Resources\HolidayResource;
use App\Mail\HolidayStatusConfirmation;
use App\Models\Holiday;
use App\Models\User;
use Filament\Actions;
use Filament\Notifications\Actions\Action as NotificationAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Mail;


class EditHoliday extends EditRecord
{
    protected static string $resource = HolidayResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $holiday = Holiday::find($this->record->id);
        $newRecordUrl = HolidayResource::getUrl('edit', ['record' => $this->record], panel: 'personal');
        $recipient = $holiday->user;
        if ($holiday->type == 'approve') {
            Notification::make()
                ->title($this->record->user->name . ' your holiday has been approved.')
                ->success()
                ->body('Congratulations see details below.')
                ->actions([
                    NotificationAction::make('view')
                        ->button()
                        ->url($newRecordUrl)
                        ->markAsRead(),
                ])
                ->sendToDatabase($recipient);
                Mail::to($recipient)->send(new HolidayStatusConfirmation($recipient , $holiday));

        } elseif ($holiday->type == 'decline') {
            Notification::make()
                ->title($this->record->user->name . ' your holiday has been rejected.')
                ->danger()
                ->body('See details below.')
                ->actions([
                    NotificationAction::make('view')
                        ->button()
                        ->url($newRecordUrl)
                        ->markAsRead(),
                ])
                ->sendToDatabase($recipient);
                Mail::to($recipient)->send(new HolidayStatusConfirmation($recipient , $holiday));

        }
    }
}
