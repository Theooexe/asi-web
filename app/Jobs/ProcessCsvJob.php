<?php
namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Enums\Roles;

class ProcessCsvJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public function __construct(public string $path)
    {
    }

    public function handle(): void
    {
        $filePath = storage_path('app/' . $this->path);
        $rows = $this->readCsv($filePath);

        $count = 0;

        foreach ($rows as $line) {
            if (count($line) < 2) continue;

            [$name, $email] = $line;

            if (User::where('email', $email)->exists()) continue;

            User::create([
                'name'  => $name,
                'email' => $email,
                'role'  => Roles::Client->value,
            ]);

            $count++;
        }

        Log::info(" {$count} utilisateurs importés depuis {$this->path}");
    }

    private function readCsv(string $path): array
    {
        $file = fopen($path, 'r');
        $data = [];
        while (($line = fgetcsv($file)) !== false) {
            $data[] = $line;
        }
        fclose($file);
        return $data;
    }
}
