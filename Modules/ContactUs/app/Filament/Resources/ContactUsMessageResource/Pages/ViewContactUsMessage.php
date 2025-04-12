<?php

namespace Modules\ContactUs\Filament\Resources\ContactUsMessageResource\Pages;

use Filament\Resources\Pages\ViewRecord;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Modules\ContactUs\Actions\ReplyContactUsMessageAction;
use Modules\ContactUs\Filament\Resources\ContactUsMessageResource;

class ViewContactMessage extends ViewRecord
{
    protected static string $resource = ContactUsMessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make("reply")
                ->label(__("Reply to Message"))
                ->icon("heroicon-o-arrow-uturn-left")
                ->form([
                    \Filament\Forms\Components\Textarea::make("reply")
                        ->label("Reply")
                        ->required()
                        ->maxLength(1000),
                ])
                ->action(function (array $data) {
                    ReplyContactUsMessageAction::new()->handle(
                        $this->record,
                        $data["reply"]
                    );

                    Notification::make()
                        ->title(__("Reply submitted successfully"))
                        ->success()
                        ->send();
                })
                ->disabled(fn() => !is_null($this->record->replied_at))
                ->color("primary"),

            Action::make("mark_as_seen")
                ->translateLabel()
                ->icon("heroicon-o-eye")
                ->action(fn() => $this->record->update(["is_seen" => true]))
                ->disabled(fn() => $this->record->is_seen)
                ->color("success"),
        ];
    }
}
