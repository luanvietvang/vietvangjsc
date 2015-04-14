<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Language;

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
	public static function validate($input) {

        $rules = array(
		        'title' => array( 'required', 'max:255' ),
		        'position' => array( 'required', 'numeric'),
		        'title_en' => array( 'required_with:desc_en,fulltext_en', 'max:255' ),
		        'title_ja' => array( 'required_with:desc_ja,fulltext_ja', 'max:255' ),
        );

        return Validator::make($input, $rules);
	}
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

	/**
	 * Read all record
	 *
	 * @return array
	 */
	public static function getAll(){
		$result = Menu::orderBy('menus.id', 'desc')
				->paginate(3);
		return $result;
	}

	public static function _getAll(){
		$result = Menu::orderBy('menus.id', 'desc')
				->get();
		return $result;
	}

	/**
	 * Del a record 
	 *
	 * @return true, false
	 */
	public function Del($id){
		$result = false;
		try {
			#Del database
			Menu::where('id', $id)->delete();
			#Del Language
			Language::Del($id, $this->table);
			//commit
			$result = true;
			DB::commit();
		} catch (Exception $e) {
			$result = false;
			DB::rollback();
		}

		return $result;
	}

	/**
	 * Insert new record 
	 *
	 * @return true, false
	 */
	public function Insert($dataVi, $dataLang){
		$result = false;
		try {
			//get list column
			$this->fields = DB::connection()->getSchemaBuilder()->getColumnListing($this->table);
			//get list column of Languages table
			$this->fields_Lang = DB::connection()->getSchemaBuilder()->getColumnListing($this->table_Lang);

			DB::beginTransaction();

			//Insert to data
			$arr = array();
			foreach ($this->fields as $v) {
				if(isset($dataVi[$v])){
					$arr[$v] = $dataVi[$v];
				}
			}
			$id = Menu::insertGetId($arr);

			//Insert to Languages
			if($dataLang != null){
				$arrLang = array();
				foreach ($dataLang as $Lang) {
					foreach ($this->fields_Lang as $v) {
						if(isset($Lang[$v])){
							if($v == 'item_id')
								$arrLang[$v] = $id;
							else $arrLang[$v] = $Lang[$v];
						}
					}
					DB::table($this->table_Lang)->insert($arrLang);
				}
			}

			//commit
			$result = true;
			DB::commit();
		} catch (Exception $e) {
			$result = false;
			DB::rollback();
		}

		return $result;
	}

	/**
	 * Update record 
	 *
	 * @return true, false
	 */
	public function _Update($dataVi, $dataLang, $id){
		$result = false;
		try {
			//get list column
			$this->fields = DB::connection()->getSchemaBuilder()->getColumnListing($this->table);
			//get list column of Languages table
			$this->fields_Lang = DB::connection()->getSchemaBuilder()->getColumnListing($this->table_Lang);

			DB::beginTransaction();
			//Update to data
			$arr = array();
			foreach ($this->fields as $v) {
				if(isset($dataVi[$v])){
					$arr[$v] = $dataVi[$v];
				}
			}
			Menu::where('id','=',$id)->update($arr);

			//Update to Languages
			$lang=null;
			if($dataLang != null){
				$arrLang = array();
				foreach ($dataLang as $Lang) {
					foreach ($this->fields_Lang as $v) {
						if(isset($Lang[$v])){
							if($v == 'lang')
								$lang = $Lang[$v];
							else $arrLang[$v] = $Lang[$v];
						}
					}
					DB::table($this->table_Lang)->where(array('item_id' => $id, 'lang' => $lang))
					->update($arrLang);
				}
			}

			//commit
			$result = true;
			DB::commit();
		} catch (Exception $e) {
			$result = false;
			DB::rollback();
		}

		return $result;
	}
}
