<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Input;
use Validator;
use App\Language;
use File;


class Partner extends MyModel{



	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'partners';
	protected $_url;

	public $timestamps = false;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['id', 'name', 'logo', 'url'];

	public function __construct(){
		parent::__construct('partner');
		$this->_url = base_path('public/upload/partners');
	}

	public static function getPartners($lang){
		if ($lang == "vi") {
			$result = Partner::select('id as id', 'name as name', 'logo as logo', 'url as url')
						->orderBy('id','desc')
						->take(3)
						->get();
		}
		else{ 
			$result = Partner::leftJoin('languages', function($join) {
					      $join->on('partners.id', '=', 'languages.item_id');
					    })
					->where('languages.table_name', '=', 'partners')
					->select('partners.id as id', 'languages.name as name', 'partners.logo as logo', 'partners.url as url')
					->orderBy('partners.id','desc')
					->take(3)
					->get();
		}
		return $result;
	}



	/*
	*get partners
	*
	*/
	public static function getAll()
	{
		$result = Partner::orderBy('name')->paginate(3);
		return $result;
	}

	/*
	*insert partner
	*
	*/

	public function geturl()
	{
		return $this->_url;
	}
	public function insert($data_partner)
	{
		$imgname = Partner::uploadImg(Input::file('logo'), $this->_url, 100, 80);
		$data = array(
			'name'	=>	$data_partner['name'],
			'url'	=>	$data_partner['url'],
			'logo'	=>	$imgname
			);
		$result = DB::table('partners')->insert($data);
		return $result;
	}

	/*
	*validate
	*
	*/
	public static function validation($data)
	{
		$rules = array(
			'name' 	=> 'required',
			'url' 	=> 'required'
			);
		return Validator::make($data, $rules);
	}

	/*
	*check name of partner exits
	*return false if no exits
	*/
	public static function checkExited($name,$id)
	{
		$partner = DB::table('partners')->where('name','=',$name)->get();
		$result = false;
		if (count($partner)<1) return $result; 
		else {
			for ($i=0; $i<count($partner); $i++){// tồn tại chính nó
				if ($partner[$i]->id == $id) {
					$result = false;
				} else $result = true;
			}
			return $result;
		}
	}


	/*
	*delete request
	*
	*/
	public static function del($id)
	{
		$result = DB::table('partners')->where('id','=',$id)->delete();
		return $result;
	}


	public static function delMulti($array_id)
	{
		$str='';
		$par = DB::table('partners')->where('id','=',$array_id[0])->delete();
		if (!$par){
			$par = DB::table('partners')->where('id','=',$array_id[0])->get();
			$str = $par[0]->name;
		}
		
		for ($i = 1;$i<count($array_id); $i++)
		{
			$par = DB::table('partners')->where('id','=',$array_id[$i])->delete();
			if (!$par){
				$par = DB::table('partners')->where('id','=',$array_id[0])->get();
				$str = $str.', '.$par[0]->name;
			}
			
		}
		return $str;
	}


	/*
	*get partner with id
	*
	*/
	public static function getpartner($id)
	{
		$result = DB::table('partners')->where('id','=',$id)->get();
		return $result;
	}


	/*
	*
	*
	*/
	public function upda($data_partner)
	{
		$data = array(
			'name'	=>	$data_partner['name'],
			'url'	=>	$data_partner['url'],
			'logo'	=>	$data_partner['logo']
			);
		if ($_FILES['logo']["size"]!=0){
			$imgname = Partner::uploadImg(Input::file('logo'), $this->_url, 100, 80);
			$data['logo'] = $imgname;
		}
		$result = DB::table('partners')->where('id','=',$data_partner['id'])->update($data);
		return $result;
		
	}
}
