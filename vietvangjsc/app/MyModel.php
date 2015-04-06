<?php
//Created by Huynh Dung 
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Validator;
use Redirect;
//use Intervention\Image\Image;

class MyModel extends Model{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $_table = null;
	protected $fields = array();
	protected $key = null; 

	public function __construct($_table){
		parent::__construct();
		$this->initialize($_table);
	}

	public function initialize($_table = null){
		if(!is_null($_table)){
			//get list column
			$this->fields = DB::connection()->getSchemaBuilder()->getColumnListing($this->_table);
			//$this->key = App::make($this->table)->getKeyName();

		}
	}

	// public function read($id){
	// 	$res = DB::table($this->_table)->where('id', '=', $id)
	// 					->get();
	// 	return $res;
	// }

	public static function uploadImg($img, $url, $w, $h){
		// getting all of the post data
		$file = array('image' => $img);
		// setting up rules
		$rules = array('image' => 'required');//|mimes:jpeg,bmp,png');//|max:10000'); //mimes:jpeg,bmp,png and for max size max:10000
		// doing the validation, passing post data, rules and the messages
		$validator = Validator::make($file, $rules);
		$fileName = '';
		if ($validator->fails()) {
		// send back to the page with the input data and errors
		return Redirect::back()->withInput()->withErrors($validator);

		}
		else {
			// checking file is valid.
			if ($img->isValid()) {
			  //$destinationPath = $url; // upload path
			  $extension = $img->getClientOriginalExtension(); // getting image extension
			  $fileName = time().rand(11111,99999).'.'.$extension; // renameing image

			  //resize img
			  //self::resizeImg($img->getRealPath().$img->getClientOriginalName(), $fileName, $url, $w, $h);

			  $img->move($url, $fileName); // uploading file to given path
			  
			  return $fileName;
			}
			else {
			  return $fileName;
			}
		}
	}

	public static function resizeImg($tmp, $fileName, $path, $w, $h){
		// open an image file
		$img = Image::make($tmp);

		// now you are able to resize the instance
		$img->resize($w, $h);

		// and insert a watermark for example
		//$img->insert('public/watermark.png');

		// finally we save the image as a new file
		$img->save($url.'/thumbs/'.$fileName);
	}
	
}
