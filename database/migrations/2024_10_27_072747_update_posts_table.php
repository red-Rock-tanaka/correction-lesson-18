<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('posts', function (Blueprint $table) {
        // 外部キー制約を削除
        $table->dropForeign(['user_id']); // ここを追加
        $table->dropColumn('user_id'); // カラムの削除
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('user_name');
            $table->renameColumn('contents', 'post');
            $table->unsignedBigInteger('user_id')->nullable()->after('id');
        });
    }
}
