<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('status')->default('PENDING'); // PENDING | VALIDATED | REJECTED
            $table->integer('points')->default(0);
            $table->string('captain_id')->unique();
            $table->string('captain_tag');
            $table->string('captain_avatar')->nullable();
            $table->text('note')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->index('status');
            $table->index('points');
        });

        // Unicité du nom d'équipe, insensible à la casse (comme l'original).
        DB::statement('CREATE UNIQUE INDEX teams_name_lower_idx ON teams (lower(name))');
    }

    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
