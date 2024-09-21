<?php

namespace App\Console\Commands\App;

use App\Models\User;
use Illuminate\Console\Command;
use App\Notifications\User\WelcomeEmailNotification;

class SentEmailTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sent-email-test {email} {--type=welcome}';

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
        $email = $this->argument('email');
        $user = User::where('email', $email)->first();

        if($this->option('type') == 'welcome') {
            $user->notify(new WelcomeEmailNotification());
        }
        if($this->option('type') == 'verify') {
            $user->sendEmailVerificationNotification();
        }
    }
}
