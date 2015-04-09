<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Input;
use Validator;
use App\Language;
use File;

class Product extends MyModel{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'products';
	protected $fields = array();

	protected $table_Lang = 'languages';
	protected $fields_Lang = array();

	protected $_url;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['id','alias', 'name', 'note', 'desc', 'img', 'customer', 'category_id', 'created_at', 'updated_at'];

	public function __construct(){
		parent::__construct('products');
		$this->_url = base_path('public/upload/products');
	}

	public static function getProducts($lang, $category_id){
		if ($lang=="vi") {
			if ($category_id == 0) {
				$results = Product::orderBy('id', 'desc')->get();
			}else{
				$results = Product::where('category_id', '=', $category_id)
										-> orderBy('id', 'desc')
										-> get();
			}
		}else{
			if ($category_id == 0) {
				$results = Product::leftJoin('languages', function($join) {
									      $join->on('products.id', '=', 'languages.item_id');
									    })
									-> where('languages.table_name', '=', 'products')
									-> where('languages.lang', '=', $lang)
									-> orderBy('products.id', 'desc')
									-> select('products.id as id', 'languages.alias as alias', 'languages.name as name', 'languages.note as note', 'languages.desc as desc', 'products.img as img', 'languages.customer as customer')
									-> get();
			}else{
				$results = Product::leftJoin('languages', function($join) {
									      $join->on('products.id', '=', 'languages.item_id');
									    })
									-> where('languages.table_name', '=', 'products')
									-> where('languages.lang', '=', $lang)
									-> where('products.category_id', '=', $category_id)
									-> orderBy('products.id', 'desc')
									-> select('products.id as id', 'languages.alias as alias', 'languages.name as name', 'languages.note as note', 'languages.desc as desc', 'products.img as img', 'languages.customer as customer')
									-> get();
			}
		}
		return $results;
	}

	public static function getProduct($productId, $lang){
		if ($lang == "vi") {
			$results = Product::where('id', '=', $productId)->get();
		}else{
			$results = Product::leftJoin('languages', function($join){
									$join->on('Products.id', '=', 'languages.item_id');
								})
							->where('languages.table_name', '=', 'products')
							->where('languages.lang', '=', $lang)
							-> select('products.id as id', 'languages.alias as alias', 'languages.name as name', 'languages.note as note', 'languages.desc as desc', 'products.img as img', 'languages.customer as customer')
							-> get();
		}
		return $results;
	}

	//Admin - Huynh dung add on 2015/04/08	
	public static function validate($input) {

        $rules = array(
                'category_id' => array( 'required', 'numeric', 'min:1' ),
		        //'image' => array( 'required'),
		        'name' => array( 'required', 'max:255' ),
		        'note' => array( 'required'),
		        'desc' => array( 'required' ),
		        'image_en' => array( 'image' ),
	            'cutomer' => array( 'required'),
		        'title_en' => array( 'required_with:desc_en,fulltext_en', 'max:255' ),
		        'desc_en' => array( 'required_with:title_en,fulltext_en' ),
		        'fulltext_en' => array( 'required_with:title_en,desc_en'),
		        'image_ja' => array( 'image' ),
		        'title_ja' => array( 'required_with:desc_ja,fulltext_ja', 'max:255' ),
		        'desc_ja' => array( 'required_with:title_ja,fulltext_ja' ),
		        'fulltext_ja' => array( 'required_with:title_ja,desc_ja' )
        );

        return Validator::make($input, $rules);
	}

	/**
	 * Read a record
	 *
	 * @return array
	 */
	public static function read($id){
		$res = Product::where('id', '=', $id)
						->first();
		return $res;
	}

	public static function readDetail($id){
		$res =  Product::leftJoin('categories', function($join) {
					  $join->on('products.category_id', '=', 'categories.id');
				   })
				->where('products.id','=',$id)
				->select('products.id as id', 'products.name as name', 'products.img as img',
					'products.list_img as list_img','products.desc as desc', 'products.note as note',
					'products.cutomer as cutomer','products.created_at as created_at', 
					'products.updated_at as updated_at', 'categories.name as category_id')
				->first();
		return $res;
	}

