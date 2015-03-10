<?php namespace App;

use Illuminate\Database\Eloquent\Model;
class Language extends Model{
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
}
