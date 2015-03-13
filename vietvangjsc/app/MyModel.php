<?php
//Created by Huynh Dung 
 namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MyModel extends Model{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = null;
	protected $fields = array();

	public function __construct($table=null){
		parent::__construct();
		$this->initialize($table);
	}

	public function initialize($table = null){
		if(!is_null($table)){
			//get list column
			$this->fields = DB::connection()->getSchemaBuilder()->getColumnListing($this->table);
		}
	}

	public static function uploadImg($img, $url, $w, $h){
		// getting all of the post data
		$file = array('image' => $img);
		// setting up rules
		$rules = array('image' => 'required|mimes:jpeg,bmp,png|max:10000'); //mimes:jpeg,bmp,png and for max size max:10000
		// doing the validation, passing post data, rules and the messages
		$validator = Validator::make($file, $rules);
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
			  $this->resizeImg($img->getRealPath().$img->getClientOriginalName(), $fileName, $path, $w, $h);

			  $img->move($url, $fileName); // uploading file to given path
			  
			  return true;
			}
			else {
			  return false;
			}
		}
	}

	public function resizeImg($tmp, $fileName, $path, $w, $h){
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
