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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stage_id');
            $table->unsignedBigInteger('speaker_id')->nullable();
            $table->string('name');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('link')->nullable();
            $table->text('description');
            $table->string('image_path')->nullable();
            $table->boolean('is_selectable')->default(true);
            $table->timestamps();

            $table->foreign('stage_id')->references('id')->on('stages')->onDelete('cascade');
            $table->foreign('speaker_id')->references('id')->on('speakers')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign(['stage_id']);
            $table->dropForeign(['speaker_id']);
        });

        Schema::dropIfExists('events');
    }
};


