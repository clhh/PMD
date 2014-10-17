<?
require_once "module_loader.php";
set_time_limit(0);

/*
 * use the required modules
 * some modules can also write in $define function if they are not global modules
 */
$use(
	"modules/fsock.php",
	"modules/getInput.php",
	"modules/config.php",
	"modules/login.php"
);

//local folder scaner
function subFiles($dir,$parent=""){
	$result=(array)null;
	if(!$parent)$parent=$dir;
	foreach(scandir($dir) as $file)
		is_dir($path=$dir."\\".$file)?
		$file!="."&&$file!=".."&&
		($result=array_merge($result,subFiles($path,$parent))):
		array_push($result,substr($path,strlen($parent)+1));
	return $result;
}

//upload local folder to git
$dir="D:\workspace";

//this module only used in this $define function so it can be writed here
$define(array("modules/uploader.php"),function($require)use($dir){
	ini_set('zlib.output_compression',0);
	$upload=$require("/upload");
	$files=subFiles($dir);
	for($i=0;$i<count($files);$i++){
		$upload["uploadFile"](
			"PMD-FrameWork",//git repositories name
			str_replace('\\',"/",$files[$i]),
			$dir."\\".$files[$i]
		);
		echo $dir."\\".$files[$i]." complete!<br/>".str_repeat("\0",1024);
		flush();
	}
	echo 'All Files uploaded!<br/>';
});
