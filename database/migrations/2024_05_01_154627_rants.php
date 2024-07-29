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
        Schema::create('rants', function (Blueprint $table) {
            $table->id(); // This line already defines the id column as the primary key
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->uuid('uuid')->index(); // Add this line if you want a UUID column
            $table->integer('positive');
            $table->integer('negative');
            $table->string('rant');
            $table->string('tags')->nullable();
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
        Schema::dropIfExists('rants');
    }
};
