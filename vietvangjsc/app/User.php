<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Input;
use Validator;
use App\Language;
use File;

class User extends MyModel{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['id', 'name', 'email', 'password','remember_token','created_at','updated_adt'];
	public function __construct(){
		parent::__construct('users');
	}
	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	/*
	*Get all user
	*
	*/

	public static function getAll()
	{
		$result = User::orderBy('name')->paginate(3);
		return $result;
	}


	/*
	*insert user in DB
	*
	*/
	public static function insert($data)
	{
		$result = DB::table('users')->insert($data);
		return $result;
	}

	/*
	*update user
	*
	*/

	public static function upda($data)
	{
		$result = DB::table('users')->where('id','=',$data['id'])->update($data);
		return $result;
	}
	/*
	*Validate the data befor store them
	*
	*/
	public static function validation($data)
	{
		$rules = array(
			'id' => 'numeric',
			'name' => 'required',
			'email' => 'required|email',
			'password' => 'required'
			);
		return Validator::make($data, $rules);
	}

	/*
	*delete user with id
	*
	*/
	public static function del($id)
	{
		$result = DB::table('users')->where('id','=',$id)->delete();
		return $result;
	}


	/*
	*get user with id
	*
	*/
	public static function getuser($id)
	{
		$result = DB::table('users')->where('id','=',$id)->get();
		return $result;
	}

	/*
	*check email exited
	*
	*/
	public static function checkExited($email,$id)
	{
		$user = DB::table('users')->where('email','=',$email)->get();
		$result = false;
		if (count($user)<1) return $result;
		else {
			for ($i=0; $i<count($user); $i++){
				if ($user[$i]->id == $id) {
					$result = false;
				} else $result = true;
			}
			return $result;
		}
	}

}
