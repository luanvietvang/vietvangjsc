<?php namespace App\Http\Controllers;

use App\Company;
use App\Menu;
use App\Category;
use App\Partner;
use App\Article;
use App\Product;
use App\Ini;
use App\Services\Registrar;
use Session;
use Cookie;
use Input;
use Mail;
use Redirect;
use Illuminate\Support\Facades\DB;
use Url;

class AdminController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Admin Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//$this->middleware('auth');
		$this->msg = Ini::message(true);

		//url to upload img
		// $this->url = URL::to('public/upload/articles');
		// //Real path img to upload
		// $this->url = realpath(APPPATH.'../public/upload/articles');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		//do something
		return view('admin.index');
	}

	/**
	 * Show the form articles [index].
	 *
	 * @return Response
	 */
	public function articles()
	{
		//get all
		$keyword = Input::get('keyword');
		if($keyword == ""){
			$title = 'Article';
			$kw = '';
			$arts = Article::getAll();
		}
		else {
			$title = 'Search Article';
			$kw = $keyword;
			$arts = Article::getSearch($keyword);
		}
		return view('admin.articles.index')->with([
				'msg' => $this->msg,
				'title' => $title,
				'arts' 	=> $arts,
				'kw' 	=> $kw
			]);
	}

	/**
	 * Add new articles [add].
	 *
	 * @return Response
	 */
	public function articlesAdd()
	{
		//Set title
		$title = 'Article [Add]';

		//Get List categories
		$cate = Category::getLstCategoriesVi();

		//Validate Form - sẽ viết Service sau. Tạm thời bỏ qua bước này.


		//Alias name vi 
		$alias = mb_strtolower(Registrar::removesign(Input::get('title')));
		//Alias name en 
		$alias_en = mb_strtolower(Registrar::removesign(Input::get('title_en')));
		//Alias name ja 
		$alias_ja = mb_strtolower(Registrar::removesign(Input::get('title_ja')));

		//Array Article
		$dataVi = Input::all();
		//Array Lang
		$dataLang = ([[
			'item_id' => '',
			'alias' => $alias_en, 
			'table_name' => 'languages',
			'lang' => 'en', 
			'name' => Input::get('title_en'),
			'img' => '', //-------------------------------------> get sau khi đã tạo form
			'desc' => Input::get('desc_en'),
			'fulltext' => Input::get('fulltext_en')
			],
			[
			'item_id' => '',
			'alias' => $alias_ja, 
			'table_name' => 'languages',
			'lang' => 'ja', 
			'name' => Input::get('title_ja'),
			'img' => '', //-------------------------------------> get sau khi đã tạo form
			'desc' => Input::get('desc_ja'),
			'fulltext' => Input::get('fulltext_ja')
			]
			]);
		//Array Seo
		$dataSEO = Input::all();//Gan du lieu sau

		$articles = new Article();
		$res = $articles->Insert($dataVi, $dataLang, $dataSEO);
		if($res != ''){
			$msg = array(
				'type_msg' =>'danger',
				'msg' =>'Lỗi! Đã có lỗi trong quá trình thêm - ref:'.$res
				);
		}
		else{
			$msg = array(
				'type_msg' =>'success',
				'msg' =>'Thành công! Dữ liệu đã được lưu trữ'
				);
		}
		session($msg);

		// return Redirect::back();
		return view('admin.articles.add')->with([
				'msg' => $this->msg,
				'title' => $title,
				'cate' => $cate
			]);
	}

	/**
	 * Delete articles [Delete].
	 *
	 * @return Response
	 */
	public function articlesDel($id)
	{
		$res = Article::Del($id);
		if(!$res){
			$msg = array(
				'type_msg' =>'danger',
				'msg' =>'Lỗi! Đã có lỗi trong quá trình xóa'
				);
		}
		else{
			$msg = array(
				'type_msg' =>'success',
				'msg' =>'Thành công! Dữ liệu đã được xóa'
				);
		}
		session($msg);
		return Redirect::back();
		//return Redirect::to('admin/articles/');
	}
}
