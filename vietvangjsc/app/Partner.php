<?php namespace App;

use Illuminate\Database\Eloquent\Model;
class Partner extends Model{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'partners';

	public $timestamps = false;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['id', 'name', 'logo', 'url'];

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
}
