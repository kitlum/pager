 <?php
 $a=array("action"=>"find_data", "request"=>array("currentPage"=>2, "pcsPerPage"=>5, "shownPages"=>3, "ascending"=>TRUE, "tableName"=>"pager", "sorter"=>"id"));
/*$a=json_decode($_POST['data']);*/
if ($a['action']=='find_data'){
	include "conditioner.class.php";
	$b=new Wrapper;
	foreach ($a["request"] as $key=>$value)
	{$b->$key=$value;}
}
$output=$b->get_data();
/*$output=json_encode($b);
return ($output)*/
print_r($output);
