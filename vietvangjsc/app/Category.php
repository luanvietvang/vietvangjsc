<?php namespace App;

use Illuminate\Database\Eloquent\Model;
class Category extends Model{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'categories';

	public $timestamps = false;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['id', 'alias', 'name', 'logo', 'desc'];

	public static function getCategories($lang){
		if ($lang == "vi") {
			$result = Category::select('id as id', 'alias as alias', 'name as name', 'logo as logo', 'desc as desc')
						->get();
		}
		else{ 
			$result = Category::leftJoin('languages', function($join) {
					      $join->on('categories.id', '=', 'languages.item_id');
					    })
					->where('languages.table_name', '=', 'categories')
					->where('languages.lang', '=', $lang)
					->select('categories.id as id', 'categories.alias as alias', 'languages.name as name', 'categories.logo as logo', 'languages.desc as desc')
					->get();
		}
		return $result;
	}
}
