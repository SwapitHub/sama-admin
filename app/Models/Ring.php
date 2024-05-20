<?php
	
	namespace App\Models;
	
	use Illuminate\Database\Eloquent\Factories\HasFactory;
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Support\Str;
	
	class Ring extends Model
	{
		use HasFactory;
		protected $table='ring_style';
		
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
