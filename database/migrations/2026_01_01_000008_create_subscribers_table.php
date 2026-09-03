<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscribersTable extends Migration
{
    public function up()
    {
        Schema::create('subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('ip_address')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamp('subscribed_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('subscribers');
    }
}
