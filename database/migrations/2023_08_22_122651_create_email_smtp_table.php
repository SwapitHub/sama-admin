<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailSmtpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_smtp', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // A name for this SMTP configuration (e.g., "Main Server")
            $table->string('host'); // SMTP host (e.g., smtp.example.com)
            $table->integer('port'); // SMTP port (e.g., 587)
            $table->string('encryption')->nullable(); // Encryption type (e.g., tls, ssl); nullable if not required
            $table->string('username'); // SMTP username
            $table->string('password'); // SMTP password
            $table->boolean('is_default')->default(false); // Indicates if this is the default SMTP configuration
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('email_smtp');
    }
}
