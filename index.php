<?php
include "pager.php";
$a = new Paginator();
$b=$a->set_parameters();
$c=$b['pager'];
$d=$b['content'];

for ($i=0;$i<count($c);$i++){
echo $c[$i]."|";
}
