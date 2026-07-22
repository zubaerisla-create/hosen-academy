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
        if (!Schema::hasTable('like_dislike_reviews')) {
            Schema::create('like_dislike_reviews', function (Blueprint $table) {
            $table->integer('id')->nullable();
            $table->integer('review_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('liked')->nullable();
            $table->integer('disliked')->nullable();
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
        Schema::dropIfExists('like_dislike_reviews');
    }
};
