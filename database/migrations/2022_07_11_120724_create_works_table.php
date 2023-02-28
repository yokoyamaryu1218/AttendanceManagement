<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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
            $table->bigIncrements('id', '10')
                ->comment('ID');
            $table->string('emplo_id', '10')
                ->comment('社員番号');
            $table->date('date')
                ->comment('日付');
            $table->Time('start_time')->nullable()
                ->comment('出勤時間');
            $table->Time('closing_time')->nullable()
                ->comment('退勤時間');
            $table->Time('rest_time')->nullable()
                ->comment('休憩時間');
            $table->Time('achievement_time')->nullable()
                ->comment('実績時間');
            $table->Time('over_time')->nullable()
                ->comment('残業時間');
            $table->timestamp('created_at')->useCurrent()
                ->comment('新規登録日');
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'))
                ->comment('更新日');
            $table->string('modifier', '32')->nullable()
                ->comment('変更者');
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
