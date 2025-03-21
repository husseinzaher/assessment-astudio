<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

/**
 * @see Generated By Chatgpt
 */
class GeneratePassportEnvCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'passport:generate-personal-access-env {--env=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Passport personal access client and update env file';

    /**
     * Execute the console command.
     *
     * @return int
     */

    /**
     * Execute the console command.
     *
     * @return int
     *
     * @throws FileNotFoundException
     */
    public function handle()
    {
        $this->info('Creating personal access client...');
        Artisan::call('passport:client', [
            '--personal' => true,
            '--name' => 'Personal Access Client -' . date('Y-m-d H:i:s'),
        ]);

        $output = Artisan::output();
        if (preg_match('/Client ID ................................................................................................... \s*(\S+)/', $output, $idMatches)) {
            $clientId = $idMatches[1];
        } else {
            $this->error('Failed to extract Client ID from command output.');

            return 1;
        }

        if (preg_match('/Client secret ........................................................................................... \s*(\S+)/', $output, $secretMatches)) {
            $clientSecret = $secretMatches[1];
        } else {
            $this->error('Failed to extract Client Secret from command output.');

            return 1;
        }

        $environmentFile = $this->option('env')
            ? base_path('.env') . '.' . $this->option('env')
            : base_path('.env');

        $environmentContents = File::get($environmentFile);

        if (strpos($environmentContents, 'PASSPORT_PERSONAL_ACCESS_CLIENT_ID=') !== false) {
            $environmentContents = preg_replace(
                '/PASSPORT_PERSONAL_ACCESS_CLIENT_ID=.*/',
                "PASSPORT_PERSONAL_ACCESS_CLIENT_ID='$clientId'",
                $environmentContents
            );
        } else {
            $environmentContents .= "\nPASSPORT_PERSONAL_ACCESS_CLIENT_ID='$clientId'";
        }

        if (strpos($environmentContents, 'PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET=') !== false) {
            $environmentContents = preg_replace(
                '/PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET=.*/',
                "PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET='$clientSecret'",
                $environmentContents
            );
        } else {
            $environmentContents .= "\nPASSPORT_PERSONAL_ACCESS_CLIENT_SECRET='$clientSecret'";
        }

        File::put($environmentFile, $environmentContents);

        $this->info("'Updated env {$this->option('env')} file with the following credentials:'");
        $this->info('PASSPORT_PERSONAL_ACCESS_CLIENT_ID=' . $clientId);
        $this->info('PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET=' . $clientSecret);

        return 0;
    }
}
