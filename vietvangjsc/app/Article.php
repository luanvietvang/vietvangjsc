<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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


	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['id', 'alias', 'title', 'img', 'dec', 'menu_id', 'category_id', 'created_at', 'updated_at', 'deleted_at', 'hit'];

	public function __construct(){
		parent::__construct('articles');
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

	public static function getSearch($keyword){
		
		$result = Article::where('title', 'LIKE', '%'.$keyword.'%')
				->orwhere('desc', 'LIKE', '%'.$keyword.'%')
				->orwhere('fulltext', 'LIKE', '%'.$keyword.'%')
				->paginate(3);
		return $result;
	}

	public static function Del($id){
		$result = Article::where('id', $id)->update(['deleted_at' => Carbon::now()]);
		if($result) return true;
		else return false;
	}

	public function Insert($dataVi, $dataLang, $dataSEO){
		try {
			//get list column
			$this->fields = DB::connection()->getSchemaBuilder()->getColumnListing($this->table);
			//get list column of Languages table
			$this->fields_Lang = DB::connection()->getSchemaBuilder()->getColumnListing($this->table_Lang);
			//get list column of Seos table
			$this->fields_SEO = DB::connection()->getSchemaBuilder()->getColumnListing($this->table_SEO);

			DB::beginTransaction();
			//Insert to Articles
			$arr = array();
			foreach ($this->fields as $v) {
				if(isset($dataVi[$v])){
					$arr[$v] = $dataVi[$v];
				}
			}
			$id = Article::insertGetId($arr);

			//Insert to Languages
			if($dataLang != null){
				$arrLang = array();
				foreach ($dataLang as $Lang) {
					foreach ($this->fields_Lang as $v) {
						if(isset($Lang[$v])){
							if($Lang[$v] == 'item_id')
								$arrLang[$v] = $id;
							else $arrLang[$v] = $Lang[$v];
						}
					}
					DB::table($this->table_Lang)->insert($arrLang);
				}
			}

			//Insert to SEO
			$arrSEO = array();
			foreach ($this->fields_SEO as $v) {
				if(isset($dataSEO[$v])){
					if($dataSEO[$v] == 'item_id')
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
}
