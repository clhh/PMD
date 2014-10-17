<?
$define=$GLOBALS['define'];
$use=$GLOBALS['use'];

$define("config",array("login"),function($require,$exports){
	$log=$require("/login");
	$exports->get=function()use($log){
		return $log["login"]("treemonster","******");
		//place your username and password here
	};
});
