<?php

namespace App\Filament\Personal\Resources\HolidayResource\Pages;

use App\Models\User;
use Filament\Actions;
use App\Mail\HolidayRequest;
use Illuminate\Support\Facades\Mail;

use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Personal\Resources\HolidayResource;
use Filament\Notifications\Actions\Action as NotificationAction;

class CreateHoliday extends CreateRecord
{
    protected static string $resource = HolidayResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        $data['type'] = 'pending';

        return $data;
    }

    protected function afterCreate(): void
    {
        $newRecordUrl = HolidayResource::getUrl('edit', ['record' => $this->record], panel: 'admin');
        $recipient = User::find(1); //This is admin

        Notification::make()
        ->title('User ' . $this->record->user->name . ' has requested a holiday.')
        ->success()
        ->body('Your action is requested.')
        ->actions([
            NotificationAction::make('view')
                ->button()
                ->url($newRecordUrl)
                ->markAsRead(),
        ])
        ->sendToDatabase($recipient);

        Mail::to($recipient)->send(new HolidayRequest( auth()->user(), $newRecordUrl ));
    }
}
