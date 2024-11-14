<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['remember_token', 'email_verified_at']); // カラムの削除
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('remember_token', 100)->nullable();           // カラムを再追加
        $table->timestamp('email_verified_at')->nullable();          // カラムを再追加
    });
}

}
