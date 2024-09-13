<?php

namespace App\Console\Commands\App;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class GeneratePhpDoc extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:docs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $phpdocPath = base_path('phpDoc.phar');
        $targetDirectory = base_path('.phpdoc/docs');

        $process = new Process(['php', $phpdocPath, '--directory', 'app,config,database,routes,tests', '--target', $targetDirectory]);
        $process->setTimeout(1800);

        $process->start();

        foreach ($process as $type => $data) {
            if ($process::OUT === $type) {
                $this->info($data);
            } else { // $process::ERR === $type
                $this->error($data);
            }
        }

        // Check if the process ended successfully
        if (!$process->isSuccessful()) {
            $this->error('The PHP documentation generation failed.');
            $this->error($process->getErrorOutput());
            return 1;
        }

        $this->info('PHP documentation generated successfully.');
        return 0; 
    }
}
