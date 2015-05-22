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


