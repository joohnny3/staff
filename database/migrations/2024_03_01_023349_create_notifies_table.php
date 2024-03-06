<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notify', function (Blueprint $table) {
            $table->id();

            $table->string('recipient_name', 24)->comment('接收者姓名');
            $table->text('email')->nullable()->comment('電子郵件');
            $table->longText('carbon_copy')->nullable()->comment('副本 JsonString:array');
            $table->longText('blind_carbon_copy')->nullable()->comment('密件副本 JsonString:array');
            $table->string('subject', 100)->comment('主旨');
            $table->longText('content')->comment('內文 Json:Object');
            $table->string('template', 24)->comment('模板 blade:檔案名稱');
            $table->tinyInteger('service')->comment('通知服務  1:Gmail 2:Line 3:Jandi 4:Slack');
            $table->longText('attachment')->nullable()->comment('附件 JsonString:array');
            $table->tinyInteger('status')->default(0)->comment('-1:失敗 0:未發送 1:成功');
            $table->longText('extra')->nullable()->comment('其他');
            $table->dateTime('sent_time')->nullable()->default(null)->comment('發送時間');

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
