<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCmsContentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cms_content', function (Blueprint $table) {
            $table->id();
            $table->integer('cms_category');
			$table->string('name');
			$table->string('slug');
			$table->text('keyword')->nullable();
			$table->text('description')->nullable();
			$table->longText('content');
			$table->string('image');
			$table->string('status');
			$table->integer('order_number');
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
        Schema::dropIfExists('cms_content');
    }
}
