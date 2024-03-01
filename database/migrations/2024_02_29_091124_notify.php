<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notify', function (Blueprint $table) {
            $table->id();

            $table->string('recipient', 24)->comment('收件者名稱');
            $table->text('email')->nullable()->comment('電子信箱');
            $table->longText('carbon_copy')->nullable()->comment('副本');
            $table->longText('blind_carbon_copy')->nullable()->comment('秘密附件');
            $table->string('subject', 100)->comment('主旨');
            $table->longText('content')->comment('內文');
            $table->string('template', 24)->comment('模板');
            $table->tinyInteger('service')->comment('服務 1:Gmail 2:Line 3:Jandi 4:Slack ');
            $table->longText('attachment')->nullable()->comment('附件');
            $table->longText('extra')->nullable()->comment('其他');
            $table->dateTime('sent_time')->nullable()->comment('發送時間 null:通知尚未發送');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notify');
    }
};
