<?php namespace App;

use Illuminate\Database\Eloquent\Model;
class Seo extends MyModel{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'seos';

	public $timestamps = false;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	//protected $fillable = ['id', 'title', 'item_id', 'table_name', 'lang', 'name', 'img', 'note', 'desc', 'fulltext', 'customer'];

	public function __construct(){
		parent::__construct('seos');
	}

	public static function read($id){
		$res = Seo::where('item_id', '=', $id)
				->first();
		return $res;
	}
}
