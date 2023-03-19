<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //for just click on bottom delete and deleted post with comments
        Schema::table('comments', function (Blueprint $table) {
            $table->dropForeign(["post_id"]);
            $table->foreign('post_id')
                  ->references('id')
                  ->on('posts')
                  ->onDelete('cascade'); // for delete
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropForeign(["post_id"]);
            $table->foreign('post_id')
                  ->references('id')
                  ->on('posts');
        });
    }
};
