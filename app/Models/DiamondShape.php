<?php
	
	namespace App\Models;
	
	use Illuminate\Database\Eloquent\Factories\HasFactory;
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Support\Str;
	
	class DiamondShape extends Model
	{
		use HasFactory;
		protected $table='diamond_shape';
		
		public static function generateUniqueSlug($title)
		{
			$slug = Str::slug($title);
			$originalSlug = $slug;
			$count = 2;
			while (static::where('slug', $slug)->exists()) {
				$slug = $originalSlug . '-' . $count;
				$count++;
			}
			return $slug;
		}
	}
