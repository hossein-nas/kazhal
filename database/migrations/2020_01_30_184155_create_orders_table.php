<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('subject');
            $table->string('email')->nullable();
            $table->string('name');
            $table->string('budjet')->nullable()->default('0');
            $table->text('description');
            $table->ipAddress('ip')->nullable();
            $table->boolean('seen')->default(0);
            $table->string('status')->default('UNMANAGED');
            $table->json('contact_info')->nullable();
            $table->unsignedBigInteger('related_service_id');
            $table->timestamps();

            $table->foreign('related_service_id')
                ->references('id')
                ->on('services')
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
        Schema::dropIfExists('orders');
    }
}
