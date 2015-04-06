	function chon() {
		var mang = document.getElementsByName('item[]')				
		var n = mang.length		
		var trang_thai = document.getElementById('check_all').checked
		
		for(var i=0 ; i<n ; i++) {
			mang.item(i).checked = trang_thai
		}
	}
	
	function chon_item(trang_thai) {
		if (trang_thai == false) {
			document.getElementById('check_all').checked = false
		} else {
			document.getElementById('check_all').checked = kiem_tra_check_all()
		}
	}
	
	function kiem_tra_check_all() {
		var mang = document.getElementsByName('item[]')				
		var n = mang.length		
		
		for(var i=0 ; i<n ; i++) {
			if (mang.item(i).checked == false) return false;
		}		
		return true;
	}
	//Check - Uncheck image
	function check_use_image(trang_thai){
		if (trang_thai == false) {
			document.getElementById('ckimg').checked = false
			//remove disable
			document.getElementById('fs').removeAttribute('disabled')
			document.getElementById('fs1').removeAttribute('disabled')
			//document.getElementsByTagName('fieldset').removeAttribute("disabled")
		} else {
			document.getElementById('ckimg').checked = true
			//add disable
			document.getElementById('fs').setAttribute('disabled','')
			document.getElementById('fs1').setAttribute('disabled','')
			//document.getElementsByTagName('fieldset').setAttribute("disabled")
		}
	}
	function inputNumber(e)
	{
		// cho phep nhap so, nut backspace, delete vau dau .
		var keynum;
		if(window.event) // IE
		{
		  keynum = e.keyCode;
		}
		else if(e.which) // Netscape/Firefox/Opera
		{
		  keynum = e.which;
		}
		
		//alert(keynum);
		
		if ( ((keynum > 45) && (keynum <58)) || (keynum == 8) || (keynum == 9) || (keynum == 190) || (keynum == 39)|| (keynum == 37) ) return true;
		else return false;
		
		// 37 : left ; 39: right
	}
function formatInt ( ctrl )
	{
	  var separator = ",";
	  var int = ctrl.value.replace ( new RegExp ( separator, "g" ), "" );
	  var regexp = new RegExp ( "\\B(\\d{3})(" + separator + "|$)" );
	  do
	  {
			  int = int.replace ( regexp, separator + "$1" );
	  }
	  while ( int.search ( regexp ) >= 0 )
	  ctrl.value = int;
	}

function pass_match(pass, id){ //(password itself, id of input <input id="pass"> or <input id="pass2">)
   //IF "id" IS ONE, GET THE ID AND VALUE OF THE OTHER INPUT FOR COMPARISON
   if(id=='pass'){
     other_id = "pass2"; //ID OF OTHER
     other_pass = $('input#pass2').val(); //VALUE OF OTHER
   } else {
     if(id=='pass2'){
       other_id = "pass"; //ID OF OTHER
       other_pass = $("input#pass").val(); //VALUE OF OTHER
     }
   }
/*IF BOTH PASSWORS ARE NOT EMPTY
AND IF PASSWORDS DO NOT MATCH, DISPLAYS MESSAGE NEXT TO INPUT, ELSE CLEAR THE MESSAGE*/
   if(pass&&other_pass){
     if(pass!=other_pass){
       $("span#"+id).html("Passwords don't match");
       $("span#"+other_id).html(""); //CLEARS MESSAGE WHEN FOCUS IS BACK ON THIS INPUT
     } else {
       $("span#"+id).html("");
     }
   }
   else
   {
     $("span#"+id).html("");
   }
}	

/*--------------------------------------check input search contract*/
function kiemtrasearchcontract(){
	var idkh=$('#idkhachhang').val();
	var idct=$('#id_chuong_trinh').val();
	var ngay_het_han=$('#ngay_het_han').val();


	if(idkh == "" && idct == "" && ngay_het_han == "") {
		alert("Vui lòng chọn giá trị tìm kiếm !");
		return false;
	}
	return true;
}

/*-------------------------------------------------- POPUP-----------------------------*/
var link="http://localhost:1313/WEB_QuanLyKhachHang/index.php/";

function changesuppliername()
{
	var id=$('#idkhachhang').val();
	//alert(id);
	if(id==777)
	{
	 $.blockUI({
	 	 theme:     true, 
	title:    'Thêm mới khách hàng ', 
	 message: $('#insertsupplier'),
			 }); 

	}

}

