<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->nullable();
            $table->ipAddress('ip')->nullable();
            $table->string('content');
            $table->unsignedBigInteger('parent_id');
            $table->unsignedBigInteger('post_id');
            $table->boolean('verified');
            $table->timestamps();

            $table->foreign('parent_id')
                ->references('id')
                ->on('comments')
                ->onDelete('cascade');

            $table->foreign('post_id')
                ->references('id')
                ->on('posts')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}