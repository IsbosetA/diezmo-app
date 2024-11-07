<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('envelopes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('id_member');
            $table->string('envelope_number');
            $table->date('date');
            $table->string('description')->nullable();
            $table->decimal('total', 10,2)->nullable();
            $table->timestamps();

            //Foreings
            $table->foreign('id_member')->references('id')->on('members')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('envelopes');
    }
};