	/**
	 * Read all record
	 *
	 * @return array
	 */
	public static function getAll(){
		$result = Product::leftJoin('categories', function($join) {
					  $join->on('products.category_id', '=', 'categories.id');
				   })
				->whereNull('products.deleted_at')
				->orderBy('products.id', 'desc')
				->select('products.id as id', 'products.name as name', 'products.img as img',
					'products.list_img as list_img','products.desc as desc', 'products.note as note',
					'products.cutomer as cutomer','products.created_at as created_at', 
					'products.updated_at as updated_at', 'categories.name as category_id')
				->paginate(3);
		return $result;
	}

	/**
	 * Search 
	 *
	 * @return array
	 */
	public static function getSearch($keyword){
		
		$result = Product::leftJoin('categories', function($join) {
					  $join->on('products.category_id', '=', 'categories.id');
				   })
				->where('products.name', 'LIKE', '%'.$keyword.'%')
				->orwhere('products.desc', 'LIKE', '%'.$keyword.'%')
				->orwhere('note', 'LIKE', '%'.$keyword.'%')
				->select('products.id as id', 'products.name as name', 'products.img as img',
					'products.list_img as list_img','products.desc as desc', 'products.note as note',
					'products.cutomer as cutomer','products.created_at as created_at', 
					'products.updated_at as updated_at', 'categories.name as category_id')
				->paginate(3);
		return $result;
	}

	/**
	 * Del a record 
	 *
	 * @return true, false
	 */
	public static function Del($id){
		$result = Product::where('id', $id)->update(['deleted_at' => Carbon::now()]);
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
			
			//Upload mutiple img
			$list_img = Input::file('list_img');
			$listFilename = null;
			if($list_img != null){
				foreach ($list_img as $v) {
					$listFilename .= $this->uploadImg($v, $this->_url, 100, 80).',';
				}
			}
			//Upload img
			$filename = $this->uploadImg(Input::file('image'), $this->_url, 100, 80);
			// echo $filename; die();

			$filename_en = null;
			$filename_ja = null;
			if(!Input::get('ckimg')){
				if($_FILES['image_en']['name'] != '')
					$filename_en = $this->uploadImg(Input::file('image_en'), $this->_url, 100, 80);
				if($_FILES['image_ja']['name'] != '')
					$filename_ja = $this->uploadImg(Input::file('image_ja'), $this->_url, 100, 80);
			}

			//Insert to products
			$arr = array();
			foreach ($this->fields as $v) {
				if(isset($dataVi[$v])){
					if($v == 'img'){
						$arr[$v] = $filename;
					}
					elseif($v == 'list_img' && $listFilename != null)
						$arr[$v] = rtrim($listFilename,',');
					else $arr[$v] = $dataVi[$v];
				}
			}
			$id = Product::insertGetId($arr);

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
			$obj = $this->read($id);
			//image products
			$filename = $obj->img;
			if($_FILES['image']['name'] != ''){
				//del old image
				if (File::exists($this->_url.'/'.$filename))
					unlink($this->_url.'/'.$filename);
				//Upload img
				$filename = $this->uploadImg(Input::file('image'), $this->_url, 100, 80);
			}

			//get list img để sau
			$listFilename = $obj->list_img;
			if($_FILES['list_img']['name'] != ''){
				//del old image
				$arr_img = explode(',', $listFilename);
				foreach ($arr_img as $img) {
					if (File::exists($this->_url.'/'.$img))
					unlink($this->_url.'/'.$img);
				}
				
				//Upload img
				$listFilename = '';
				foreach (Input::file('list_img') as $v) {
					$listFilename .= $this->uploadImg($v, $this->_url, 100, 80).',';
				}
			}

			//image en
			$filename_en = Language::read($id,'products','en')->img;
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
			$filename_ja = Language::read($id,'products','ja')->img;
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
			//Update to products
			$arr = array();
			foreach ($this->fields as $v) {
				if(isset($dataVi[$v])){
					if($v == 'img'){
						$arr[$v] = $filename;
					}
					elseif($v == 'list_img' && $listFilename != null)
						$arr[$v] = rtrim($listFilename,',');
					else $arr[$v] = $dataVi[$v];
				}
			}
			Product::where('id','=',$id)->update($arr);

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
