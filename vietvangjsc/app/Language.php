<?php namespace App;

use Illuminate\Database\Eloquent\Model;
class Language extends MyModel{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'languages';

	public $timestamps = false;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['id', 'alias', 'item_id', 'table_name', 'lang', 'name', 'img', 'note', 'desc', 'fulltext', 'customer'];

	public function __construct(){
		parent::__construct('languages');
	}

	public static function read($id, $table_name, $lang){
		$res = Language::where('item_id', '=', $id)
				->where('table_name', '=', $table_name)
				->where('lang', '=', $lang)
				->first();
		return $res;
	}

	public static function read2($id, $table_name){
		$res = Language::where('item_id', '=', $id)
				->where('table_name', '=', $table_name)
				->get();
		return $res;
	}

	public static function Del($id, $table_name){
		$res = Language::where('item_id', '=', $id)
				->where('table_name', '=', $table_name)
				->delete();
		return $res;
	}
}
