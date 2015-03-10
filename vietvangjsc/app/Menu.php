<?php namespace App;

use Illuminate\Database\Eloquent\Model;
class Menu extends Model{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'menus';

	public $timestamps = false;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['id', 'alias', 'name', 'parent_id'];

	public static function getMenu($lang, $parent_id){
		if ($lang == "vi") {
			$result = Menu::where('parent_id', '=', $parent_id)
				->orderBy('position')
				->select('id as id', 'alias as alias', 'name as name')
				->get();
		}
		else{ 
			$result = Menu::leftJoin('languages', function($join) {
					      $join->on('menus.id', '=', 'languages.item_id');
					    })
					->where('menus.parent_id', '=', $parent_id)
					->where('languages.table_name', '=', 'menus')
					->where('languages.lang', '=', $lang)
					->orderBy('menus.position')
					->select('menus.id as id', 'menus.alias as alias', 'languages.name as name')
					->get();
		}
		return $result;
	}
}