<? php
$a=json_decode($_POST['data']);
if ($a['action']=='find_data'){
	include conditioner.class.php;
	$b=new Condiitioner;
	$b->getData($a);
}
$output=json_encode($b);
return ($output)
