<?php

namespace App\Listeners;

use App\Events\UserCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;

class DownloadUserAvatar implements ShouldQueue
{
    public $connection = 'database';
    public $queue = 'avatars';

    /**
     * Téléchargement et sauvegarde de l'avatar depuis l’API UI-Avatars.
     */
    private function downloadAvatar(string $name): bool
    {
        $url = "https://ui-avatars.com/api/?name=" . urlencode($name);
        $avatar = file_get_contents($url);
        return Storage::put("avatars/{$name}.png", $avatar);
    }

    /**
     * Méthode exécutée quand l’événement UserCreated est déclenché.
     */
    public function handle(UserCreated $event): void
    {
        $this->downloadAvatar($event->name);
    }
}
