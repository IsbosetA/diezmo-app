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
        Schema::create('transfers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_envelope');
            $table->string('reference');
            $table->decimal('amount', 10, 2);
            $table->date('date');
            $table->string('bank');
            $table->string('capture');
            $table->timestamps();

            //Foreings
            $table->foreign('id_envelope')->references('id')->on('envelopes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
};
