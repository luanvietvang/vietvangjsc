<?php namespace App;

use Illuminate\Database\Eloquent\Model;
class Article extends Model{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'articles';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['id', 'alias', 'title', 'img', 'dec', 'menu_id', 'category_id', 'created_at', 'updated_at', 'deleted_at', 'hit'];

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
}
