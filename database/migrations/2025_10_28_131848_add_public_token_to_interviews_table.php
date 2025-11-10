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
        Schema::table('interviews', function (Blueprint $table) {
            $table->string('public_token', 64)->unique()->nullable()->after('id');
            $table->timestamp('questionnaire_submitted_at')->nullable()->after('updated_at');
            $table->boolean('is_questionnaire_complete')->default(false)->after('questionnaire_submitted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('interviews', function (Blueprint $table) {
            $table->dropColumn(['public_token', 'questionnaire_submitted_at', 'is_questionnaire_complete']);
        });
    }
};
