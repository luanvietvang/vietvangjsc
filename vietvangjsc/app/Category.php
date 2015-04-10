<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Input;
use Validator;
use App\Language;
use File;

class Category extends MyModel{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'categories';
	protected $fields = array();

	protected $table_Lang = 'languages';
	protected $fields_Lang = array();

	protected $_url;

	public $timestamps = false;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['id', 'alias', 'name', 'logo', 'desc'];

	public function __construct(){
		parent::__construct('categories');
		$this->_url = base_path('public/upload/categories');
	}

	public function article()
    {
        return $this->hasOne('App\Article', 'category_id');
    }

	public function product()
    {
        return $this->hasOne('App\Product', 'category_id');
    }

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

	//Huynh Dung Add
	/**
	 * Read a record
	 *
	 * @return array
	 */
	public static function getLstCategoriesVi(){
		$result = Category::select('id as id', 'name as name')
					->get();
		return $result;
	}

	public static function validate($input) {

        $rules = array(
		        'title' => array( 'required', 'max:255' ),
		        'desc' => array( 'required'),
		        'image_en' => array( 'image' ),
		        'title_en' => array( 'required_with:desc_en,fulltext_en', 'max:255' ),
		        'desc_en' => array( 'required_with:title_en,fulltext_en' ),
		        'image_ja' => array( 'image' ),
		        'title_ja' => array( 'required_with:desc_ja,fulltext_ja', 'max:255' ),
		        'desc_ja' => array( 'required_with:title_ja,fulltext_ja' )
        );

        return Validator::make($input, $rules);
	}

	/**
	 * Read a record
	 *
	 * @return array
	 */
	public static function read($id){
		$res = Category::where('id', '=', $id)
						->first();
		return $res;
	}

	/**
	 * Read all record
	 *
	 * @return array
	 */
	public static function getAll(){
		$result = Category::orderBy('categories.id', 'desc')
				->paginate(3);
		return $result;
	}

	/**
	 * Del a record 
	 *
	 * @return true, false
	 */
	public static function Del($id){
		$result = Category::where('id', $id)->delete();
		if($result) return true;
		else return false;
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
			//Upload img
			$filename = $this->uploadImg(Input::file('image'), $this->_url, 100, 80);
			$filename_en = null;
			$filename_ja = null;
			if(!Input::get('ckimg')){
				if($_FILES['image_en']['name'] != '')
					$filename_en = $this->uploadImg(Input::file('image_en'), $this->_url, 100, 80);
				if($_FILES['image_ja']['name'] != '')
					$filename_ja = $this->uploadImg(Input::file('image_ja'), $this->_url, 100, 80);
			}

			//Insert to data
			$arr = array();
			foreach ($this->fields as $v) {
				if(isset($dataVi[$v])){
					if($v == 'logo')
						$arr[$v] = $filename;
					else $arr[$v] = $dataVi[$v];
				}
			}
			$id = Category::insertGetId($arr);

			//Insert to Languages
			$lang=null;
			if($dataLang != null){
				$arrLang = array();
				foreach ($dataLang as $Lang) {
					foreach ($this->fields_Lang as $v) {
						if(isset($Lang[$v])){
							if($v == 'item_id')
								$arrLang[$v] = $id;
							elseif($v == 'img')
								if($lang == 'en')
									$arrLang[$v] = $filename_en;
								else
									$arrLang[$v] = $filename_ja;
							else{ 
								if($v == 'lang'){
									$lang = $Lang[$v];
								}
								$arrLang[$v] = $Lang[$v];
							}
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
			//image categories
			$filename = $this->read($id)->logo;
			if($_FILES['image']['name'] != ''){
				//del old image
				if (File::exists($this->_url.'/'.$filename))
					unlink($this->_url.'/'.$filename);
				//Upload img
				$filename = $this->uploadImg(Input::file('image'), $this->_url, 100, 80);

			}
			//image en
			$filename_en = Language::read($id,'categories','en')->img;
			if(isset($_FILES['image_en']))
			{
				if($_FILES['image_en']['name'] != ''){
					//del old image
					if (File::exists($this->_url.'/'.$filename_en))
						unlink($this->_url.'/'.$filename_en);
					//Upload img
					$filename_en = $this->uploadImg(Input::file('image_en'), $this->_url, 100, 80);
				}
			}
			//image ja
			$filename_ja = Language::read($id,'categories','ja')->img;
			if(isset($_FILES['image_ja']))
			{
				if($_FILES['image_ja']['name'] != ''){
					//del old image
					if (File::exists($this->_url.'/'.$filename_ja))
						unlink($this->_url.'/'.$filename_ja);
					//Upload img
					$filename_ja = $this->uploadImg(Input::file('image_ja'), $this->_url, 100, 80);
				}
			}
			//Update to data
			$arr = array();
			foreach ($this->fields as $v) {
				if(isset($dataVi[$v])){
					if($v == 'logo')
						$arr[$v] = $filename;
					else $arr[$v] = $dataVi[$v];
				}
			}
			Category::where('id','=',$id)->update($arr);

			//Update to Languages
			$lang=null;
			if($dataLang != null){
				$arrLang = array();
				foreach ($dataLang as $Lang) {
					foreach ($this->fields_Lang as $v) {
						if(isset($Lang[$v])){
							if($v == 'img')
								if($lang == 'en')
									$arrLang[$v] = $filename_en;
								else
									$arrLang[$v] = $filename_ja;
							else{ 
								if($v == 'lang'){
									$lang = $Lang[$v];
								}
								$arrLang[$v] = $Lang[$v];
							}
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
