<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductModel extends Model
{
	use HasFactory;
	protected $table = 'products';
	protected $guarded = [];


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


	public static function sortVideos($videos)
	{
		$videos = explode(',',$videos);
		if ($videos != NULL || !empty($videos)) {
			//sort videos 
			$colors = ['rose', 'white', 'yellow'];
			$colorVideoMapping = [];
			foreach ($videos as $video) {
				// Extract color name from the video URL
				preg_match('/\.video\.(\w+)\.mp4/', $video, $matches);

				if (isset($matches[1])) {
					$colorName = $matches[1];

					// Check if the color is in the defined colors array
					if (in_array($colorName, $colors)) {
						// Assign the video URL to the corresponding color key
						$colorVideoMapping[$colorName] = $video;
					}
				}
			}
			// Convert the array to an object
			return json_encode($colorVideoMapping, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
		} else {
			return null;
		}
	}
}
