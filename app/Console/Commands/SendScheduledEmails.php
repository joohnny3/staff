<?php

namespace App\Console\Commands;

use App\Mail\TestMail;
use App\Models\EmailJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendScheduledEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send-scheduled';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send scheduled emails';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $emailJobs = EmailJob::where('status', 0)->get();

        foreach ($emailJobs as $job) {
            Mail::to($job->email)->send(new TestMail($job->param));
            $job->update(['status' => 1]);
        }

        $this->info('Scheduled emails sent successfully');
    }

}
