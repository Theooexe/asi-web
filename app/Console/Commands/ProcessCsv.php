<?php

namespace App\Console\Commands;

use App\Jobs\ProcessCsvJob;
use Illuminate\Console\Command;

class ProcessCsv extends Command
{
    protected $signature = 'process:csv {path}';
    protected $description = 'Envoie un job de traitement CSV dans la queue file-processing';

    public function handle(): int
    {
        $path = $this->argument('path');

        ProcessCsvJob::dispatch($path)->onQueue('file-processing');

        $this->info("Job de traitement du fichier CSV envoyé à la queue 'file-processing'.");

        return Command::SUCCESS;
    }
}
