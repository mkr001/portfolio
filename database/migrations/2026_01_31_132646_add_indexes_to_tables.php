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
        Schema::table('contacts', function (Blueprint $table) {
            $table->index('is_read');
        });
        Schema::table('callbacks', function (Blueprint $table) {
            $table->index('is_read');
        });
        Schema::table('chat_messages', function (Blueprint $table) {
            $table->index(['is_from_admin', 'is_read']);
        });
        Schema::table('feedbacks', function (Blueprint $table) {
            $table->index('status');
        });
        Schema::table('job_applications', function (Blueprint $table) {
            $table->index('status');
        });
        Schema::table('business_inquiries', function (Blueprint $table) {
            $table->index('status');
        });
        Schema::table('freelance_inquiries', function (Blueprint $table) {
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) { $table->dropIndex(['is_read']); });
        Schema::table('callbacks', function (Blueprint $table) { $table->dropIndex(['is_read']); });
        Schema::table('chat_messages', function (Blueprint $table) { $table->dropIndex(['is_from_admin', 'is_read']); });
        Schema::table('feedbacks', function (Blueprint $table) { $table->dropIndex(['status']); });
        Schema::table('job_applications', function (Blueprint $table) { $table->dropIndex(['status']); });
        Schema::table('business_inquiries', function (Blueprint $table) { $table->dropIndex(['status']); });
        Schema::table('freelance_inquiries', function (Blueprint $table) { $table->dropIndex(['status']); });
    }
};
