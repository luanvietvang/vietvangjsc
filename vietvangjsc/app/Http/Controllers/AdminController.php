<?php namespace App\Http\Controllers;

use App\Company;
use App\Menu;
use App\Category;
use App\Partner;
use App\Article;
use App\Product;
use App\Language;
use App\Seo;
use App\Ini;
use App\Services\Registrar;
use Session;
use Cookie;
use Input;
use Mail;
use Redirect;
use Illuminate\Support\Facades\DB;
use Url;
// use App\RocketCandy\Exceptions\ValidationException;
// use App\RocketCandy\Services\Validation\ArticlesFormValidator as ArticlesForm;
use Carbon\Carbon;

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
		$this->resmenu = array();
		// $this->_validator = $validator;
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		//do something
		#check login here
		# Code....
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
		$title = 'Article';
		$kw = '';
		$arts = Article::getAll();
		
		return view('admin.articles.index')->with([
				'msg' => $this->msg,
				'title' => $title,
				'arts' 	=> $arts,
				'kw' 	=> $kw
			]);
	}

	/**
	 * Show the form articles [index].
	 *
	 * @return Response
	 */
	public function articlesSearch()
	{
		$title = 'Article [Search]';
		$parent = 'Article';
		$kw = Input::get('keyword');
		
		$arts = Article::getSearch($kw);
		return view('admin.articles.search')->with([
				'msg' => $this->msg,
				'title' => $title,
				'parent' => $parent,
				'arts' 	=> $arts,
				'kw' 	=> $kw
			]);
	}

	/**
	 * Add new articles [add].
	 *
	 * @return Response
	 */
	public function articlesDetail($id)
	{
		$title = 'Article [Detail]';

		$obj = Article::readDetail($id);
		$obj_en = Language::read($id,'articles','en');
		$obj_ja = Language::read($id,'articles','ja');
		$obj_seo = Seo::read($id);
		return view('admin.articles.detail')->with([
				'title' => $title,
				'obj' => $obj,
				'obj_en' => $obj_en,
				'obj_ja' => $obj_ja,
				'obj_seo' => $obj_seo
		]);
	}

	/**
	 * Add new articles [add].
	 *
	 * @return Response
	 */
	public function articlesAdd()
	{
		$title = 'Article [Add]';
		$parent = 'Article';
		//Get List categories
		$cate = Category::getLstCategoriesVi();
		$menu = $this->printLstMenuVi(Menu::getMenuVi(),0, '-');
		return view('admin.articles.add')->with([
				'msg' => $this->msg,
				'title' => $title,
				'parent' => $parent,
				'cate' => $cate,
				'menu' => $menu
		]);
	}

	public function articlesAdd_sm()
	{
		// //Set title
		// $title = 'Article [Add]';

		// //Get List categorie
		// $cate = Category::getLstCategoriesVi();
		// $menu = $this->printLstMenuVi(Menu::getMenuVi(),0, '-');
		//$_input = Input::all();
		// if (!Input::get('ckimg').checked) {
		// 	# code...
		// }
		$v = Article::validate(Input::all());
		if ( $v->passes() ) {
			//Alias name vi 
			$alias = mb_strtolower(Registrar::removesign(Input::get('title')));
			//Alias name en 
			$alias_en = mb_strtolower(Registrar::removesign(Input::get('title_en')));
			//Alias name ja 
			$alias_ja = mb_strtolower(Registrar::removesign(Input::get('title_ja')));

			//Array Article
			$dataVi = ([
				'alias' => $alias,
				'title' => Input::get('title'),
				'img' => '',//Input::file('image'),
				'desc' => Input::get('desc'),
				'fulltext' => Input::get('fulltext'),
				'menu_id' => Input::get('menu_id'),
				'category_id' => Input::get('category_id'),
				'created_at' => Carbon::now(),
				'hit' => Input::get('hit')
				]);
			//Array Lang
			$dataLang = ([[
				'item_id' => '',
				'alias' => $alias_en, 
				'table_name' => 'articles',
				'lang' => 'en', 
				'name' => Input::get('title_en'),
				'img' => '', //-------------------------------------> get sau khi đã tạo form
				'desc' => Input::get('desc_en'),
				'fulltext' => Input::get('fulltext_en')
				],
				[
				'item_id' => '',
				'alias' => $alias_ja, 
				'table_name' => 'articles',
				'lang' => 'ja', 
				'name' => Input::get('title_ja'),
				'img' => '', //-------------------------------------> get sau khi đã tạo form
				'desc' => Input::get('desc_ja'),
				'fulltext' => Input::get('fulltext_ja')
				]
				]);
			//Array Seo
			$dataSEO = ([
				'item_id' => '',
				'title' => Input::get('title'),
				'table_name' => 'articles',
				'keywords' => Input::get('keywords'),
				'description' => Input::get('description'),
				'author' => Input::get('author'),
				'google_publisher' => Input::get('google_publisher'),
				'google_author' => Input::get('google_author'),
				'facebook_id' => Input::get('facebook_id'),
				'og_title' => Input::get('og_title'),
				'og_description' => Input::get('og_description')
				]);
			// Input::only('category_id', '','keywords', 'description','author', 'google_publisher','google_author', 'facebook_id','og_title', 
			// 	'og_description');
			$articles = new Article();
			$res = $articles->Insert($dataVi, $dataLang, $dataSEO);
			if(!$res){
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
			if(isset($_POST['continue']))
				return redirect()->action('AdminController@articlesAdd');
			else return redirect()->action('AdminController@articles');
		}
		 else {
		 	Input::flash();
            return redirect()->action('AdminController@articlesAdd')->withErrors( $v->getMessageBag());
        }
	}

	/**
	 * Edit an articles [Edit].
	 *
	 * @return Response
	 */
	public function articlesEdit($id)
	{
		$title = 'Article [Edit]';
		$parent = 'Article';

		$obj = Article::read($id);
		$obj_en = Language::read($id,'articles','en');
		$obj_ja = Language::read($id,'articles','ja');
		$obj_seo = Seo::read($id);
		//Get List categories
		$cate = Category::getLstCategoriesVi();
		$menu = $this->printLstMenuViEdit(Menu::getMenuVi(),0, '-',$obj->menu_id);

		//echo public_path("upload/article/".$obj->img); die();
		return view('admin.articles.edit')->with([
				'msg' => $this->msg,
				'title' => $title,
				'parent' => $parent,
				'cate' => $cate,
				'menu' => $menu,
				'obj' => $obj,
				'obj_en' => $obj_en,
				'obj_ja' => $obj_ja,
				'obj_seo' => $obj_seo
		]);
	}

	public function articlesEdit_sm()
	{
		$id = Input::get('id');
		$v = Article::validate(Input::all());
		if ( $v->passes() ) {
			//Alias name vi 
			$alias = mb_strtolower(Registrar::removesign(Input::get('title')));
			//Alias name en 
			$alias_en = mb_strtolower(Registrar::removesign(Input::get('title_en')));
			//Alias name ja 
			$alias_ja = mb_strtolower(Registrar::removesign(Input::get('title_ja')));

			//Array Article
			$dataVi = ([
				'alias' => $alias,
				'title' => Input::get('title'),
				'img' => '',//Input::file('image'),
				'desc' => Input::get('desc'),
				'fulltext' => Input::get('fulltext'),
				'menu_id' => Input::get('menu_id'),
				'category_id' => Input::get('category_id'),
				'updated_at' => Carbon::now(),
				'hit' => Input::get('hit')
				]);
			//Array Lang
			$dataLang = ([[
				'item_id' => $id,
				'alias' => $alias_en, 
				'table_name' => 'articles',
				'lang' => 'en', 
				'name' => Input::get('title_en'),
				'img' => '', //-------------------------------------> get sau khi đã tạo form
				'desc' => Input::get('desc_en'),
				'fulltext' => Input::get('fulltext_en')
				],
				[
				'item_id' => $id,
				'alias' => $alias_ja, 
				'table_name' => 'articles',
				'lang' => 'ja', 
				'name' => Input::get('title_ja'),
				'img' => '', //-------------------------------------> get sau khi đã tạo form
				'desc' => Input::get('desc_ja'),
				'fulltext' => Input::get('fulltext_ja')
				]
				]);
			//Array Seo
			$dataSEO = ([
				'item_id' => $id,
				'title' => Input::get('title'),
				'table_name' => 'articles',
				'keywords' => Input::get('keywords'),
				'description' => Input::get('description'),
				'author' => Input::get('author'),
				'google_publisher' => Input::get('google_publisher'),
				'google_author' => Input::get('google_author'),
				'facebook_id' => Input::get('facebook_id'),
				'og_title' => Input::get('og_title'),
				'og_description' => Input::get('og_description')
				]);

			$articles = new Article();
			$res = $articles->_Update($dataVi, $dataLang, $dataSEO, $id);
			if(!$res){
				$msg = array(
					'type_msg' =>'danger',
					'msg' =>'Lỗi! Đã có lỗi trong quá trình cập nhật - ref:'.$res
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
			return redirect()->action('AdminController@articles');
		}
		 else {
		 	Input::flash();
			return redirect()->action('AdminController@articlesEdit', [$id])
			->withErrors( $v->getMessageBag());;
        }
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

	public function articlesMutiDel()
	{
		$arr_id = Input::get('item');
		//tao string hung name bai viet khong the xoa
		$str = '';
		if (is_array($arr_id))
		{
			foreach ($arr_id as $id) {
				# check relasionship here
					# code sau...
				# Read Articles
				$art = Article::read($id);
				# Del database
				$res = Article::Del($id);
				#Kiem tra sau khi xoa
				if (!$res) {
					$str .= $art['title'] . ', ';
					continue;
				}	
			}
		}
		if(!$str == ''){
			$msg = array(
				'type_msg' =>'danger',
				'msg' => $str.' không xóa được'
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
	}
	
	public function printLstMenuVi($lstMenu, $parent_id, $char){
		foreach ($lstMenu as $v) {
			if($v->parent_id == $parent_id){
				array_push($this->resmenu,'<option value="'.$v->id.'">'.$char.$v->name.'</option>');
				$this->printLstMenuVi($lstMenu, $v->id, $char.$char);
			}
		}
		return $this->resmenu;
	}

	public function printLstMenuViEdit($lstMenu, $parent_id, $char,$id){
		foreach ($lstMenu as $v) {
			if($v->parent_id == $parent_id){
				if($v->id == $id)
					array_push($this->resmenu,'<option selected="selected" value="'.$v->id.'">'.$char.$v->name.'</option>');
				else
					array_push($this->resmenu,'<option value="'.$v->id.'">'.$char.$v->name.'</option>');
				$this->printLstMenuViEdit($lstMenu, $v->id, $char.$char, $id);
			}
		}
		return $this->resmenu;
	}
}
