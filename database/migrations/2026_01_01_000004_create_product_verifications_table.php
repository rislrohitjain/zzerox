<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductVerificationsTable extends Migration
{
    public function up()
    {
        Schema::create('product_verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('set null');
            $table->string('batch_number')->index();
            $table->string('security_code')->unique();
            $table->boolean('is_verified')->default(false);
            $table->timestamp('verified_at')->nullable();
            $table->string('ip_address')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index('security_code');
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_verifications');
    }
}
