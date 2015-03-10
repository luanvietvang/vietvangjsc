<?php namespace App;

use Illuminate\Database\Eloquent\Model;
class Product extends Model{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'products';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['id','alias', 'name', 'note', 'desc', 'img', 'customer', 'category_id', 'created_at', 'updated_at'];

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
}
