<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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
            $table->string('emplo_id', '10')
                ->comment('社員ID');
            $table->string('name', '32')
                ->comment('社員名');
            $table->string('password', '256')
                ->comment('パスワード');
            $table->string('management_emplo_id', '10')
                ->comment('上司社員ID');
            $table->char('subord_authority', '1')
                ->comment('部下参照権限');
            $table->char('retirement_authority', '1')
                ->comment('退職フラグ');
            $table->timestamp('created_at')->useCurrent()
                ->comment('新規登録日');
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'))
                ->comment('更新日');
            $table->date('hire_date')
                ->comment('入社日');
            $table->date('retirement_date')->nullable()
                ->comment('退職日');
            $table->string('remember_token')->nullable()
                ->comment('ログイン情報の保持');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
