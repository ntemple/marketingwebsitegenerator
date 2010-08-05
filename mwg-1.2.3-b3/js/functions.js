// dysplays on/off if a checkbox is checked/unchecked 
// the id of the <tr>(or other things) has to have the same name as checbox name+"_td"
function display_tr(check)
{
	if (check.checked){
		document.getElementById(check.name+'_td').style.display='';
	}else document.getElementById(check.name+'_td').style.display='none';
}
// dysplays on/off if a radio is checked/unchecked 
// the id of the <tr>(or other things) has to have the same name as checbox name+"_td"
function display_tr_radio(checkName,check)
{
	for (i=0;i<check.length;i++){
		
		if (check[i].checked==true){
			document.getElementById(checkName.name+'_'+i+'_td').style.display='';
		}else{ 
			document.getElementById(checkName.name+'_'+i+'_td').style.display='none';
		}
	}
}
//to check all checkboxes in a form
//parameters are the checked checkbox(or true/false) and form name (the form MUST HAVE AN ID BESIDES NAME)
function checkedAll (checked,form_name) {
	var el = document.getElementById(form_name);
		
	
	for (var i = 0; i < el.elements.length; i++) {
	  	el.elements[i].checked = checked;
	}
}
//email format checking
function emailCheck(who){
	var email=/^[A-Za-z0-9][\w-.]*[A-Za-z0-9]*@[A-Za-z0-9]*([\w-.]*[A-Za-z0-9]\.)+([A-Za-z]){2,4}$/i;
	return(email.test(who));
}
function copy_fields(){
	el_1 = document.form1;
	el_2 = document.form2;
	
	for (var i = 0; i < el_2.elements.length; i++){
//		document.write(document.form2.elements[i].name+"||"+document.form1.elements[i].value+"<br>");
//
//		document.write(document.form1.elements[i].name+"||"+document.form1.elements[i].value+"<br>");
//		document.write("<hr>");		
		document.form2.elements[i].value = document.form1.elements[i].value;
	}
}
function makeRequest_get(url,code) {
	var http_request = false;
	if (window.XMLHttpRequest) { // Mozilla, Safari,...
		http_request = new XMLHttpRequest();
		if (http_request.overrideMimeType) {
			http_request.overrideMimeType('text/xml');
			// See note below about this line
		}
	} else if (window.ActiveXObject) { // IE
		try {
			http_request = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try {
				http_request = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e) {}
		}
	}
	if (!http_request) {
		alert('Giving up :( Cannot create an XMLHTTP instance');
		return false;
	}
	if (code == 1){
		http_request.onreadystatechange = function() { showContents(http_request); };
	}
	//http_request.onreadystatechange = function() { showContents_email(http_request); };
	http_request.open('GET', url, true);
	http_request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	http_request.send(null);
}
// displays the inner html recieved after request
function showContents(http_request) {
	if (http_request.readyState == 4) {
		if (http_request.status == 200) {
		   str = http_request.responseText;
		   if (str.search(/.*code=ok.*/) == -1){alert('The promo code is not valid');return false}
		} else {
			alert('There was a problem with the request.');
		}
	}
}
function showContents_email(http_request) {
	if (http_request.readyState == 4) {
		if (http_request.status == 200) {
		   str = http_request.responseText;
		   if (str.search(/.*double_email=ok*/) == -1){
		   	  alert('The email already exists in our database');
		   	  document.body.innerHTML = http_request.responseText;
		   	  return false;
		   }else{
			   //setTimeout('document.form1.submit()',10000);
		   }
		} else {
			alert('There was a problem with the request.');
		}
	}
}
 //ajax functions remote http request ...
    
    function makeRequest(url) {
        var http_request = false;
        if (window.XMLHttpRequest) { // Mozilla, Safari,...
            http_request = new XMLHttpRequest();
            if (http_request.overrideMimeType) {
                http_request.overrideMimeType('text/xml');
                // See note below about this line
            }
        } else if (window.ActiveXObject) { // IE
            try {
                http_request = new ActiveXObject("Msxml2.XMLHTTP");
            } catch (e) {
                try {
                    http_request = new ActiveXObject("Microsoft.XMLHTTP");
                } catch (e) {}
            }
        }
        if (!http_request) {
            alert('Giving up :( Cannot create an XMLHTTP instance');
            return false;
        }
        http_request.onreadystatechange = function() { alertContents(http_request); };
        http_request.open('GET', url, true);
		http_request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        http_request.send(null);
    }
    function alertContents(http_request) {
        if (http_request.readyState == 4) {
            if (http_request.status == 200) {
			  document.body.innerHTML = http_request.responseText;
            } else {
                alert('There was a problem with the request.');
            }
        }
    }
var cookieEnabled=(navigator.cookieEnabled)? true : false
if (!cookieEnabled) alert ('You must have cookies enabled');
/**
*
*  Base64 encode / decode
*  http://www.webtoolkit.info/
*
**/
var Base64 = {
	// private property
	_keyStr : "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",
	// public method for encoding
	
	// public method for decoding
	decode : function (input) {
		var output = "";
		var chr1, chr2, chr3;
		var enc1, enc2, enc3, enc4;
		var i = 0;
		input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");
		while (i < input.length) {
			enc1 = this._keyStr.indexOf(input.charAt(i++));
			enc2 = this._keyStr.indexOf(input.charAt(i++));
			enc3 = this._keyStr.indexOf(input.charAt(i++));
			enc4 = this._keyStr.indexOf(input.charAt(i++));
			chr1 = (enc1 << 2) | (enc2 >> 4);
			chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
			chr3 = ((enc3 & 3) << 6) | enc4;
			output = output + String.fromCharCode(chr1);
			if (enc3 != 64) {
				output = output + String.fromCharCode(chr2);
			}
			if (enc4 != 64) {
				output = output + String.fromCharCode(chr3);
			}
		}
		output = Base64._utf8_decode(output);
		return output;
	},
	// private method for UTF-8 encoding
	_utf8_encode : function (string) {
		string = string.replace(/\r\n/g,"\n");
		var utftext = "";
		for (var n = 0; n < string.length; n++) {
			var c = string.charCodeAt(n);
			if (c < 128) {
				utftext += String.fromCharCode(c);
			}
			else if((c > 127) && (c < 2048)) {
				utftext += String.fromCharCode((c >> 6) | 192);
				utftext += String.fromCharCode((c & 63) | 128);
			}
			else {
				utftext += String.fromCharCode((c >> 12) | 224);
				utftext += String.fromCharCode(((c >> 6) & 63) | 128);
				utftext += String.fromCharCode((c & 63) | 128);
			}
		}
		return utftext;
	},
	// private method for UTF-8 decoding
	_utf8_decode : function (utftext) {
		var string = "";
		var i = 0;
		var c = c1 = c2 = 0;
		while ( i < utftext.length ) {
			c = utftext.charCodeAt(i);
			if (c < 128) {
				string += String.fromCharCode(c);
				i++;
			}
			else if((c > 191) && (c < 224)) {
				c2 = utftext.charCodeAt(i+1);
				string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
				i += 2;
			}
			else {
				c2 = utftext.charCodeAt(i+1);
				c3 = utftext.charCodeAt(i+2);
				string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
				i += 3;
			}
		}
		return string;
	}
}