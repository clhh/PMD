<?
$define=$GLOBALS['define'];
$use=$GLOBALS['use'];

$define("fsock",function($require,$exports,$module){
	$module->exports=function($method,$url,$cookie="",$data=""){
		$fp=fsockopen("ssl://github.com",443);
		if($cookie)$cookie=$cookie;
		if($data&&$method==="POST")$data=http_build_query($data);
		fwrite($fp,"$method $url HTTP/1.1\r\n".
			"Host: github.com\r\n".
			"Connection: Close\r\n".
			"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8\r\n".
			"User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.101 Safari/537.36\r\n".
			"Accept-Encoding: gzip\r\n".
			"Accept-Language: zh-CN,zh;q=0.8,en;q=0.6\r\n".
			"Cookie: $cookie\r\n".
			($method==="POST"?"Content-Type: application/x-www-form-urlencoded\r\n":"").
			"Content-Length: ".strlen($data)."\r\n\r\n$data"
		);
		$response="";
    while(!feof($fp)){$response.=fgets($fp, 4096);}
		$bd="";
		$hb=explode("\r\n\r\n",$response);
		$body=$hb[1];
		$chunk=strtok($body,"\r\n");
		while($len=(hexdec($chunk)+0)){
			$start=strlen($chunk)+2;
			$bd.=substr($body,$start,$len);
			$body=substr($body,$start+$len+2);
			$chunk=strtok($body,"\r\n");
		}
		return array(
			"header"=>$hb[0],
			"body"=>@gzinflate(substr($bd,10)),
			"cookies"=>getCookie($hb[0])
		);
	};
  function getCookie($str){
    $r="";
    preg_match_all('/Set-Cookie\:\s(.+?)=(.+?);/i',$str,$out);
    for($i=0,$str=array();$i<count($out[1]);$i++){
        $r.=$out[1][$i]."=".$out[2][$i]."; ";
        $str[$out[1][$i]]=$out[2][$i];
    }
    return array($str,$r);
	}
});
