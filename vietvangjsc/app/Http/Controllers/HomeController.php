<?php namespace App\Http\Controllers;

use App\Company;
use App\Menu;
use App\Category;
use App\Partner;
use App\Article;
use App\Product;
use Session;
use Cookie;
use Input;
use Mail;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
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
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index($lang='vi')
	{
		//get company info
		$company = Company::getCompany($lang);
		//get menu
		$menu = Menu::getMenu($lang, '0');
		//get submenu
		$subMenu = Menu::getMenu($lang, '2');
		//get category
		$categories = Category::getCategories($lang);
		//get partners
		$partners = Partner::getPartners($lang);
		//get hit news
		$hitNew = Article::getHitNews($lang);
		//get news
		$news = Article::getNews($lang, 9, 2);
		return view('home')->with([
				'company' 	=> $company,
				'menu'		=> $menu,
				'subMenu'	=> $subMenu,
				'categories'=> $categories,
				'partners'	=> $partners,
				'hitNew'	=> $hitNew,
				'news'		=> $news,
				'lang'		=> $lang
			]);
	}

	public function showGreeting($lang="vi"){
		//get company info
		$company = Company::getCompany($lang);
		//get menu
		$menu = Menu::getMenu($lang, '0');
		//get submenu
		$subMenu = Menu::getMenu($lang, '2');
		//get info menu
		$info = Article::getNews($lang, 3, 1);
		return view('greeting')->with([
				'company' 	=> $company,
				'menu'		=> $menu,
				'subMenu'	=> $subMenu,
				'info'		=> $info,
				'lang'		=> $lang
			]);
	}

	public function showOverview($lang="vi"){
		//get company info
		$company = Company::getCompany($lang);
		//get menu
		$menu = Menu::getMenu($lang, '0');
		//get submenu
		$subMenu = Menu::getMenu($lang, '2');
		//get info menu
		$info = Article::getNews($lang, 4, 1);
		return view('overview')->with([
				'company' 	=> $company,
				'menu'		=> $menu,
				'subMenu'	=> $subMenu,
				'info'		=> $info,
				'lang'		=> $lang
			]);
	}

	public function showToolToUse($lang="vi"){
		//get company info
		$company = Company::getCompany($lang);
		//get menu
		$menu = Menu::getMenu($lang, '0');
		//get submenu
		$subMenu = Menu::getMenu($lang, '2');
		//get info menu
		$info = Article::getNews($lang, 5, 1);
		return view('toolToUse')->with([
				'company' 	=> $company,
				'menu'		=> $menu,
				'subMenu'	=> $subMenu,
				'info'		=> $info,
				'lang'		=> $lang
			]);
	}

	public function showWorkingProcess($lang="vi"){
		//get company info
		$company = Company::getCompany($lang);
		//get menu
		$menu = Menu::getMenu($lang, '0');
		//get submenu
		$subMenu = Menu::getMenu($lang, '2');
		//get info menu
		$info = Article::getNews($lang, 6, 1);
		return view('workingProcess')->with([
				'company' 	=> $company,
				'menu'		=> $menu,
				'subMenu'	=> $subMenu,
				'info'		=> $info,
				'lang'		=> $lang
			]);
	}

	public function showResourceEducation($lang="vi"){
		//get company info
		$company = Company::getCompany($lang);
		//get menu
		$menu = Menu::getMenu($lang, '0');
		//get submenu
		$subMenu = Menu::getMenu($lang, '2');
		//get info menu
		$info = Article::getNews($lang, 7, 1);
		return view('resourceEducation')->with([
				'company' 	=> $company,
				'menu'		=> $menu,
				'subMenu'	=> $subMenu,
				'info'		=> $info,
				'lang'		=> $lang
			]);
	}

	public function showProducts($categoryName = '', $category='0', $lang="vi"){
		//get company info
		$company = Company::getCompany($lang);
		//get menu
		$menu = Menu::getMenu($lang, '0');
		//get submenu
		$subMenu = Menu::getMenu($lang, '2');
		//get category
		$categories = Category::getCategories($lang);
		//get products
		$products = Product::getProducts($lang, $category);
		return view('products')->with([
				'company' 	=> $company,
				'menu'		=> $menu,
				'subMenu'	=> $subMenu,
				'categories'=> $categories,
				'products'	=> $products,
				'lang'		=> $lang
			]);
	}

	public function showAllProducts($lang="vi"){
		//get company info
		$company = Company::getCompany($lang);
		//get menu
		$menu = Menu::getMenu($lang, '0');
		//get submenu
		$subMenu = Menu::getMenu($lang, '2');
		//get category
		$categories = Category::getCategories($lang);
		//get all products
		$products = Product::getProducts($lang, '0');
		return view('products')->with([
				'company' 	=> $company,
				'menu'		=> $menu,
				'subMenu'	=> $subMenu,
				'categories'=> $categories,
				'products'	=> $products,
				'lang'		=> $lang
			]);
	}

	public function showProduct($productName = '', $productId='0', $lang="vi"){
		//get company info
		$company = Company::getCompany($lang);
		//get menu
		$menu = Menu::getMenu($lang, '0');
		//get submenu
		$subMenu = Menu::getMenu($lang, '2');
		//get category
		$categories = Category::getCategories($lang);
		//get all products
		$product = Product::getProduct($productId, $lang);
		return view('product')->with([
				'company' 	=> $company,
				'menu'		=> $menu,
				'subMenu'	=> $subMenu,
				'categories'=> $categories,
				'product'	=> $product,
				'lang'		=> $lang
			]);
	}

	public function showNews($lang){
		//get company info
		$company = Company::getCompany($lang);
		//get menu
		$menu = Menu::getMenu($lang, '0');
		//get submenu
		$subMenu = Menu::getMenu($lang, '2');
		//get news
		$news = Article::getNews($lang, '9', 10);
		return view('news')->with([
				'company' 	=> $company,
				'menu'		=> $menu,
				'subMenu'	=> $subMenu,
				'news'		=> $news,
				'lang'		=> $lang,
			]);
	}

	public function showNew($newName='', $newId='0', $lang='vi'){
		//get company info
		$company = Company::getCompany($lang);
		//get menu
		$menu = Menu::getMenu($lang, '0');
		//get submenu
		$subMenu = Menu::getMenu($lang, '2');
		//get new
		$new = Article::getNew($lang, $newId, '9');
		//get other
		$otherNew = Article::getOther($lang, $newId, '9');
		return view('new')->with([
				'company' 	=> $company,
				'menu'		=> $menu,
				'subMenu'	=> $subMenu,
				'new'		=> $new,
				'otherNew'	=> $otherNew,
				'lang'		=> $lang
			]);
	}

	public function showForStaff($lang){
		//get company info
		$company = Company::getCompany($lang);
		//get menu
		$menu = Menu::getMenu($lang, '0');
		//get submenu
		$subMenu = Menu::getMenu($lang, '2');
		//get new
		$new = Article::getNews($lang, '10', '1');
		return view('forStaff')->with([
				'company' 	=> $company,
				'menu'		=> $menu,
				'subMenu'	=> $subMenu,
				'new'		=> $new,
				'lang'		=> $lang
			]);
	}

	public function showRecruitments($lang){
		//get company info
		$company = Company::getCompany($lang);
		//get menu
		$menu = Menu::getMenu($lang, '0');
		//get submenu
		$subMenu = Menu::getMenu($lang, '2');
		//get new
		$news = Article::getNews($lang, '11', '1');
		//blag title
		$blag = '1';
		return view('news')->with([
				'company' 	=> $company,
				'menu'		=> $menu,
				'subMenu'	=> $subMenu,
				'news'		=> $news,
				'lang'		=> $lang,
				'blag'		=> $blag
			]);
	}

	public function showRecruitment($newName='', $newId='0', $lang='vi'){
		//get company info
		$company = Company::getCompany($lang);
		//get menu
		$menu = Menu::getMenu($lang, '0');
		//get submenu
		$subMenu = Menu::getMenu($lang, '2');
		//get new
		$new = Article::getNew($lang, $newId, '11');
		//get other
		$otherNew = Article::getOther($lang, $newId, '11');
		return view('new')->with([
				'company' 	=> $company,
				'menu'		=> $menu,
				'subMenu'	=> $subMenu,
				'new'		=> $new,
				'otherNew'	=> $otherNew,
				'lang'		=> $lang
			]);
	}

	public function showContactUs($lang="vi"){
		//get company info
		$company = Company::getCompany($lang);
		//get menu
		$menu = Menu::getMenu($lang, '0');
		//get submenu
		$subMenu = Menu::getMenu($lang, '2');
		return view('contactUs')->with([
				'company' 	=> $company,
				'menu'		=> $menu,
				'subMenu'	=> $subMenu,
				'lang'		=> $lang
			]);
	}

	public function sendEmail(){
		$name = Input::get('name');
		$company = Input::get('company');
		$position = Input::get('position');
		$phone = Input::get('phone');
		$email = Input::get('email');
		$content = Input::get('description');
		$service = Input::get('services');
		$data = array(
			'fullname' 	=> $name,
			'company' 	=> $company,
			'position'	=> $position,
			'tel' 		=> $phone,
			'email' 	=> $email,
			'content' 	=> $content,
			'service'	=> $service
		);
		Mail::send('mail', $data, function($message)
		{
			$message->from('luan_tt@vietvang.net', 'Liên hệ từ khách hàng');
		    $message->to('gocongtay.luan@gmail.com', 'luan')->subject('Thông tin liên hệ vietvang.net');
		});
	}
}
