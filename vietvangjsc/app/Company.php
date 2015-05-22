<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Input;
use Validator;
use App\Language;
use File;
class Company extends MyModel{
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

	public function __construct(){
		parent::__construct('users');
	}



	/*public static function getCompanies($lang){
		return Company::where('lang', '=', $lang)->get();
	}*/


	/*
	*get everything in companies table
	*
	*/
	public static function getAll()
	{
		$result = Company::get();
		return $result;
	}

	/*
	*
	*
	*/
	public static function getcompany($id)
	{
		$result = DB::table('companies')->where('id','=',$id)->get();
		return $result;
	}


	/*
	*
	*
	*/
	public static function validation($data)
	{
		$rules = array(
			'id' 		=> 'numeric',
			'name' 		=> 'required',
			'title' 	=> 'required',
			'director' 	=> 'required',
			'address' 	=> 'required',
			'phone'		=> 'required',
			'fax'		=> 'required',
			'email' 	=> 'required|email',
			'skype'		=> 'required',
			'copyright'	=> 'required'
			);
		return Validator::make($data, $rules);
	}

	/*
	*
	*
	*/
	public static function upda($data)
	{
		$result = DB::table('companies')->where('id','=',$data['id'])->update($data);
		return $result;
	}


	/*
	*
	*
	*/
	public static function getlocation()
	{
		$result = $result = DB::table('location')->get();
		return $result;
	}


	/*
	*
	*
	*/
	public static function updatelocation($data)
	{
		$result = DB::table('location')->where('id','=',$data['id'])->update($data);
		return $result;
	}
}
