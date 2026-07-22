<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('payment_gateways')) {
            Schema::create('payment_gateways', function (Blueprint $table) {
            $table->bigInteger('id')->nullable();
            $table->string('identifier', 255)->nullable();
            $table->string('currency', 255)->nullable();
            $table->string('title', 255)->nullable();
            $table->string('model_name', 255)->nullable();
            $table->text('description')->nullable();
            $table->text('keys')->nullable();
            $table->integer('status')->nullable();
            $table->integer('test_mode')->nullable();
            $table->integer('is_addon')->nullable();
            $table->timestamp('created_at')->nullable(false);
            $table->timestamp('updated_at')->nullable(false);
            
                    });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_gateways');
    }
};
