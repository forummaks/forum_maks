/* kb.js
 * Last modified: 29.08.2005
 * Description: JavaScript used by Russian Keyboard
 * The script is compressed to reduce its size, look for the raw version at http://prumysl.wz.cz/bb/
 */
var l_letter=new Array('`','1','2','3','4','5','6','7','8','9','0','-','=','q','w','e','r','t','y','u','i','o','p','[',']','BackSpace','Shift','a','s','d','f','g','h','j','k','l',';',"'",'Enter','CapsLock','z','x','c','v','b','n','m',',','.','/','\\','Rus/Lat','Undo',' ','Clear');var lb_letter=new Array('~','!','@','#','$','%','^','&','*','(',')','_','+','Q','W','E','R','T','Y','U','I','O','P','{','}','BackSpace','Shift','A','S','D','F','G','H','J','K','L',':','"','Enter','CapsLock','Z','X','C','V','B','N','M','<','>','?','|','Rus/Lat','Undo',' ','Clear');var r_letter=new Array('�','1','2','3','4','5','6','7','8','9','0','-','=','�','�','�','�','�','�','�','�','�','�','�','�','BackSpace','Shift','�','�','�','�','�','�','�','�','�','�','�','Enter','CapsLock','�','�','�','�','�','�','�','�','�','.','\\','Rus/Lat','Undo',' ','Clear');var rb_letter=new Array('�','!','"','�',';','%',':','?','*','(',')','_','+','�','�','�','�','�','�','�','�','�','�','�','�','BackSpace','Shift','�','�','�','�','�','�','�','�','�','�','�','Enter','CapsLock','�','�','�','�','�','�','�','�','�',',','\\','Rus/Lat','Undo',' ','Clear');var ltype=new Array(2,0,0,0,0,0,0,0,0,0,0,0,0,3,3,3,3,3,3,3,3,3,3,2,2,3,3,3,3,3,3,3,3,3,3,3,2,2,3,3,3,3,3,3,3,3,3,2,2,0,0,3,3,3,3);var letter=new Array(l_letter,lb_letter,r_letter,rb_letter);var dec1=new Array(1040,1041,1062,1044,1045,1060,1043,1061,1048,1049,1050,1051,1052,1053,1054,1055,1070,1056,1057,1058,1059,1042,1065,1061,1067,1047,1072,1073,1094,1076,1077,1092,1075,1093,1080,1081,1082,1083,1084,1085,1086,1087,1102,1088,1089,1090,1091,1074,1097,1093,1099,1079,1100,1098);var dec2=new Array(1071,1041,1063,1044,1069,1060,1046,1065,1048,1049,1050,1051,1052,1053,1025,1055,1070,1056,1064,1058,1070,1042,1065,1061,1067,1046,1103,1073,1095,1076,1101,1092,1078,1097,1080,1081,1082,1083,1084,1085,1105,1087,1102,1088,1096,1090,1102,1074,1097,1093,1099,1078,1068,1066);var dec3=new Array(1060,1048,1057,1042,1059,1040,1055,1056,1064,1054,1051,1044,1068,1058,1065,1047,1049,1050,1067,1045,1043,1052,1062,1063,1053,1071,1092,1080,1089,1074,1091,1072,1087,1088,1096,1086,1083,1076,1100,1090,1097,1079,1081,1082,1099,1077,1075,1084,1094,1095,1085,1103,1093,1098,1078,1101,1073,1102,46,1061,1066,1046,1069,1041,1070,44,1105,1025);var keymode=2;var savemode=0;var btn_first=9;var qn=55;var shift=false;var capslock=false;var apostr=false;var formname="",textname="";var undotext="";var op;var par=new String(location.search);var sag=new String(navigator.userAgent);var use_kb=false;var show_rules=false;var sag=new String(navigator.userAgent);var sap=new String(navigator.appName);var isIE=false;var isOP7=false;var isOP8=false;var isMOZ=false;if(sap=="Microsoft Internet Explorer"&&sag.indexOf("pera")==-1)isIE=true;else if(sag.indexOf("pera 7")>-1||sag.indexOf("pera/7")>-1)isOP7=true;else if(sap=="Netscape")isMOZ=true;else if(sag.indexOf("pera 8")>-1||sag.indexOf("pera/8")>-1){isOP8=true;isMOZ=true;}function kb_help(subj){var t='';if(isIE)t='tmz';else if(isOP7)t='to7';else if(isOP8)t='tmz';else if(isMOZ)t='tmz';helpline(t);}function kb_close(){var expire=new Date();var expdate=expire.getTime()+31536000000;use_kb=false;show_rules=false;expire.setTime(expdate);document.getElementById("kb_keyb").style.position="absolute";document.getElementById("kb_keyb").style.visibility="hidden";document.getElementById("kb_rules").style.position="absolute";document.getElementById("kb_rules").style.visibility="hidden";document.getElementById("kb_off").style.position="static";document.getElementById("kb_off").style.visibility="visible";document.getElementById("kb_trules").style.position="absolute";document.getElementById("kb_trules").style.visibility="hidden";if(isIE)document.cookie="kb_layout="+document.post.decflag.value+";expires="+expire.toGMTString();}function kb_show(){var lyt,val,i;var txtarea=document.forms['post'].message;use_kb=true;document.getElementById("kb_keyb").style.position="static";document.getElementById("kb_keyb").style.visibility="visible";document.getElementById("kb_rules").style.position="static";document.getElementById("kb_rules").style.visibility="visible";document.getElementById("kb_off").style.position="absolute";document.getElementById("kb_off").style.visibility="hidden";document.getElementById("kb_trules").style.position="absolute";document.getElementById("kb_trules").style.visibility="hidden";if(isIE){lyt=document.cookie.split(';');for(i=0;i<lyt.length;i++){if(lyt[i].indexOf('kb_layout')>0){val=lyt[i].split('=');document.post.decflag.value=val[1];}}}undotext=txtarea.value;storeCaret(txtarea);txtarea.focus();}function kb_rules(){if(!show_rules){document.getElementById("kb_keyb").style.position="absolute";document.getElementById("kb_keyb").style.visibility="hidden";document.getElementById("kb_trules").style.position="static";document.getElementById("kb_trules").style.visibility="visible";}else{document.getElementById("kb_keyb").style.position="static";document.getElementById("kb_keyb").style.visibility="visible";document.getElementById("kb_trules").style.position="absolute";document.getElementById("kb_trules").style.visibility="hidden";}show_rules=!show_rules;}function clr(){undotext=document.post.message.value;document.post.message.value="";document.post.message.focus();return false;}function undo(){var txtarea=document.forms['post'].message;var s=txtarea.value;txtarea.value=undotext;undotext=s;txtarea.focus();storeCaret(txtarea);return false;}function changeLetter(n){var i,tg;var off=1;if((n!=5)&&shift) keymode ^=1;keymode ^= n & 3;shift=((n==5)&&!shift);for(i=0;i<qn;off++){tg=document.post.elements[off].className;if(tg=="b30"||tg=="b80"||tg=="b100"||tg=="b300"){document.post.elements[off].value=letter[(shift)?(keymode|(((ltype[i]>>(keymode>>1))&1)^1)):(keymode&((ltype[i]>>(keymode>>1))|2))][i];i++;}}document.post.message.focus();return false;}function delLetter(){if(isOP7)return;var txtarea=document.forms['post'].message;var str=new String(txtarea);var del=1;if(txtarea.createTextRange&&txtarea.caretPos){var caretPos=txtarea.caretPos;caretPos.moveStart('character',-1);caretPos.text='';}else if(txtarea.value!=''&&txtarea.selectionEnd&&(txtarea.selectionStart|txtarea.selectionStart==0)){if(txtarea.selectionEnd>txtarea.value.length)txtarea.selectionEnd=txtarea.value.length;var startPos=txtarea.selectionStart;txtarea.value=txtarea.value.slice(0,startPos-1)+txtarea.value.slice(startPos);txtarea.selectionStart=startPos-1;txtarea.selectionEnd=startPos-1;}else if(str.length>0){if(str.charAt(str.length-1)=='\n') del=2;txtarea.value=str.substr(0,str.length-del);}txtarea.focus();storeCaret(txtarea);return false;}function addl(but){var txtarea=document.forms['post'].message;var chr=(but=='Enter') ? '\n' :but;if((txtarea.value!=''&&txtarea.selectionEnd&&(txtarea.selectionStart|txtarea.selectionStart==0))||isOP8||isOP7 ){if(txtarea.selectionEnd>txtarea.value.length){txtarea.selectionEnd=txtarea.value.length;}var startPos=txtarea.selectionStart;txtarea.value=txtarea.value.slice(0,startPos)+chr+txtarea.value.slice(startPos);txtarea.selectionStart=startPos+1;txtarea.selectionEnd=startPos+1;}else if(txtarea.createTextRange&&txtarea.caretPos&&!(isOP8||isOP7)){var caretPos=txtarea.caretPos;caretPos.text=chr;}else{txtarea.value+=chr;}if(shift){shift=false;changeLetter(1);}txtarea.focus();storeCaret(txtarea);}function init(){undotext=document.post.message.value;changeLetter(0);return false;}function decode_char(code){var i=-1;if(code>=65&&code<=90) i=code-65;else if(code>=97&&code<=122) i=code-71;if(i==-1)switch(code){case 91:i=52;break;case 93:i=53;break;case 39:apostr=!apostr;return '';}if(i!=-1) code=(apostr)?dec2[i]:dec1[i];apostr=false;return String.fromCharCode(code);}function translit(){var txtarea=document.forms['post'].message;var e='',c='';apostr=false;if(txtarea.value!=''&&txtarea.selectionEnd&&(txtarea.selectionStart|txtarea.selectionStart==0)){if(txtarea.selectionEnd>txtarea.value.length){txtarea.selectionEnd=txtarea.value.length;}var startPos=txtarea.selectionStart;var endPos=txtarea.selectionEnd;for(i=0;i<= endPos-startPos-1;i++)e+=decode_char(txtarea.value.charCodeAt(i+startPos));txtarea.value=txtarea.value.slice(0,startPos)+e+txtarea.value.slice(endPos);txtarea.selectionStart=startPos;txtarea.selectionEnd=startPos+e.length;}else if(txtarea.createTextRange&&txtarea.caretPos){var caretPos=txtarea.caretPos;for(i=0;i<= caretPos.text.length;i++)e+=decode_char(caretPos.text.charCodeAt(i));caretPos.text=e;}else{for(i=0;i<= txtarea.value.length;i++)e+=decode_char(txtarea.value.charCodeAt(i));txtarea.value=e;}txtarea.focus();storeCaret(txtarea);}function decode(evt){if((document.post.decflag.type!="select-one")||(document.post.decflag.value==0))return true;var code=evt.keyCode?evt.keyCode:evt.charCode?evt.charCode:evt.which?evt.which:0;var newc=code,i=-1;if(code>=65&&code<=90) i=code-65;else if(code>=97&&code<=122) i=code-71;if(document.post.decflag.value==1){if(i==-1)switch(code){case 91:i=52;break;case 93:i=53;break;case 39:apostr=!apostr;return !apostr;}if(i!=-1)newc=(apostr)?dec2[i]:dec1[i];apostr=false;}else{if(i==-1){switch(code){case 91:i=(capslock)?59:52;break;case 93:i=(capslock)?60:53;break;case 59:i=(capslock)?61:54;break;case 39:i=(capslock)?62:55;break;case 44:i=(capslock)?63:56;break;case 46:i=(capslock)?64:57;break;case 47:i=58;break;case 123:i=(capslock)?52:59;break;case 125:i=(capslock)?53:60;break;case 58:i=(capslock)?54:61;break;case 34:i=(capslock)?55:62;break;case 60:i=(capslock)?56:63;break;case 62:i=(capslock)?57:64;break;case 63:i=65;break;case 96:i=(capslock)?67:66;break;case 126:i=(capslock)?66:67;break;}}else{if(i<26) capslock=!evt.shiftKey;else capslock=evt.shiftKey;}if(i!=-1){newc=dec3[i];}}if(isIE){evt.keyCode=newc;}else if(isMOZ&&code!=newc&&evt.which!=0){evt.preventDefault();addl(String.fromCharCode(newc));}storeCaret(document.post.message);return true;}