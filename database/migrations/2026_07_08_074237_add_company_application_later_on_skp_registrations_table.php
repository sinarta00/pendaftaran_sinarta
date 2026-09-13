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
        Schema::table('skp_registrations', function (Blueprint $table) {
            $table->string('company_application_later')->nullable()->after('company_address');
            $table->string('skp__later')->nullable()->after('company_application_later');
            $table->string('license_later')->nullable()->after('skp__later');
            $table->string('activity_report_later')->nullable()->after('license_later');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('skp_registrations', function (Blueprint $table) {
            $table->dropColumn('company_application_later');
            $table->dropColumn('skp__later');
            $table->dropColumn('license_later');
            $table->dropColumn('activity_report_later');
        });
    }
};
