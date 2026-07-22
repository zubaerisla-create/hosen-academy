<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add google_id column to users table if not exists
        if (!Schema::hasColumn('users', 'google_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('google_id')->nullable()->after('email');
            });
        }

        // Seed default Google OAuth settings into settings table
        $defaults = [
            'google_login_status'  => '0',
            'google_client_id'     => '',
            'google_client_secret' => '',
            'google_redirect_uri'  => '',
        ];

        foreach ($defaults as $type => $description) {
            if (!DB::table('settings')->where('type', $type)->exists()) {
                DB::table('settings')->insert([
                    'type'        => $type,
                    'description' => $description,
                ]);
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('users', 'google_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('google_id');
            });
        }

        DB::table('settings')->whereIn('type', [
            'google_login_status',
            'google_client_id',
            'google_client_secret',
            'google_redirect_uri',
        ])->delete();
    }
};
