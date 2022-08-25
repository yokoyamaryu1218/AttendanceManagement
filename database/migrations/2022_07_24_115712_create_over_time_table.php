<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateOverTimeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('over_time', function (Blueprint $table) {
            $table->bigIncrements('id', '10')
                ->comment('ID');
            $table->string('emplo_id', '10')
                ->comment('社員番号');
            $table->Time('restraint_start_time')
                ->comment('始業時間');
            $table->Time('restraint_closing_time')
                ->comment('終業時間');
            $table->Time('restraint_total_time')
                ->comment('就業時間');
            $table->char('short_working', '1')
                ->comment('時短フラグ');
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
        Schema::dropIfExists('over_time');
    }
}
