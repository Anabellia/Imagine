<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_properties', function (Blueprint $table) {
            $table->id();            
            $table->json('image_name')->nullable(); //array
            $table->json('image_editing_name')->nullable(); //array
            $table->unsignedBigInteger('user_id');
            $table->json('path')->nullable(); //array
            $table->json('extension')->nullable(); //array
            $table->json('edit_step_number')->nullable(); //array
            $table->json('action_made')->nullable(); //array
            $table->json('action_made_timestamp')->nullable(); //array
            $table->string('unique_edit_id')->nullable();            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('image_properties');
    }
}
