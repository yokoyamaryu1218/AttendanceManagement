<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestTime extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rest_time', function (Blueprint $table) {
            $table->string('total_time1');
            $table->string('total_time2');
            $table->Time('rest_time1');
            $table->Time('rest_time2');
            $table->Time('rest_time3');
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
        Schema::dropIfExists('rest_time');
    }
}
