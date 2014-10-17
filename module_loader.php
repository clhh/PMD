<?
/* * * * * * * * * * * * * * * * *
 *    PHP module loader v1.0     *
 *  Code by 雾海树妖@2014-10-16  *
 * * * * * * * * * * * * * * * * */
$define=null;$use=null;
preg_replace_callback('/^/',
function()use(&$define,&$use){
  $modulePools=(array)NULL;
  $lists=(array)NULL;
  $define=function()use(&$modulePools,&$lists,&$define,&$use){

  	$a=func_get_args();$an=count($a);
  	while(count($a)<4)$a[count($a)]=NULL;
  	$f=function($r){
  		return preg_replace_callback('/^./',function($a){
  			return $a[0]==='/'?$a[0]:'/'.$a[0];
  		},$r);
  	};
    $id=$a[0];$depends=$a[1];$factory=$a[2];$_recall=$a[3];
    $m=&$modulePools;
    $s=&$lists;
    $e=(object)NULL;$e->exports=(object)NULL;
    $wait=false;

    //Format the parameters
    //The complete parameters should be $id,$depends,$factory,$_recall
    //$_recall represents the current $factory function is exists, not new define 
    switch($an){
    	case 1:$id='';$depends=array();$factory=$a[0];break;
    	case 2:
    	if(is_string($a[0])){
    		$id=$a[0];
    		$depends=array();$factory=$a[1];
    	}else{
    		$id='';$depends=$a[0];$factory=$a[1];
    	}
    	default:$id=$f($id);
    }

    //Give the error reporting if the module name was declared another place
    if(array_key_exists($id,$m)){
        die("<br/><b>Error</b>: Redeclare module '$id'<br/>");
    }

    //Add the parameters into tmp lists if required module(s) is not ready
    for($i=0,$q=array($id,$depends,$factory,true),
        $d=NULL;$i<count($depends);$i++){
        $u=$depends[$i];
        if(preg_match('/\.php$/',$u)){$use($u);continue;}
    	$d=$f($u);
    	if($wait=$wait?$wait:!array_key_exists($d,$m)){
    		if($_recall)break;
    		$s[$d]=array_key_exists($d,$s)?$s[$d]:array();
    		array_push($s[$d],$q);
    	}
    }
    if($wait)return true;

    //Call $factory method with $require,$exports,$module
    $factory(function($r)use(&$m,&$id){
    	$_id=$r[0]==='/'?array(''):explode('/',$id);
    	$r=explode('/',$r);
    	for($i=0;$i<count($r);$i++){
    		switch($r[$i]){
    			case '':continue;break;
    			case '..':array_pop($_id);
    			case '.':array_pop($_id);break;
    			default:array_push($_id,$r[$i]);
    		}
    	}
    	return (array)$m[implode('/',$_id)];
    },$e->exports,$e);

    //If current $id exists, add the module to modulePools
    if($id)$m[$id]=$e->exports;

    //Clear the tmp lists
    if(array_key_exists($id,$s)){
    	for($i=0;$i<count($s[$id]);$i++){
    		$k=$s[$id][$i];
    		if(!$define($k[0],$k[1],$k[2],$k[3]))unset($k);
    	}
      unset($s[$id]);
    }
  };

  //include one or more php files
  $use=function(){
    for($i=0,$a=func_get_args();$i<count($a);$i++)
        include_once($a[$i]);
  };
  /* module loader end */
},'');
