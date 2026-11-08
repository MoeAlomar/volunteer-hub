<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('opportunities', function (Blueprint $table) {
            $table->id();
            $table->string('title', 150);
            $table->string('category', 20)->index();
            $table->string('city', 80);
            $table->date('event_date')->index();
            $table->unsignedSmallInteger('capacity');
            $table->text('description');
            $table->timestamps();
        });

        DB::statement('ALTER TABLE opportunities ADD CONSTRAINT opportunities_capacity_check CHECK (capacity BETWEEN 1 AND 1000)');
    }

    public function down(): void
    {
        Schema::dropIfExists('opportunities');
    }
};
