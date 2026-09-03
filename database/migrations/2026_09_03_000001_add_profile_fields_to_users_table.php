<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'designation')) {
                $table->string('designation')->nullable()->after('phone');
            }
            if (!Schema::hasColumn('users', 'avatar')) {
                $table->string('avatar')->nullable()->after('designation');
            }
            if (!Schema::hasColumn('users', 'bio')) {
                $table->text('bio')->nullable()->after('avatar');
            }
            if (!Schema::hasColumn('users', 'whatsapp')) {
                $table->string('whatsapp')->nullable()->after('bio');
            }
            if (!Schema::hasColumn('users', 'linkedin')) {
                $table->string('linkedin')->nullable()->after('whatsapp');
            }
            if (!Schema::hasColumn('users', 'twitter')) {
                $table->string('twitter')->nullable()->after('linkedin');
            }
            if (!Schema::hasColumn('users', 'telegram')) {
                $table->string('telegram')->nullable()->after('twitter');
            }
            if (!Schema::hasColumn('users', 'facebook')) {
                $table->string('facebook')->nullable()->after('telegram');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'designation', 'avatar', 'bio', 'whatsapp', 'linkedin', 'twitter', 'telegram', 'facebook']);
        });
    }
};
