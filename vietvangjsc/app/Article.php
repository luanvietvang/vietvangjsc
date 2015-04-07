<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Input;
use Validator;
use App\Language;
use File;

class Article extends MyModel{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'articles';
	protected $fields = array();

	protected $table_Lang = 'languages';
	protected $fields_Lang = array();

	protected $table_SEO = 'seos';
	protected $fields_SEO = array();

	protected $_url;//URL::to('public/upload/articles');


	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['id', 'alias', 'title', 'img', 'dec', 'menu_id', 'category_id', 'created_at', 'updated_at', 'deleted_at', 'hit'];

	public function __construct(){
		parent::__construct('articles');
		$this->_url = base_path('public/upload/articles');
	}
	//Huynh Dung added on 2015/03/12
	// public function initialize($table = null){
	// 	if(!is_null($table)){
	// 		//get list column
	// 		$this->fields = DB::connection()->getSchemaBuilder()->getColumnListing($this->table);
	// 		//get list column of Languages table
	// 		$this->fields_Lang = DB::connection()->getSchemaBuilder()->getColumnListing($this->table_Lang);
	// 		//get list column of Seos table
	// 		$this->fields_SEO = DB::connection()->getSchemaBuilder()->getColumnListing($this->table_SEO);
	// 	}
	// }
	//End

	public static function getHitNews($lang){
		if ($lang == "vi") {
			$result = Article::where('hit', '=', 1)
						->select('id as id', 'alias as alias', 'img as img')
						->get();
		}
		else{ 
			$result = Article::leftJoin('languages', function($join) {
					      $join->on('articles.id', '=', 'languages.item_id');
					    })
					->where('languages.table_name', '=', 'articles')
					->where('languages.lang', '=', $lang)
					->where('articles.hit', '=', 1)
					->select('articles.id as id', 'languages.alias as alias', 'languages.img as img')
					->get();
		}
		return $result;
	}

	public static function getNews($lang, $menu_id, $limit){
		if ($lang == "vi") {
			$result = Article::where('hit', '=', 0)
						->where('menu_id', '=', $menu_id)
						->select('id as id', 'alias as alias', 'title as title', 'img as img', 'desc as desc', 'fulltext as fulltext', 'menu_id as menu_id', 'category_id as category_id', 'created_at as created_at')
						->get();
		}
		else{ 
			$result = Article::leftJoin('languages', function($join) {
					      $join->on('articles.id', '=', 'languages.item_id');
					    })
					->where('languages.table_name', '=', 'articles')
					->where('languages.lang', '=', $lang)
					->where('articles.menu_id', '=', $menu_id)
					->where('articles.hit', '=', 0)
					->select('articles.id as id', 'languages.alias as alias', 'languages.name as title', 'languages.img as img', 'languages.desc as desc', 'languages.fulltext as fulltext', 'articles.menu_id as menu_id', 'articles.category_id as category_id', 'articles.created_at as created_at')
					->get();
		}
		return $result;
	}

	public static function getNew($lang, $newId, $menu_id){
		if ($lang=='vi') {
			$result = Article::where('id', '=', $newId)
						->get();
		}else{
			$result = Article::leftJoin('languages', function($join) {
					      $join->on('articles.id', '=', 'languages.item_id');
					    })
					->where('languages.table_name', '=', 'articles')
					->where('languages.lang', '=', $lang)
					->where('articles.id', '=', $newId)
					->where('articles.menu_id', '=', $menu_id)
					->select('articles.id as id', 'languages.alias as alias', 'languages.name as title', 'languages.img as img', 'languages.desc as desc', 'languages.fulltext as fulltext', 'articles.menu_id as menu_id', 'articles.category_id as category_id', 'articles.created_at as created_at')
					->get();
		}
		return $result;
	}

	public static function getOther($lang, $newId, $menu_id){
		if ($lang=='vi') {
			$result = Article::where('id', '!=', $newId)
						->where('menu_id', '=', 9)
						->get();
		}else{
			$result = Article::leftJoin('languages', function($join) {
					      $join->on('articles.id', '=', 'languages.item_id');
					    })
					->where('languages.table_name', '=', 'articles')
					->where('menu_id', '=', 9)
					->where('languages.lang', '=', $lang)
					->where('articles.id', '!=', $newId)
					->where('articles.menu_id', '=', $menu_id)
					->select('articles.id as id', 'languages.alias as alias', 'languages.name as title', 'languages.img as img', 'languages.desc as desc', 'languages.fulltext as fulltext', 'articles.menu_id as menu_id', 'articles.category_id as category_id', 'articles.created_at as created_at')
					->get();
		}
		return $result;
	}

	//Admin - Huynh dung add on 2015/03/10	
	public static function validate($input) {

        $rules = array(
                'category_id' => array( 'required', 'numeric', 'min:1' ),
		        'menu_id' => array( 'required', 'numeric', 'min:1'  ),
		        //'image' => array( 'required'),
		        'title' => array( 'required', 'max:255' ),
		        'desc' => array( 'required'),
		        'fulltext' => array( 'required' ),
		        'image_en' => array( 'image' ),
		        'title_en' => array( 'required_with:desc_en,fulltext_en', 'max:255' ),
		        'desc_en' => array( 'required_with:title_en,fulltext_en' ),
		        'fulltext_en' => array( 'required_with:title_en,desc_en'),
		        'image_ja' => array( 'image' ),
		        'title_ja' => array( 'required_with:desc_ja,fulltext_ja', 'max:255' ),
		        'desc_ja' => array( 'required_with:title_ja,fulltext_ja' ),
		        'fulltext_ja' => array( 'required_with:title_ja,desc_ja' ),
		        'keywords' => array( 'required', 'max:500' ),
		        'description' => array( 'max:500' ),
		        'author' => array( 'max:255' ),
		        'google_publisher' => array( 'max:255' ),
		        'google_author' => array( 'max:255' ),
		        'facebook_id' => array( 'max:255' ),
		        'og_title' => array( 'max:255' ),
		        'og_description' => array( 'max:255' )
        );

        return Validator::make($input, $rules);
	}

