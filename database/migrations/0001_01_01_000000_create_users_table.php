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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('kana');
            $table->string('tel');
            $table->string('email');
            $table->datetime('email_verified_at')->nullable();
            $table->string('postcode');
            $table->string('address');
            $table->date('birthday');
            $table->tinyInteger('gender'); // 0男性, 1女性、2その他
            $table->string('password');
            $table->rememberToken();
            // $table->timestamps();
            $table->datetime('created_at')->nullable();
            $table->datetime('updated_at')->nullable();
            $table->text('memo')->nullable();
            $table->integer('status')->default('1');
            // $table->softDeletes();
            // softDeleteは、timestamp型を作成するため、datetimeを使用する場合は以下
            $table->datetime('deleted_at')->nullable();
            $table->date('deadline')->nullable();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->datetime('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
