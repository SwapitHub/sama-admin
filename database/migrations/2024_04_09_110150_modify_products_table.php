<?php
	
	use Illuminate\Database\Migrations\Migration;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Support\Facades\Schema;
	
	class ModifyProductsTable extends Migration
	{
		/**
			* Run the migrations.
			*
			* @return void
		*/
		public function up()
		{
			Schema::table('products', function ($table) {
				$table->unique('sku');
			});
		}
		
		/**
			* Reverse the migrations.
			*
			* @return void
		*/
		public function down()
		{
			Schema::table('products', function ($table) {
				$table->dropUnique('sku');
			});
		}
	}
