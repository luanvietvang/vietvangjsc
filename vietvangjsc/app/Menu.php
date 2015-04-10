<?php namespace App;

use Illuminate\Database\Eloquent\Model;
class Menu extends MyModel{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'menus';
	protected $fields = array();

	protected $table_Lang = 'languages';
	protected $fields_Lang = array();

	public $timestamps = false;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['id', 'alias', 'name', 'parent_id'];

	public function __construct(){
		parent::__construct('menus');
	}

	public function article()
    {
        return $this->hasOne('App\Article', 'menu_id');
    }

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

	public static function getMenuVi(){
		$result = Menu::orderBy('position')
			->select('id as id', 'name as name', 'parent_id')
			->get();
		return $result;
	}

	public static function checkHasNode($id){
		$result = Menu::where('parent_id', '=', $id)
			->take(0)->skip(1)
			->get();
		if(is_null($result)) return false;
		return true;
	}

	//Huynh Dung Add
	/**
	 * Read a record
	 *
	 * @return array
	 */
	public static function read($id){
		$res = Menu::where('id', '=', $id)
						->first();
		return $res;
	}

}