function insertnewsupplier()
{
	var name=$('#addnewsupplier').val();
	var add=$('#address').val();
	var phone=$('#phone').val();
	var relation=$('#relation').val();
	var title=$('#title').val();
	var dt=$('#dt').val();
	//var test=trim(name);
	//alert(test);
	// if((test.length <= 0))
	// {
	//   alert("Customer Name is not blank. ");
	//   return false;
	// }
	if(name=="")
	{
		alert('Not Null ');
		return false;
	}

	var ur=link+"sales/insertnewcus";
	$.ajax({
		type:"POST",
		dataType: 'json',
		url:ur,
		data:{jname:name, jadd:add, jphone:phone, jrelation:relation, jdt:dt, jtitle:title},
		success:function(json)
		{
			alert('OK');
			//$('#show').html(html);
			
			$.unblockUI();
			$('#newsupplier').text(json.jsonname);
			$('#newsupplier').val(json.jidkhachhang);
		},
		error: function(param1, param2, param3) {
			console.log(param1);
			console.log(param2);
			console.log(param3);
		}
	});
}				

/*---------------------------------------add new nguoi lien he-*/
function changeupdatenguoilienhe(id)
{
	
	 $.blockUI({
	 	 theme:     true, 
	title:    'Thêm mới người liên hệ ', 
	 message: $('#insertnguoilienhe' + id),
			 }); 

}

function insertnewnguoilienhe(id)
{
	var id=$('#id'+ id).val();
	var relation=$('#relation'+ id).val();
	var title=$('#title'+ id).val();
	var dt=$('#dt'+ id).val();
	var address=$('#address'+ id).val();
	var email=$('#email'+ id).val();
	if(relation=="")
	{
		alert('Tên người liên hệ không được rỗng ! ');
		return false;
	}

	var ur=link+"nguoilienhe/insertnewnguoilienhe";
	$.ajax({
		type:"POST",
		dataType: 'json',
		url:ur,
		data:{jid:id, jrelation:relation, jdt:dt, jtitle:title, jaddress:address, jemail:email},
		success:function(json)
		{
			alert('OK');
			//$('#show').html(html);
			
			$.unblockUI();
			// $('#idloaihopdong').text(json.jsonname);
		},
		error: function(param1, param2, param3) {
			console.log(param1);
			console.log(param2);
			console.log(param3);
		}
	});
}				

/*---------------------------------------end add nguoi lien he----------------------*/
function changeupdateloaidung(idkh)
{
	 
	 $.blockUI({
	 	 theme:     true, 
	title:    'Cập nhật loại dùng ', 
	 message: $('#insertdungthu'+idkh),
			 }); 

	

}


function insertnewdungthu(idkh)
{
	var id=$('#id' + idkh).val();
	var id_loaihopdong=$('#id_loaihopdong'+ idkh).val();
	var id_nhan_vien_install=$('#id_nhan_vien_install'+ idkh).val();
	var ngay_instal=$('#ngay_instal'+ idkh).val();
	var ngay_het_han=$('#ngay_het_han'+ idkh).val();
	var ma_chung_thuc=$('#ma_chung_thuc'+ idkh).val();
	var idteamviewer=$('#idteamviewer'+ idkh).val();

	var khach_hang_ky=$('#khach_hang_ky'+ idkh).val();
	
	if(id_loaihopdong=="")
	{
		alert('Loại hợp đồng Not Null ');
		return false;
	}
	if(id_nhan_vien_install=="")
	{
		alert('Nhân viên cài  Not Null ');
		return false;
	}
	
	//compare date
	var d_start =  Date.parse(ngay_instal);
	var d_end = Date.parse(ngay_het_han);
	if (d_end <= d_start) {
		alert("Ngày hết hạn phải lớn hơn ngày cài đặt !");
		return false;
	};

	//

	var ur=link+"sales/insertnewdungthu";
	$.ajax({
		type:"POST",
		dataType: 'json',
		url:ur,
		data:{jid:id, jid_loaihopdong:id_loaihopdong, jid_nhan_vien_install:id_nhan_vien_install, 
			jngay_instal:ngay_instal, jngay_het_han:ngay_het_han, jma_chung_thuc:ma_chung_thuc, 
			jidteamviewer:idteamviewer, jkhach_hang_ky:khach_hang_ky},
		success:function(json)
		{
			alert('OK');
			//$('#show').html(html);
			
			$.unblockUI();
			$('#idloaihopdong').val(json.jloaisudung);
			if (json.error) return;
			$(document).ajaxStop(function () { location.reload(true);});
			
		},
		error: function(param1, param2, param3) {
			console.log(param1);
			console.log(param2);
			console.log(param3);
		}
	});
}				

/*-----------------------------------------------------------------------------------*/
/*---------------------------------------change update trail -> contract-*/
function changeupdatehopdong(idkh)
{
	 
	 $.blockUI({
	 	 theme:     true, 
	title:    'Cập nhật loại dùng ', 
	 message: $('#insertdungthiet'+idkh),
			 }); 

	

}


