<?php namespace App\Http\Controllers;

use App\Company;
use App\Menu;
use App\Category;
use App\Partner;
use App\Article;
use App\Product;
use App\Language;
use App\User;
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
use File;
use Illuminate\Http\Request;
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

	public function index1()
	{
		//do something
		#check login here
		# Code....
		return view('admin.auth.login');
	}

	/*--------------------------------- [ARTICLE]---------------------------------*/
	/**
	 * Show the form articles [index].
	 *
	 * @return Response
	 */
	public function articles()
	{
		//get all
		$title = 'Article';
		$arts = Article::getAll();
		
		return view('admin.articles.index')->with([
				'msg' => $this->msg,
				'title' => $title,
				'arts' 	=> $arts
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
	
	/*--------------------------------- [PRODUCT]---------------------------------*/
	/**
	 * Show the form Product [index].
	 *
	 * @return Response
	 */
	public function products()
	{
		//get all
		$title = 'Product';
		$obj = Product::getAll();
		
		return view('admin.products.index')->with([
				'msg' => $this->msg,
				'title' => $title,
				'obj' 	=> $obj
			]);
	}

	/**
	 * Show the form products [index].
	 *
	 * @return Response
	 */
	public function productsSearch()
	{
		$title = 'Product [Search]';
		$parent = 'Product';
		$kw = Input::get('keyword');
		
		$obj = Product::getSearch($kw);
		return view('admin.products.search')->with([
				'msg' => $this->msg,
				'title' => $title,
				'parent' => $parent,
				'obj' 	=> $obj,
				'kw' 	=> $kw
			]);
	}

	/**
	 * Add new products [add].
	 *
	 * @return Response
	 */
	public function productsDetail($id)
	{
		$title = 'Product [Detail]';

		$obj = Product::readDetail($id);
		$obj_en = Language::read($id,'products','en');
		$obj_ja = Language::read($id,'products','ja');
		$obj_seo = Seo::read($id);
		return view('admin.products.detail')->with([
				'title' => $title,
				'obj' => $obj,
				'obj_en' => $obj_en,
				'obj_ja' => $obj_ja,
				'obj_seo' => $obj_seo
		]);
	}

	/**
	 * Add new products [add].
	 *
	 * @return Response
	 */
	public function productsAdd()
	{
		$title = 'Product [Add]';
		$parent = 'Product';
		//Get List categories
		$cate = Category::getLstCategoriesVi();
		return view('admin.products.add')->with([
				'msg' => $this->msg,
				'title' => $title,
				'parent' => $parent,
				'cate' => $cate
		]);
	}

	public function productsAdd_sm()
	{
		$v = Product::validate(Input::all());
		if ( $v->passes() ) {
			//Alias name vi 
			$alias = mb_strtolower(Registrar::removesign(Input::get('name')));
			//Alias name en 
			$alias_en = mb_strtolower(Registrar::removesign(Input::get('title_en')));
			//Alias name ja 
			$alias_ja = mb_strtolower(Registrar::removesign(Input::get('title_ja')));

			//Array Article
			$dataVi = ([
				'alias' => $alias,
				'name' => Input::get('name'),
				'img' => '',//Input::file('image'),
				'list_img' => '', //-------------- dùng Jquery get sau
				'desc' => Input::get('desc'),
				'note' => Input::get('note'),
				'category_id' => Input::get('category_id'),
				'created_at' => Carbon::now(),
				'cutomer' => Input::get('cutomer')
				]);
			//Array Lang
			$dataLang = ([[
				'item_id' => '',
				'alias' => $alias_en, 
				'table_name' => 'products',
				'lang' => 'en', 
				'name' => Input::get('title_en'),
				'img' => '', //-------------------------------------> get sau khi đã tạo form
				'desc' => Input::get('desc_en'),
				'fulltext' => Input::get('fulltext_en')
				],
				[
				'item_id' => '',
				'alias' => $alias_ja, 
				'table_name' => 'products',
				'lang' => 'ja', 
				'name' => Input::get('title_ja'),
				'img' => '', //-------------------------------------> get sau khi đã tạo form
				'desc' => Input::get('desc_ja'),
				'fulltext' => Input::get('fulltext_ja')
				]
				]);
			$products = new Product();
			$res = $products->Insert($dataVi, $dataLang);
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
				return redirect()->action('AdminController@productsAdd');
			else return redirect()->action('AdminController@products');
		}
		 else {
		 	Input::flash();
            return redirect()->action('AdminController@productsAdd')->withErrors( $v->getMessageBag());
        }
	}

	/**
	 * Edit an products [Edit].
	 *
	 * @return Response
	 */
	public function productsEdit($id)
	{
		$title = 'Product [Edit]';
		$parent = 'Product';

		$obj = Product::read($id);
		$obj_en = Language::read($id,'products','en');
		$obj_ja = Language::read($id,'products','ja');
		//Get List categories
		$cate = Category::getLstCategoriesVi();

		return view('admin.products.edit')->with([
				'msg' => $this->msg,
				'title' => $title,
				'parent' => $parent,
				'cate' => $cate,
				'obj' => $obj,
				'obj_en' => $obj_en,
				'obj_ja' => $obj_ja
		]);
	}

	public function productsEdit_sm()
	{
		$id = Input::get('id');
		$v = Product::validate(Input::all());
		if ( $v->passes() ) {
			//Alias name vi 
			$alias = mb_strtolower(Registrar::removesign(Input::get('name')));
			//Alias name en 
			$alias_en = mb_strtolower(Registrar::removesign(Input::get('title_en')));
			//Alias name ja 
			$alias_ja = mb_strtolower(Registrar::removesign(Input::get('title_ja')));

			//Array Article
			$dataVi = ([
				'alias' => $alias,
				'name' => Input::get('name'),
				'img' => '',//Input::file('image'),
				'list_img' => '', //-------------- dùng Jquery get sau
				'desc' => Input::get('desc'),
				'note' => Input::get('note'),
				'category_id' => Input::get('category_id'),
				'updated_at' => Carbon::now(),
				'cutomer' => Input::get('cutomer')
				]);
			//Array Lang
			$dataLang = ([[
				'item_id' => $id,
				'alias' => $alias_en, 
				'table_name' => 'products',
				'lang' => 'en', 
				'name' => Input::get('title_en'),
				'img' => '', //-------------------------------------> get sau khi đã tạo form
				'desc' => Input::get('desc_en'),
				'fulltext' => Input::get('fulltext_en')
				],
				[
				'item_id' => $id,
				'alias' => $alias_ja, 
				'table_name' => 'products',
				'lang' => 'ja', 
				'name' => Input::get('title_ja'),
				'img' => '', //-------------------------------------> get sau khi đã tạo form
				'desc' => Input::get('desc_ja'),
				'fulltext' => Input::get('fulltext_ja')
				]
				]);

			$products = new Product();
			$res = $products->_Update($dataVi, $dataLang, $id);
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
			return redirect()->action('AdminController@products');
		}
		 else {
			return redirect()->action('AdminController@productsEdit', [$id])
			->withErrors( $v->getMessageBag());;
        }
	}

	/**
	 * Delete products [Delete].
	 *
	 * @return Response
	 */
	public function productsDel($id)
	{
		$res = Product::Del($id);
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
		//return Redirect::to('admin/products/');
	}

	public function productsMutiDel()
	{
		$arr_id = Input::get('item');
		//tao string hung name bai viet khong the xoa
		$str = '';
		if (is_array($arr_id))
		{
			foreach ($arr_id as $id) {
				# check relasionship here
					# code sau...
				# Read products
				$obj = Product::read($id);
				# Del database
				$res = Product::Del($id);
				#Kiem tra sau khi xoa
				if (!$res) {
					$str .= $obj['name'] . ', ';
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

	/*--------------------------------- [CATEGORIES]---------------------------------*/
	/**
	 * Show the form Product [index].
	 *
	 * @return Response
	 */
	public function categories()
	{
		//get all
		$title = 'Category';
		$obj = Category::getAll();
		
		return view('admin.categories.index')->with([
				'msg' => $this->msg,
				'title' => $title,
				'obj' 	=> $obj
			]);
	}

	/**
	 * Add new products [add].
	 *
	 * @return Response
	 */
	public function categoriesAdd()
	{
		$title = 'Category [Add]';
		$parent = 'Category';
		//Get List categories
		return view('admin.categories.add')->with([
				'msg' => $this->msg,
				'title' => $title,
				'parent' => $parent
		]);
	}

	public function categoriesAdd_sm()
	{
		$v = Category::validate(Input::all());
		if ( $v->passes() ) {
			//Alias name vi 
			$alias = mb_strtolower(Registrar::removesign(Input::get('title')));
			//Alias name en 
			$alias_en = mb_strtolower(Registrar::removesign(Input::get('title_en')));
			//Alias name ja 
			$alias_ja = mb_strtolower(Registrar::removesign(Input::get('title_ja')));

			//Array Category
			$dataVi = ([
				'alias' => $alias,
				'name' => Input::get('title'),
				'desc' => Input::get('desc'),
				'logo' => ''
				]);
			//Array Lang
			$dataLang = ([[
				'item_id' => '',
				'alias' => $alias_en, 
				'table_name' => 'categories',
				'lang' => 'en', 
				'name' => Input::get('title_en'),
				'img' => '', //-------------------------------------> get sau khi đã tạo form
				'desc' => Input::get('desc_en')
				],
				[
				'item_id' => '',
				'alias' => $alias_ja, 
				'table_name' => 'categories',
				'lang' => 'ja', 
				'name' => Input::get('title_ja'),
				'img' => '', //-------------------------------------> get sau khi đã tạo form
				'desc' => Input::get('desc_ja')
				]
				]);
			$categories = new Category();
			$res = $categories->Insert($dataVi, $dataLang);
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
				return redirect()->action('AdminController@categoriesAdd');
			else return redirect()->action('AdminController@categories');
		}
		 else {
		 	Input::flash();
            return redirect()->action('AdminController@categoriesAdd')->withErrors( $v->getMessageBag());
        }
	}

	/**
	 * Edit an products [Edit].
	 *
	 * @return Response
	 */
	public function categoriesEdit($id)
	{
		$title = 'Category [Edit]';
		$parent = 'Category';

		$obj = Category::read($id);
		$obj_en = Language::read($id,'categories','en');
		$obj_ja = Language::read($id,'categories','ja');

		return view('admin.categories.edit')->with([
				'msg' => $this->msg,
				'title' => $title,
				'parent' => $parent,
				'obj' => $obj,
				'obj_en' => $obj_en,
				'obj_ja' => $obj_ja
		]);
	}

	public function categoriesEdit_sm()
	{
		$id = Input::get('id');
		$v = Category::validate(Input::all());
		if ( $v->passes() ) {
			//Alias name vi 
			$alias = mb_strtolower(Registrar::removesign(Input::get('title')));
			//Alias name en 
			$alias_en = mb_strtolower(Registrar::removesign(Input::get('title_en')));
			//Alias name ja 
			$alias_ja = mb_strtolower(Registrar::removesign(Input::get('title_ja')));

			//Array Category
			$dataVi = ([
				'alias' => $alias,
				'name' => Input::get('title'),
				'desc' => Input::get('desc'),
				'logo' => ''
				]);
			//Array Lang
			$dataLang = ([[
				'item_id' => $id,
				'alias' => $alias_en, 
				'table_name' => 'categories',
				'lang' => 'en', 
				'name' => Input::get('title_en'),
				'img' => '', //-------------------------------------> get sau khi đã tạo form
				'desc' => Input::get('desc_en')
				],
				[
				'item_id' => $id,
				'alias' => $alias_ja, 
				'table_name' => 'categories',
				'lang' => 'ja', 
				'name' => Input::get('title_ja'),
				'img' => '', //-------------------------------------> get sau khi đã tạo form
				'desc' => Input::get('desc_ja')
				]
				]);
			$categories = new Category();
			$res = $categories->_Update($dataVi, $dataLang, $id);
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
			return redirect()->action('AdminController@categories');
		}
		 else {
			return redirect()->action('AdminController@categoriesEdit', [$id])
			->withErrors( $v->getMessageBag());;
        }
	}

	/**
	 * Delete products [Delete].
	 *
	 * @return Response
	 */
	public function categoriesDel($id)
	{
		#check relationship
		$art = Category::find($id)->article;
		$pro = Category::find($id)->product;
		if(count($art) == 0 && count($pro) == 0)
		{
			$category = new Category();
			$obj = $category->read($id);
			$obj_lang = Language::read2($id, 'categories');
			#Remove Image 
			if($obj->logo != '' && File::exists($category->getUrl().'/'.$obj->logo))
				unlink($category->getUrl().'/'.$obj->logo);
			foreach ($obj_lang as $v) {
				if($v->img != '' && File::exists($category->getUrl().'/'.$v->img))
				unlink($category->getUrl().'/'.$v->img);
			}
			#Del Database
			$res = $category->Del($id);
			if(!$res){
				$msg = array(
					'type_msg' =>'danger',
					'msg' =>'Lỗi! Đã có lỗi trong quá trình xóa.'
					);
			}
			else{
				$msg = array(
					'type_msg' =>'success',
					'msg' =>'Thành công! Dữ liệu đã được xóa.'
					);
			}
		}else $msg = array(
					'type_msg' =>'warning',
					'msg' =>'Không thể xóa! Tồn tại dữ liệu liên quan.'
					);
		session($msg);
		return Redirect::back();
	}

	public function categoriesMutiDel()
	{
		$arr_id = Input::get('item');
		//tao string hung name bai viet khong the xoa
		$str = '';
		if (is_array($arr_id))
		{
			foreach ($arr_id as $id) {
				#check relationship
				$art = Category::find($id)->article;
				$pro = Category::find($id)->product;

				if(count($art) == 0 && count($pro) == 0)
				{
					# Del database
					$category = new Category();
					$obj = $category->read($id);
					$obj_lang = Language::read2($id, 'categories');
					#Remove Image 
					if($obj->logo != '' && File::exists($category->getUrl().'/'.$obj->logo))
						unlink($category->getUrl().'/'.$obj->logo);
					foreach ($obj_lang as $v) {
						if($v->img != '' && File::exists($category->getUrl().'/'.$v->img))
						unlink($category->getUrl().'/'.$v->img);
					}
					#Del Database
					$res = $category->Del($id);
				}else{
					$str .= $obj['name'] . ', ';
					continue;
				}
			}
		}
		#Kiem tra sau khi xoa
		if(!$str == ''){
			$msg = array(
				'type_msg' =>'warning',
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

	/*--------------------------------- [MENUS]---------------------------------*/
	/**
	 * Show the form Memu [index].
	 *
	 * @return Response
	 */
	public function menus()
	{
		//get all
		$title = 'Menu';
		$obj = Menu::getAll();
		$_obj = Menu::_getAll();
		return view('admin.menus.index')->with([
				'msg' => $this->msg,
				'title' => $title,
				'obj' 	=> $obj,
				'_obj' 	=> $_obj
			]);
	}

	/**
	 * Add new products [add].
	 *
	 * @return Response
	 */
	public function menusAdd()
	{
		$title = 'Menu [Add]';
		$parent = 'Menu';
		//Get List menus
		$menu = $this->printLstMenuVi(Menu::getMenuVi(),0, '-');
		return view('admin.menus.add')->with([
				'msg' => $this->msg,
				'title' => $title,
				'parent' => $parent,
				'menu' => $menu
		]);
	}

	public function menusAdd_sm()
	{
		$v = Menu::validate(Input::all());
		if ( $v->passes() ) {
			//Alias name vi 
			$alias = mb_strtolower(Registrar::removesign(Input::get('title')));
			//Alias name en 
			$alias_en = mb_strtolower(Registrar::removesign(Input::get('title_en')));
			//Alias name ja 
			$alias_ja = mb_strtolower(Registrar::removesign(Input::get('title_ja')));

			//Array Category
			$dataVi = ([
				'alias' => $alias,
				'name' => Input::get('title'),
				'parent_id' => Input::get('parent_id'),
				'position' => Input::get('position')
				]);
			//Array Lang
			$dataLang = ([[
				'item_id' => '',
				'alias' => $alias_en, 
				'table_name' => 'menus',
				'lang' => 'en', 
				'name' => Input::get('title_en')
				],
				[
				'item_id' => '',
				'alias' => $alias_ja, 
				'table_name' => 'menus',
				'lang' => 'ja', 
				'name' => Input::get('title_ja')
				]
				]);
			$menu = new Menu();
			$res = $menu->Insert($dataVi, $dataLang);
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
				return redirect()->action('AdminController@menusAdd');
			else return redirect()->action('AdminController@menus');
		}
		 else {
		 	Input::flash();
            return redirect()->action('AdminController@menusAdd')->withErrors( $v->getMessageBag());
        }
	}

	/**
	 * Edit an products [Edit].
	 *
	 * @return Response
	 */
	public function menusEdit($id)
	{
		$title = 'Menu [Edit]';
		$parent = 'Menu';

		$obj = Menu::read($id);
		$obj_en = Language::read($id,'menus','en');
		$obj_ja = Language::read($id,'menus','ja');
		$menu = $this->printLstMenuViEdit(Menu::getMenuVi(),0, '-',$obj->parent_id);

		return view('admin.menus.edit')->with([
				'msg' => $this->msg,
				'title' => $title,
				'parent' => $parent,
				'menu' => $menu,
				'obj' => $obj,
				'obj_en' => $obj_en,
				'obj_ja' => $obj_ja
		]);
	}

	public function menusEdit_sm()
	{
		$id = Input::get('id');
		$v = Menu::validate(Input::all());
		if ( $v->passes() ) {
			//Alias name vi 
			$alias = mb_strtolower(Registrar::removesign(Input::get('title')));
			//Alias name en 
			$alias_en = mb_strtolower(Registrar::removesign(Input::get('title_en')));
			//Alias name ja 
			$alias_ja = mb_strtolower(Registrar::removesign(Input::get('title_ja')));

			//Array Menu
			$dataVi = ([
				'alias' => $alias,
				'name' => Input::get('title'),
				'parent_id' => Input::get('parent_id'),
				'position' => Input::get('position')
				]);
			//Array Lang
			$dataLang = ([[
				'item_id' => $id,
				'alias' => $alias_en, 
				'table_name' => 'menus',
				'lang' => 'en', 
				'name' => Input::get('title_en')
				],
				[
				'item_id' => $id,
				'alias' => $alias_ja, 
				'table_name' => 'menus',
				'lang' => 'ja', 
				'name' => Input::get('title_ja')
				]
				]);
			$menu = new Menu();
			$res = $menu->_Update($dataVi, $dataLang, $id);
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
			return redirect()->action('AdminController@menus');
		}
		 else {
			return redirect()->action('AdminController@menusEdit', [$id])
			->withErrors( $v->getMessageBag());;
        }
	}

	/**
	 * Delete products [Delete].
	 *
	 * @return Response
	 */
	public function menusDel($id)
	{
		#check relationship
		$art = Menu::find($id)->article;
		if(count($art) == 0)
		{
			$menu = new Menu();
			$obj = $menu->read($id);
			#Del Database
			$res = $menu->Del($id);
			if(!$res){
				$msg = array(
					'type_msg' =>'danger',
					'msg' =>'Lỗi! Đã có lỗi trong quá trình xóa.'
					);
			}
			else{
				$msg = array(
					'type_msg' =>'success',
					'msg' =>'Thành công! Dữ liệu đã được xóa.'
					);
			}
		}else $msg = array(
					'type_msg' =>'warning',
					'msg' =>'Không thể xóa! Tồn tại dữ liệu liên quan.'
					);
		session($msg);
		return Redirect::back();
	}

	public function menusMutiDel()
	{
		$arr_id = Input::get('item');
		//tao string hung name bai viet khong the xoa
		$str = '';
		if (is_array($arr_id))
		{
			foreach ($arr_id as $id) {
				#check relationship
				$art = Menu::find($id)->article;
				$obj = Menu::read($id);
				if(count($art) == 0)
				{
					# Del database
					$menu = new Menu();
					
					#Del Database
					$res = $menu->Del($id);
				}else{
					$str .= $obj['name'] . ', ';
					continue;
				}
			}
		}
		#Kiem tra sau khi xoa
		if(!$str == ''){
			$msg = array(
				'type_msg' =>'warning',
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

	/*--------------------------------- [PUBLIC]---------------------------------*/
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





	/*-----------------User------------------*/

	public function users()
	{
		$title = 'User';
		$users = User::getAll();
		return view('admin.users.index')->with([
				'msg' 	=> $this->msg,
				'title' => $title,
				'users' => $users
			]);
	}

	public function usersAdd()
	{
		$title = 'User [Add]';
		$parent = 'User';
		//Get List categories
		//$cate = Category::getLstCategoriesVi();
		return view('admin.users.add')->with([ //
				'msg' => $this->msg,
				'title' => $title,
				'parent' => $parent
		]);
	}

	public function addUser_act(Request $request)
	{
		$data_user = array(
			'name' => $request->name,
			'email' => $request->email,
			'password' => $request->password,
			'created_at' => Carbon::now()
			);
		$vali = User::validation($data_user);
		if ($vali->passes())
		{
			if (!User::checkExited($request->email,0)){ //check email
				$result = User::insert($data_user); //---insert

				if(!$result){
					$msg = array(
						'type_msg' =>'danger',
						'msg' =>'Lỗi! Đã có lỗi xảy ra trong quá trình thêm'
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
					return redirect()->action('AdminController@usersAdd');
				else return redirect()->action('AdminController@users');
			//insert
			} else{
				$msg = array(
						'type_msg' =>'warning',
						'msg' =>'Cảnh báo! Địa chỉ Email đã tồn tại'
						);
				session($msg);
				return redirect()->action('AdminController@users');
			}
			
		} 
		else 
		{
			Input::flash();
            return redirect()->action('AdminController@usersAdd')->withErrors( $vali->getMessageBag());
		}
	}

	public function usersDel($id)
	{
		$result = User::del($id);
		if (!$result){
			$msg = array(
				'type_msg' => 'danger',
				'msg' => 'Lỗi! Đã có lỗi xảy ra trong quá trình xóa dữ liệu');
		} else{
			$msg = array(
				'type_msg' => 'success',
				'msg' => 'Thành công! Dữ liệu đã được xóa.');
		}
		session($msg);
		return redirect()->action('AdminController@users');
	}

	public function usersEdit($id)
	{
		$title = 'User [Edit]';
		$user = User::getuser($id);
		$parent = 'User';
		return view('admin.users.edit')->with([
			'msg' => $this->msg,
			'title' => $title,
			'parent' => $parent,
			'user' => $user
			]);
	}

	public function usersEdit_act(Request $request)
	{
		$data_user = array(
			'id' => $request->id,
			'name' => $request->name,
			'email' => $request->email,
			'password' => $request->password,
			'updated_adt' => Carbon::now()
			);
		$vali = User::validation($data_user);
		if ($vali->passes())
		{
			if (!User::checkExited($request->email,$request->id)) //check email
			{
				$result = User::upda($data_user);

			// câu lệnh if else nếu email có sự trùng lặp
				if(!$result){
					$msg = array(
						'type_msg' =>'danger',
						'msg' =>'Lỗi! Đã có lỗi xảy ra trong quá trình cập nhật dữ liệu'
						);
				}
				else{
					$msg = array(
						'type_msg' =>'success',
						'msg' =>'Thành công! Dữ liệu đã được cập nhật')
					;
				}
				session($msg);

				// return Redirect::back();
				return redirect()->action('AdminController@users');
				//insert
			} else{
					$msg = array(
							'type_msg' =>'warning',
							'msg' =>'Cảnh báo! Địa chỉ Email đã tồn tại'
							);
					session($msg);
					return redirect()->action('AdminController@users');
			}
		} 
		else 
		{
			Input::flash();
            return redirect()->action('AdminController@usersEdit')->withErrors( $vali->getMessageBag());
		}
	}





	/*****************Partner**********************/


	/*
	*get all partner
	*
	*/
	public function partners()
	{
		$title = 'Partners';
		$partners = Partner::getAll();
		return view('admin.partners.index')->with([
				'msg' 	=> $this->msg,
				'title' => $title,
				'partners'=>$partners
			]);
	}

	/*
	*view add partner
	*
	*/
	public function partnersAdd()
	{
		$title = 'Partner [Add]';
		$parent = 'Partner';
		return view('admin.partners.add')->with([ //
				'msg' => $this->msg,
				'title' => $title,
				'parent' => $parent
		]);
	}

	/*
	*add partner
	*
	*/
	public function addPartner_act(Request $request)
	{
		$data_partner = array(
			'name' => $request->name,
			'url' => $request->url,
			'logo' => ''
			);
		$vali = Partner::validation($data_partner);
		if ($vali->passes())
		{
			if (!Partner::checkExited($request->name,0)){ //check email
				$par = new Partner();
				$result = $par->insert($data_partner); //---insert

				if(!$result){
					$msg = array(
						'type_msg' =>'danger',
						'msg' =>'Lỗi! Đã có lỗi xảy ra trong quá trình thêm'
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
					return redirect()->action('AdminController@partnersAdd');
				else return redirect()->action('AdminController@partners');
			//insert
			} else{
				$msg = array(
						'type_msg' =>'warning',
						'msg' =>'Cảnh báo! Đối tác đã tồn tại'
						);
				session($msg);
				return redirect()->action('AdminController@partners');
			}
			
		} 
		else 
		{
			Input::flash();
            return redirect()->action('AdminController@partnersAdd')->withErrors( $vali->getMessageBag());
		}
	}


	/*
	*delete simple
	*
	*/
	public function partnersDel($id)
	{
		$result = Partner::del($id);
		if (!$result){
			$msg = array(
				'type_msg' => 'danger',
				'msg' => 'Lỗi! Đã có lỗi xảy ra trong quá trình xóa dữ liệu');
		} else{
			$msg = array(
				'type_msg' => 'success',
				'msg' => 'Thành công! Dữ liệu đã được xóa.');
		}
		session($msg);
		return redirect()->action('AdminController@partners');
	}


	/*
	*Delete Multi partners
	*
	*/
	public function partnersMutiDel(Request $request)
	{
		$array_id = $request->get('item');
		$str = '';
		if (is_array($array_id))
		{
			$str = Partner::delMulti($array_id);
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


	/*
	*get infomation for view
	*
	*/
	public function partnersEdit($id)
	{
		$title = 'Parnert [Edit]';
		$partner = Partner::getpartner($id);
		$parent = 'Parnert';
		return view('admin.partners.edit')->with([
			'msg' => $this->msg,
			'title' => $title,
			'parent' => $parent,
			'partner' => $partner
			]);
	}

	/*
	*Edit partner action
	*
	*/
	public function partnersEdit_act(Request $request)
	{
		$data_partner = array(
			'id' => $request->id,
			'name' => $request->name,
			'url' => $request->url,
			'logo' => $request->logo
			);
		$vali = Partner::validation($data_partner);
		if ($vali->passes())
		{
			if (!Partner::checkExited($request->name,$request->id)) //check email
			{
				$part = new Partner();
				$result = $part->upda($data_partner);//---------updated

				if(!$result){
					$msg = array(
						'type_msg' =>'danger',
						'msg' =>'Lỗi! Đã có lỗi xảy ra trong quá trình cập nhật dữ liệu'
						);
				}
				else{
					$msg = array(
						'type_msg' =>'success',
						'msg' =>'Thành công! Dữ liệu đã được cập nhật')
					;
				}
				session($msg);

				return redirect()->action('AdminController@partners');
			} else{
					$msg = array(
							'type_msg' =>'warning',
							'msg' =>'Cảnh báo! Địa chỉ Email đã tồn tại'
							);
					session($msg);
					return redirect()->action('AdminController@partners');
			}
		} 
		else 
		{
			Input::flash();
            return redirect()->action('AdminController@partnersAdd')->withErrors( $vali->getMessageBag());
		}
	}




	/************Companies**************/

	/*
	*
	*
	*/
	public function company()
	{
		$title = 'Company';
		$companies = Company::getAll();
		return view('admin.companies.index')->with([
				'msg' 	=> $this->msg,
				'title' => $title,
				'companies'=>$companies
			]);
	}

	public function companyEdit($id)
	{
		$companies = Company::getcompany($id);
		if ($companies[0]->lang=='vi'){
			$title = 'Company [Edit] Tiếng Việt';
		}
		if ($companies[0]->lang=='en'){
			$title = 'Company [Edit] Tiếng Anh';
		}
		if ($companies[0]->lang=='ja'){
			$title = 'Company [Edit] Tiếng Nhật';
		}
		$parent = 'Company';
		return view('admin.companies.edit')->with([
			'msg' => $this->msg,
			'title' => $title,
			'parent' => $parent,
			'companies' => $companies
			]);
	}

	public function companyEdit_act(Request $request)
	{
		$data_company = array(
			'id' 		=> $request->id,
			'name' 		=> $request->name,
			'title' 	=> $request->title,
			'director' 	=> $request->director,
			'address' 	=> $request->address,
			'phone'		=> $request->phone,
			'fax'		=> $request->fax,
			'email'		=> $request->email,
			'skype'		=> $request->skype,
			'copyright'	=> $request->copyright
			);
		$vali = Company::validation($data_company);
		if ($vali->passes())
		{
			$result = Company::upda($data_company);//---------updated
			if(!$result){
				$msg = array(
					'type_msg' =>'danger',
					'msg' =>'Lỗi! Đã có lỗi xảy ra trong quá trình cập nhật dữ liệu'
					);
			}
			else{
				$msg = array(
					'type_msg' =>'success',
					'msg' =>'Thành công! Dữ liệu đã được cập nhật')
				;
			}
			session($msg);
			return redirect()->action('AdminController@company');
		} 
		else 
		{
			Input::flash();
            return redirect()->action('AdminController@companyEdit',$request->id)->withErrors( $vali->getMessageBag());
		}
	}
	public function location()
	{
		$title = 'Location [Edit]';
		$parent = 'Company';
		$location = Company::getlocation();
		return view('admin.companies.location')->with([
				'msg' 	=> $this->msg,
				'title' => $title,
				'parent' => $parent,
				'location'=> $location
			]);
	}


	public function locationEdit_act(Request $request)
	{
		$data_location = array(
			'id' => $request->id,
			'latitude' => $request->latitude,
			'longitude' => $request->longitude
			);
				$result = Company::updatelocation($data_location);//---------updated

				if(!$result){
					$msg = array(
						'type_msg' =>'danger',
						'msg' =>'Lỗi! Đã có lỗi xảy ra trong quá trình cập nhật dữ liệu'
						);
				}
				else{
					$msg = array(
						'type_msg' =>'success',
						'msg' =>'Thành công! Dữ liệu đã được cập nhật')
					;
				}
				session($msg);
		$title = 'Location [Edit]';
		$parent = 'Company';
		$location = Company::getlocation();
		return view('admin.companies.location')->with([
			'msg' 	=> $this->msg,
			'title' => $title,
			'parent' => $parent,
			'location'=> $location
		]);
		
	}
}
