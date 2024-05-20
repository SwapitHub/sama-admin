<?php
	
	namespace App\Models;
	
	use Illuminate\Database\Eloquent\Factories\HasFactory;
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Support\Str;
	
	class MetalColor extends Model
	{
		use HasFactory;
		protected $guarded = [];
		protected $table='metal_color';
	}
