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
        Schema::create('offerings', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('id_envelope');
            $table->unsignedBigInteger('id_offering_type')->nullable();
            $table->decimal('amount', 10,2);
            $table->timestamps();

            //Foreings
            $table->foreign('id_envelope')->references('id')->on('envelopes')->onDelete('cascade');
            $table->foreign('id_offering_type')->references('id')->on('offering_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offerings');
    }
};
