<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            // Deleting an opportunity deletes its registrations (the dashboard warns about this).
            $table->foreignId('opportunity_id')->constrained()->cascadeOnDelete();
            $table->string('name', 120);
            $table->string('email', 150);
            $table->string('phone', 10);
            $table->unsignedSmallInteger('age');
            $table->text('notes')->nullable();
            $table->timestamps();

            // One registration per email per opportunity.
            $table->unique(['opportunity_id', 'email']);
        });

        DB::statement('ALTER TABLE registrations ADD CONSTRAINT registrations_age_check CHECK (age BETWEEN 16 AND 70)');
    }

    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
