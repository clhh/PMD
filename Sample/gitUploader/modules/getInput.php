<?
$define=$GLOBALS['define'];
$use=$GLOBALS['use'];

ini_set('pcre.backtrack_limit',9e8);
$define("getInput",function($require,$exports,$module){
	$module->exports=function($body,$name,$find="<"){
		return preg_replace('/^[\s\S]+?name="'.$name.'".+?value="(.+?)"[\s\S]+$/','$1',substr($body,strpos($body,$find)));
	};
});
