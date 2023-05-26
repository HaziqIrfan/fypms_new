<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use App\Models\User;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;

    protected function afterCreate(): void
    {
        $recipient = User::get();
        // Runs after the form fields are saved to the database.
        Notification::make()
            ->title('Saved successfully')
            ->sendToDatabase($recipient);
    }
}
