<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiamondTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diamond', function (Blueprint $table) {
            $table->id();
			$table->integer('price');
			$table->integer('shape');
			$table->integer('carat');
			$table->integer('cut');
			$table->integer('color');
			$table->integer('clarity');
			$table->text('Symmetry');
			$table->text('table');
			$table->text('Fluor');
			$table->text('Origin');
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
        Schema::dropIfExists('diamond');
    }
}