function insertnewdungthiet(idkh)
{
	var id=$('#id' + idkh).val();
	var id_loaihopdong=$('#id_loaihopdong'+ idkh).val();
	var id_nhan_vien_install=$('#id_nhan_vien_install'+ idkh).val();
	var ngay_instal=$('#ngay_instal'+ idkh).val();
	var ngay_het_han=$('#ngay_het_han'+ idkh).val();
	var ma_chung_thuc=$('#ma_chung_thuc'+ idkh).val();
	var idteamviewer=$('#idteamviewer'+ idkh).val();

	var khach_hang_ky=$('#khach_hang_ky'+ idkh).val();
	//var test=trim(name);
	//alert(test);
	// if((test.length <= 0))
	// {
	//   alert("Customer Name is not blank. ");
	//   return false;
	// }
	if(id_loaihopdong=="")
	{
		alert('Loại hợp đồng Not Null ');
		return false;
	}
	if(id_loaihopdong==1)
	{
		alert('Loại hợp đồng phải khác dùng thử ');
		return false;
	}
	if(id_nhan_vien_install=="")
	{
		alert('Nhân viên cài  Not Null ');
		return false;
	}

	//compare date
	var d_start =  Date.parse(ngay_instal);
	var d_end = Date.parse(ngay_het_han);
	if (d_end <= d_start) {
		alert("Ngày hết hạn phải lớn hơn ngày cài đặt !");
		return false;
	};

	//

	var ur=link+"install/insertnewdungthiet";
	$.ajax({
		type:"POST",
		dataType: 'json',
		url:ur,
		data:{jid:id, jid_loaihopdong:id_loaihopdong, jid_nhan_vien_install:id_nhan_vien_install, 
			jngay_instal:ngay_instal, jngay_het_han:ngay_het_han, jma_chung_thuc:ma_chung_thuc, 
			jidteamviewer:idteamviewer, jkhach_hang_ky:khach_hang_ky},
		success:function(json)
		{
			alert('OK');
			//$('#show').html(html);
			
			$.unblockUI();
			//$('#idloaihopdong').val(json.jloaisudung);
			if (json.error) return;
			$(document).ajaxStop(function () { location.reload(true);});
			
		},
		error: function(param1, param2, param3) {
			console.log(param1);
			console.log(param2);
			console.log(param3);
		}
	});
}				

/*-----------------------------------------------------------------------------------*/
/*---------------------------------------change update trail -> contract-*/
function changeupdatetaihopdong(idkh)
{
	 
	 $.blockUI({
	 	 theme:     true, 
	title:    'Cập nhật loại dùng ', 
	 message: $('#inserttaihopdong'+idkh),
			 }); 

	

}


function insertnewtaihopdong(idkh)
{
	
	var stt=$('#id' + idkh).val();
	var id_chuong_trinh=$('#id_chuong_trinh'+ idkh).val();
	var id_loaihopdong=$('#id_loaihopdong'+ idkh).val();
	var id_nhan_vien_install=$('#id_nhan_vien_install'+ idkh).val();
	var ngay_instal=$('#ngay_instal'+ idkh).val();
	var ngay_het_han=$('#ngay_het_han'+ idkh).val();
	var ma_chung_thuc=$('#ma_chung_thuc'+ idkh).val();
	var idteamviewer=$('#idteamviewer'+ idkh).val();

	var khach_hang_ky=$('#khach_hang_ky'+ idkh).val();
	//var test=trim(name);
	//alert(test);
	// if((test.length <= 0))
	// {
	//   alert("Customer Name is not blank. ");
	//   return false;
	// }
	if(id_loaihopdong=="")
	{
		alert('Loại hợp đồng Not Null ');
		return false;
	}
	if(id_loaihopdong==1)
	{
		alert('Loại hợp đồng phải khác dùng thử ');
		return false;
	}
	if(id_nhan_vien_install=="")
	{
		alert('Nhân viên cài  Not Null ');
		return false;
	}

	//compare date
	var d_start =  Date.parse(ngay_instal);
	var d_end = Date.parse(ngay_het_han);
	if (d_end <= d_start) {
		alert("Ngày hết hạn phải lớn hơn ngày cài đặt !");
		return false;
	};

	//

	var ur=link+"contract/insertnewtaihopdong";
	$.ajax({
		type:"POST",
		dataType: 'json',
		url:ur,
		data:{jid:stt, jid_chuong_trinh:id_chuong_trinh, jid_loaihopdong:id_loaihopdong, jid_nhan_vien_install:id_nhan_vien_install, 
			jngay_instal:ngay_instal, jngay_het_han:ngay_het_han, jma_chung_thuc:ma_chung_thuc, 
			jidteamviewer:idteamviewer, jkhach_hang_ky:khach_hang_ky},
		success:function(json)
		{
			alert('OK');
			//$('#show').html(html);
			
			$.unblockUI();
			$('#idloaihopdong').val(json.jloaisudung);
			if (json.error) return;
			$(document).ajaxStop(function () { location.reload(true);});
		},
		error: function(param1, param2, param3) {
			console.log(param1);
			console.log(param2);
			console.log(param3);
		}
	});
}				

/*-----------------------------------------------------------------------------------*/
function cancelpopup()
{
	$.unblockUI();
}