<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('mail_otps', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('hash');
            $table->string('otp');
            $table->timestamp('expires_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('mail_otps');
    }
};
