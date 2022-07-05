<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee', function (Blueprint $table) {
            $table->primary(['emplo_id']);
            $table->string('emplo_id','10')
            ->comment('社員ID');
            $table->string('name','32')
            ->comment('社員名');
            $table->string('password','256')
            ->comment('パスワード');
            $table->string('management_emplo_id','10')
            ->comment('上司社員ID');
            $table->char('subord_authority','1')
            ->comment('部下参照権限');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee');
    }
}
