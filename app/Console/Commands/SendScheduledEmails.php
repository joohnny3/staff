<?php

namespace App\Console\Commands;

use App\Mail\MailNotify;
use App\Models\Notify;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Exception;

class SendScheduledEmails extends Command
{
    protected $signature = 'email:send-emails';

    protected $description = 'Send emails';

    public function handle(): void
    {
        $notifies = Notify::where('status', 0)->get();

        foreach ($notifies as $notify) {
            $carbonCopy = json_decode($notify->carbon_copy, true);
            $blindCarbonCopy = json_decode($notify->blind_carbon_copy, true);
            $attachment = json_decode($notify->attachment, true);
            $content = json_decode($notify->content);

            try {
                Mail::to($notify->email)
                    ->send(new MailNotify(
                        $notify->recipient,
                        $carbonCopy,
                        $blindCarbonCopy,
                        $notify->subject,
                        $content,
                        $notify->template,
                        $attachment
                    ));

                $notify->update(['status' => 1]);
            } catch (Exception $e) {
                $notify->update(['status' => -1]);
                Log::error('發送信件失敗
                    Notify ID: ' . $notify->id .
                    'message: ' . $e->getMessage() .
                    'at line: ' . $e->getLine());

            }
        }
    }
}
