<?php namespace App;

class Ini
{
	// function ktlogin(){
	// 	if($CI->session->userdata('login') != 'ok')
	// 	{
	// 		//$_SESSION['REFERER'] = $_SERVER['REQUEST_URI'];
	// 		header('Location: /login/dang_nhap');
	// 		exit;
	// 	}
	// }
	// function __contruct()
	// {
	//     $this->message(true);
	// }

    public static function message($auto = TRUE)
    {
        if($auto)
        {
           
                $msg = session('msg');
                $type_msg = session('type_msg');
	            if ($msg != '') {
					
					// echo '<div class="notification ', $type_msg, ' png_bg"> <a href="#" class="close"><img src="', base_url(),'public/admin/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
					//   <div>', $msg, '</div>
					// </div>';
					echo '<div class="alert alert-',$type_msg,' alert-dismissable text-center">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <i class="fa fa-info-circle"></i> ',$msg,' 
                        </div>';
								
				$msg = array(
						'type_msg' =>'',
						'msg' =>''
						);

				session($msg);
			}		
        }
    }

    // function datediff($enddate){
    // 	$today = strtotime(date('Y-m-d'));
    // 	$expdate = strtotime($enddate);
    // 	$datediff = abs($expdate - $today);
    // 	return floor($datediff/(60*60*24));

    // }

}
?>