	/**
	 * Read a record
	 *
	 * @return array
	 */
	public static function read($id){
		$res = Article::where('id', '=', $id)
						->first();
		return $res;
	}

	public static function readDetail($id){
		$res =  Article::leftJoin('categories', function($join) {
					  $join->on('articles.category_id', '=', 'categories.id');
				   })
				->leftJoin('menus', function($join) {
					  $join->on('articles.menu_id', '=', 'menus.id');
				   })
				->where('articles.id','=',$id)
				->select('articles.id as id', 'articles.title as title', 'articles.img as img', 'articles.desc as desc', 'articles.fulltext as fulltext', 
					'articles.created_at as created_at', 'articles.updated_at as updated_at', 'menus.name as menu_id', 'categories.name as category_id')
				->first();
		return $res;
	}

	/**
	 * Read all record
	 *
	 * @return array
	 */
	public static function getAll(){
		$result = Article::leftJoin('categories', function($join) {
					  $join->on('articles.category_id', '=', 'categories.id');
				   })
				->leftJoin('menus', function($join) {
					  $join->on('articles.menu_id', '=', 'menus.id');
				   })
				->whereNull('articles.deleted_at')
				->orderBy('articles.id', 'desc')
				->select('articles.id as id', 'articles.title as title', 'articles.img as img', 'articles.desc as desc', 'articles.fulltext as fulltext', 
					'articles.created_at as created_at', 'articles.updated_at as updated_at', 'menus.name as menu_id', 'categories.name as category_id')
				->paginate(3);
		return $result;
	}

	/**
	 * Search 
	 *
	 * @return array
	 */
	public static function getSearch($keyword){
		
		$result = Article::where('title', 'LIKE', '%'.$keyword.'%')
				->orwhere('desc', 'LIKE', '%'.$keyword.'%')
				->orwhere('fulltext', 'LIKE', '%'.$keyword.'%')
				->paginate(3);
		return $result;
	}

	/**
	 * Del a record 
	 *
	 * @return true, false
	 */
	public static function Del($id){
		$result = Article::where('id', $id)->update(['deleted_at' => Carbon::now()]);
		if($result) return true;
		else return false;
	}

	/**
	 * Insert new record 
	 *
	 * @return true, false
	 */
	public function Insert($dataVi, $dataLang, $dataSEO){
		$result = false;
		try {
			//get list column
			$this->fields = DB::connection()->getSchemaBuilder()->getColumnListing($this->table);
			//get list column of Languages table
			$this->fields_Lang = DB::connection()->getSchemaBuilder()->getColumnListing($this->table_Lang);
			//get list column of Seos table
			$this->fields_SEO = DB::connection()->getSchemaBuilder()->getColumnListing($this->table_SEO);

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

			//Insert to Articles
			$arr = array();
			foreach ($this->fields as $v) {
				if(isset($dataVi[$v])){
					$arr[$v] = $dataVi[$v];
					if($v == 'img')
						$arr[$v] = $filename;
					else $arr[$v] = $dataVi[$v];
				}
			}
			$id = Article::insertGetId($arr);

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

			//Insert to SEO
			$arrSEO = array();
			foreach ($this->fields_SEO as $v) {
				if(isset($dataSEO[$v])){
					if($v == 'item_id')
							$arrSEO[$v] = $id;
					else $arrSEO[$v] = $dataSEO[$v];
				}
			}
			DB::table($this->table_SEO)->insert($arrSEO);

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
	public function _Update($dataVi, $dataLang, $dataSEO,$id){
		$result = false;
		try {
			//get list column
			$this->fields = DB::connection()->getSchemaBuilder()->getColumnListing($this->table);
			//get list column of Languages table
			$this->fields_Lang = DB::connection()->getSchemaBuilder()->getColumnListing($this->table_Lang);
			//get list column of Seos table
			$this->fields_SEO = DB::connection()->getSchemaBuilder()->getColumnListing($this->table_SEO);

			DB::beginTransaction();
			//image articles
			$filename = $this->read($id)->img;
			if($_FILES['image']['name'] != ''){
				//del old image
				if (File::exists($this->_url.'/'.$filename))
					unlink($this->_url.'/'.$filename);
				//Upload img
				$filename = $this->uploadImg(Input::file('image'), $this->_url, 100, 80);

			}
			//image en
			$filename_en = Language::read($id,'articles','en')->img;
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
			$filename_ja = Language::read($id,'articles','ja')->img;
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
			//Update to Articles
			$arr = array();
			foreach ($this->fields as $v) {
				if(isset($dataVi[$v])){
					$arr[$v] = $dataVi[$v];
					if($v == 'img')
						$arr[$v] = $filename;
					else $arr[$v] = $dataVi[$v];
				}
			}
			Article::where('id','=',$id)->update($arr);

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

			//Update to SEO
			$arrSEO = array();
			foreach ($this->fields_SEO as $v) {
				if(isset($dataSEO[$v])){
					$arrSEO[$v] = $dataSEO[$v];
				}
			}
			DB::table($this->table_SEO)->where('item_id','=',$id)->update($arrSEO);

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
