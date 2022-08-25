<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->primary(['emplo_id']);
            $table->string('emplo_id', '10')
                ->comment('管理者番号');
            $table->string('name', '32')
                ->comment('社員名');
            $table->string('password', '256')
                ->comment('パスワード');
            $table->char('admin_authority', '1')
                ->comment('管理権限');
            $table->timestamp('created_at')->useCurrent()
                ->comment('新規登録日');
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'))
                ->comment('更新日');
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
        Schema::dropIfExists('admins');
    }
}
