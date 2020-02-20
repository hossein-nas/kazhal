<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('slug')->index()->unique();
            $table->text('excerpt');
            $table->string('price')->nullable();
            $table->text('content');
            $table->enum('service_type', ['category', 'main']);
            $table->unsignedBigInteger('thumbnail_id');
            $table->unsignedBigInteger('color_id');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->text('features')->nullable();
            $table->boolean('featured')->default(0);
            $table->text('hardware')->nullable();
            $table->json('extra')->nullable();
            $table->timestamps();

            $table->foreign('parent_id')
                ->references('id')
                ->on('services')
                ->onDelete('cascade');

            $table->foreign('thumbnail_id')
                ->references('id')
                ->on('files');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
    }
}
