<?php namespace App;

use Illuminate\Database\Eloquent\Model;
class Company extends Model{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'companies';

	public $timestamps = false;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['id', 'name', 'title', 'director', 'address', 'phone', 'fax', 'email', 'skype', 'copyright', 'lang'];

	public static function getCompany($lang){
		return Company::where('lang', '=', $lang)->get();
	}
}
