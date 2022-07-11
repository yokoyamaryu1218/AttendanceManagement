<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('works', function (Blueprint $table) {
            $table->primary(['id']);
            $table->string('id', '10')
                ->comment('ID');
            $table->string('emplo_id', '10')
                ->comment('社員ID');
            $table->date('date')
                ->comment('日付');
            $table->dateTime('start_time')->nullable()
                ->comment('出勤時間');
            $table->dateTime('end_time')->nullable()
                ->comment('退勤時間');
            $table->string('lest_time')->nullable()
                ->comment('休憩時間');
            $table->string('achievement_time')->nullable()
                ->comment('実績時間');
            $table->timestamp('created_at')->useCurrent()
                ->comment('新規登録日');
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'))
                ->comment('更新日');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('works');
    }
}
