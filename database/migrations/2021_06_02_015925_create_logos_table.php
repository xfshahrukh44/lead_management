<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logos', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->string('name')->nullable();
            $table->string('location')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('number')->unique()->nullable();
            $table->string('assigned_to')->nullable();
            $table->string('lead_from')->nullable();
            $table->string('website')->nullable();
            $table->string('platform')->nullable();
            $table->string('keyword')->nullable();
            $table->string('profile_link')->nullable();
            $table->longText('query')->nullable();
            $table->string('status')->nullable()->default('Inactive');
            $table->integer('created_by')->nullable();
            $table->integer('modified_by')->nullable();
            $table->timestamps();
            $table->softDeletes()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logos');
    }
}
