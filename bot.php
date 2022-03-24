<?php
//error_reporting(0);
system("rm cookie.txt");
const
host = "kiddyearner.com",
b = "\033[1;34m",
c = "\033[1;36m",
d = "\033[0m",
h = "\033[1;32m",
k = "\033[1;33m",
m = "\033[1;31m",
n = "\n",
p = "\033[1;37m",
u = "\033[1;35m";

function Curl($u, $h = 0, $p = 0, $m = 0,$c = 0,$x = 0) {//url,header,post,proxy
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $u);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
	curl_setopt($ch, CURLOPT_COOKIE,TRUE);
	curl_setopt($ch, CURLOPT_COOKIEFILE,"cookie.txt");
	curl_setopt($ch, CURLOPT_COOKIEJAR,"cookie.txt");
	if($p) {
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $p);
	}
	if($h) {
		curl_setopt($ch, CURLOPT_HTTPHEADER, $h);
	}
	if($m) {
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $m);
	}
	if($x) {
		curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, true);
		curl_setopt($ch, CURLOPT_PROXY, $x);
	}
	curl_setopt($ch, CURLOPT_HEADER, true);
	$r = curl_exec($ch);
	$c = curl_getinfo($ch);
	if(!$c) return "Curl Error : ".curl_error($ch); else{
		$hd = substr($r, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
		$bd = substr($r, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
		curl_close($ch);
		return array($hd,$bd);
	}
}
function hasil($depan, $operator, $belakang){
	if ($operator == "+") return $depan+$belakang;
	elseif ($operator == "-") return $depan-$belakang;
	else return "kosong";
}
function z($x,$y,$z){
	return ["+".$y."+".$z."+".$x,"+".$x."+".$y."+".$z,"+".$x."+".$z."+".$y,"+".$y."+".$x."+".$z,"+".$z."+".$y."+".$x,"+".$z."+".$x."+".$y];
}
function Save($n){if(file_exists($n)){$d = file_get_contents($n);}else{$d = readline(m."Input ".$n.k." > ".h.n);echo n;file_put_contents($n,$d);}return $d;}
function Line(){$l = 50;return b.str_repeat('─',$l).n;}
function Ban(){
	system('clear');
	print n.n;
	print h."Author  : ".k."iewil".n;
	print h."Script  : ".k.host.n;
	print h."Youtube : ".k."youtube.com/c/iewil".n;
	print line();
}
function h(){
	$u=Save("User_Agent");
	return ["Host: ".host,"origin: https://".host,"user-agent: ".$u,"accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8","accept-language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7","referer: https://".host];
}
function Get_Dashboard(){
	$url = "https://".host."/dashboard";
	$r = Curl($url,h())[1];
	$user = explode("',",explode("siteUserFullName: '",$r)[1])[0];
	$bal   = explode('</p>',explode('<p>',explode('<div class="notif-count">',$r)[1])[1])[0];
	return ["user"=>$user,"bal"=>$bal];
}
function Gp($code){
	$r = file_get_contents('https://pastebin.com/raw/7PfnyRM3');
	$res = json_decode($r,1);
	return $res[$code];
}
function Get_Login($em,$pw){
	system("rm cookie.txt");
	login:
	$r = Curl("https://".host."/login",h())[1];
	$code = explode('</span>',explode('<span class="text-color text-capitalize">',$r)[1])[0];
	$gp = Gp($code);
	if($gp[1]){
		$data = "email=".$em."&password=".$pw."&captcha=gpcaptcha&captcha_code=".$gp[0]."&captcha_choosen=".$gp[1];
		$r2 = Curl("https://".host."/auth/login",h(),$data)[1];
	}else{
		goto login;
	}
}
cookie:
Save("User_Agent");
$em = Save('Email_Login');
$pw = Save('Password_Login');

Get_Login($em,$pw);

print Ban();
$r = Get_Dashboard();
echo h."Username   ~> ".k.$r["user"].n;
echo h."Balance    ~> ".k.$r["bal"].n;
print Line();
menu:
echo m."1 >".p." Faucet\n";
echo m."2 >".p." Visit Ptc & Ads\n";
echo m."3 >".p." AutoFaucet\n";
echo m."4 >".p." Join Quiz\n";
echo m."5 >".p." Withdraw\n";
$pil=readline(h."Input Number ".m."> ".p);
print Line();

if($pil==1){goto faucet;
}elseif($pil==2){goto ptc;
}elseif($pil==3){goto auto;
}elseif($pil==4){goto quiz;
}elseif($pil==5){goto wd;
}else{echo m."Bad Number\n".n;print line();goto menu;}

faucet:
while(true){
	for($i=0;$i<6;$i++){
		$r = Curl("https://".host."/faucet",h())[1];
		if(preg_match('/Just a moment.../',$r)){
			Get_Login($em,$pw);
			goto faucet;
		}
		$tmr=explode(' -',explode('let wait = ',$r)[1])[0];
		if($tmr){tmr($tmr);goto faucet;}
		echo k."Bypass ";
		$token = explode('"',explode('name="token" value="',$r)[1])[0];
		$code = explode('</span>',explode('<span class="text-color text-capitalize">',$r)[1])[0];
		$gp = Gp($code);
		if($gp[1]){
			$b = explode('\"#\" rel=\"',$r);
			$b1 = explode('\"',$b[1])[0];
			$b2 = explode('\"',$b[2])[0];
			$b3 = explode('\"',$b[3])[0];
			$bot = z($b1,$b2,$b3);
			
			echo $bot[$i];
			$data = "antibotlinks=".$bot[$i]."&ci_csrf_token=&token=".$token."&captcha=gpcaptcha&captcha_code=".$gp[0]."&captcha_choosen=".$gp[1];
			$r1 = Curl("https://".host."/faucet/verify",h(),$data)[1];
			$ss = explode('has',explode("text: '",$r1)[1])[0];
			echo "\r                     \r";
			if($ss){
				echo h."Success    ~> ".k.$ss.n;
				echo h."Balance    ~> ".k.Get_Dashboard()["bal"].n;
				print Line();
			}else{
				echo m."antibotlink salah";
				sleep(2);
				echo "\r                 \r";
			}
		}
	}
}

ptc:
while(true){
	$r = Curl('https://'.host.'/ptc',h())[1];
	if(preg_match('/Just a moment.../',$r)){
		echo "klodpler";die();
		Get_Login($em,$pw);
		goto ptc;
	}
	$ads = explode('</p>',explode('<p>',explode('<div class="balance">',$r)[1])[1])[0];
	$id = explode("'",explode("https://kiddyearner.com/ptc/view/",$r)[1])[0];
	if($id){
		ulang:
		$r = Curl('https://kiddyearner.com/ptc/view/'.$id,h())[1];
		$code = explode('</span>',explode('<span class="text-color text-capitalize">',$r)[1])[0];
		$gp = Gp($code);
		if($gp[1]){
			$tmr = explode(';',explode('let timer = ',$r)[1])[0];
			$ad = explode('"',explode('<iframe id="ads" src="',$r)[1])[0];
			$token = explode('">',explode('<input type="hidden" name="token" value="',$r)[1])[0];
			if($tmr){tmr($tmr);}
			$data = "captcha=gpcaptcha&captcha_code=".$gp[0]."&captcha_choosen=".$gp[1]."&ci_csrf_token=&token=".$token;
			$r1 = Curl('https://kiddyearner.com/ptc/verify/'.$id,h(),$data)[1];
			$ss = explode('has',explode("text: '",$r1)[1])[0];
			if($ss){
				echo b."Visit : ".k.$ad.n;
				echo h."Success    ~> ".k.$ss.n;
				echo h."Balance    ~> ".k.Get_Dashboard()["bal"].n;
				print Line();
			}
		}else{
			goto ulang;
		}
	}else{
		print m."Ptc habis bosqu".n;
		print Line();goto ads;
	}
}
ads:
while(true){
	$r = Curl('https://'.host.'/ptc/ptcwindow',h())[1];
	if(preg_match('/Just a moment.../',$r)){
		echo "klodpler";die();
		Get_Login($em,$pw);
		goto ptc;
	}
	$ads = explode('</p>',explode('<p>',explode('<div class="balance">',$r)[1])[1])[0];
	$id = explode('"',explode('<form action="',$r)[1])[0];
	if($id){
		uling:
		$r = Curl($id,h())[1];
		$code = explode('</span>',explode('<span class="text-color text-capitalize">',$r)[1])[0];
		$gp = Gp($code);
		if($gp[1]){
			$tmr = explode('"',explode('timer="',$r)[1])[0];
			$ad = explode('"',explode('<iframe id="ads" src="',$r)[1])[0];
			$token = explode('">',explode('<input type="hidden" name="token" value="',$r)[1])[0];
			if($tmr){tmr($tmr);}
			$data = "captcha=gpcaptcha&captcha_code=".$gp[0]."&captcha_choosen=".$gp[1]."&ci_csrf_token=&token=".$token;
			$r1 = Curl($id,h(),$data)[1];
			$ss = explode('has',explode("text: '",$r1)[1])[0];
			if($ss){
				echo b."Visit : ".k.$ad.n;
				echo h."Success    ~> ".k.$ss.n;
				echo h."Balance    ~> ".k.Get_Dashboard()["bal"].n;
				print Line();
			}
		}else{
			goto uling;
		}
	}else{
		print m."Ads habis bosqu".n;
		print Line();goto menu;
	}
}
auto:
while(true){
	$r = Curl('https://'.host.'/auto',h())[1];
	$tmr = explode(';',explode('let timer = ',$r)[1])[0];
	if($tmr){
		tmr($tmr);
	}else{
		print m."You don't have enough energy for Auto Faucet!";
		print line();
		goto menu;
	}
	$token = explode('"',explode('name="token" value="',$r)[1])[0];
	$data = "token=".$token;
	$r2 = Curl('https://'.host.'/auto/verify',h(),$data)[1];
	$ss = explode('has',explode("text: '",$r2)[1])[0];
	if($ss){
		echo h."Success    ~> ".k.$ss.n;
		echo h."Balance    ~> ".k.Get_Dashboard()["bal"].n;
	}
}
quiz:
while(true){
	$r = Curl("https://".host."/quize",h())[1];
	Get_Login($em,$pw);
	$tmr = rand(1,13);
	tmr($tmr);
	preg_match_all("/>(\d+)(\D)(\d+)</", $r, $d);
	if($d[1][0] == "0"){
		print m."Quiz habis bosqu".n;
		print Line();goto menu;
	}
	$hasil =  hasil($d[1][1], $d[2][1], $d[3][1]);
	if($hasil == "kosong"){
		goto quiz;
	}
	$token = explode('"',explode('<input type="hidden" name="token" value="',$r)[1])[0];
	$id    = explode('"',explode('<input type="hidden" name="question_id" value="',$r)[1])[0];
	$data  = "ci_csrf_token=&token=".$token."&question_id=".$id."&ans=".$hasil;
	$r2 = Curl("https://".host."/quize/verify",h(),$data)[1];
	$ss = explode('has',explode("text: 'Correct Answer. ",$r2)[1])[0];
	if($ss){
		echo h."Success    ~> ".k.$ss.n;
		echo h."Balance    ~> ".k.Get_Dashboard()["bal"].n;
		echo h."Quize Left ~> ".k.($d[1][0]-1).n;
	}else{
		echo m."Error          ~> Salah nebak nih".n;
		echo h."Balance    ~> ".k.Get_Dashboard()["bal"].n;
		echo h."Quize Left ~> ".k.($d[1][0]-1).n;
	}
print Line();
}
wd:
$r = Curl('https://kiddyearner.com/withdraw',h())[1];
$amn = explode('"',explode('" max="',$r)[1])[0];
$id = explode('<div class="col-md-6 col-lg-4 col-sm-12">',$r);
foreach($id as $a => $coin){
	if($a == 0){ continue; }
	$coin = explode('<img',explode('<div class="panel-heading">',$coin)[1])[0];
	Print m.$a." > ".p.$coin.n;
}
$wd=readline(h."Input Number ".m."> ".p);
print line();
$mtd = explode('"',explode('" value="',$id[$wd])[1])[0];
$data = "wallet=".$em."&amount=".$amn."&method=".$mtd;
$r2 = Curl('https://kiddyearner.com/withdraw/withdraw',h())[1];
$ss = explode("'",explode("text: '",$r2)[1])[0];
if($ss){
	echo h."Success    ~> ".k.$ss.n;
	print line();
}
goto menu;
function Tmr($tmr){$timr=time()+$tmr;while(true){echo "\r                       \r";$res=$timr-time(); if($res < 1){break;}echo date('i:s',$res);sleep(1);}}
