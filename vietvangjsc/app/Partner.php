<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Validator;

class Partner extends MyModel{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'partners';

	public $timestamps = false;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['id', 'name', 'logo', 'url'];

	public function __construct(){
		parent::__construct('menus');
	}

	public static function getPartners($lang){
		if ($lang == "vi") {
			$result = Partner::select('id as id', 'name as name', 'logo as logo', 'url as url')
						->orderBy('id','desc')
						->take(3)
						->get();
		}
		else{ 
			$result = Partner::leftJoin('languages', function($join) {
					      $join->on('partners.id', '=', 'languages.item_id');
					    })
					->where('languages.table_name', '=', 'partners')
					->select('partners.id as id', 'languages.name as name', 'partners.logo as logo', 'partners.url as url')
					->orderBy('partners.id','desc')
					->take(3)
					->get();
		}
		return $result;
	}

	//Back end
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
		$res = Partner::where('id', '=', $id)
						->first();
		return $res;
	}

	/**
	 * Read all record
	 *
	 * @return array
	 */
	public static function getAll(){
		$result = Partner::orderBy('partners.id', 'desc')
				->paginate(3);
		return $result;
	}

	/**
	 * Del a record 
	 *
	 * @return true, false
	 */
	public function Del($id){
		$result = Partner::where('id', $id)->delete();
		return $result;
	}

	/**
	 * Insert new record 
	 *
	 * @return true, false
	 */
	public function Insert($dataVi){
		//get list column
		$this->fields = DB::connection()->getSchemaBuilder()->getColumnListing($this->table);

		//Insert to data
		$arr = array();
		foreach ($this->fields as $v) {
			if(isset($dataVi[$v])){
				$arr[$v] = $dataVi[$v];
			}
		}
		$result = Partner::insert($arr);
		return $result;
	}

	/**
	 * Update record 
	 *
	 * @return true, false
	 */
	public function _Update($dataVi, $id){
		//get list column
		$this->fields = DB::connection()->getSchemaBuilder()->getColumnListing($this->table);
		$arr = array();
		foreach ($this->fields as $v) {
			if(isset($dataVi[$v])){
				$arr[$v] = $dataVi[$v];
			}
		}
		$result = Partner::where('id','=',$id)->update($arr);

		return $result;
	}
}
