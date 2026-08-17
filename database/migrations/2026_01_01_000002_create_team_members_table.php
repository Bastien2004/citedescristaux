<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('team_members', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('team_id');
            $table->string('discord_tag');
            $table->string('role'); // TITULAIRE | REMPLACANT
            $table->integer('position');
            $table->boolean('is_captain')->default(false);

            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
            $table->index('team_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('team_members');
    }
};
