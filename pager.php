<?php
include "pager_config.php";
include "db_config.php";

class Paginator {

   var $currentPage;
   var $currentItem;
   var $pageNumber;
   var $pcsPerPage;
   var $sorter;
   var $ascending;
   var $itemNumber;
      
   public function set_parameters($currentPage=CURRENTPAGE, $sorter=SORTER, $ascending=ASCENDING, $pcsPerPage=PCSPERPAGE, $shownPages=SHOWNPAGES)
   {
     if ((is_numeric($currentPage))&&(($currentPage>=1))){
   $this->currentPage=$currentPage;
   }
   else
   {
   $this->error("Invalid current page number");
   return;
   }
   
      if ((is_numeric($shownPages))&&(($shownPages>=1))){
   $this->shownPages=$shownPages;
   }
   else
   {
   $this->error("Invalid shown page number");
   return;
   }
   
     if (is_numeric($pcsPerPage)){
   $this->pcsPerPage=$pcsPerPage;
   }
   else
   {
   $this->error("Invalid items per page number");
   return;
   }
     $this->sorter=$sorter;
   
   if (is_bool($ascending)){
   $this->ascending=$ascending;
   }
   else
   {
   $this->error("Неверно указан порядок сортировки");
   return;
   }
   $a=$this->core();
   return ($a);
   }
   
  
   public function __construct()
   {}
   
   public function __destruct()
   {}
   
   private function error($text)
   {echo ($text);
	   exit;}
   
   private function core()
   {
   $this->get_currentItem();
   $this->get_content();
   $this->get_pages();
   $this->get_result();
   return $this->result;
   }
   
   private function get_currentItem()
   {
   $this->currentItem=($this->currentPage-1)*($this->pcsPerPage)+1;
   }
   
   
   private function get_result()
   {$this->result=array();
	$this->result['content']=$this->content;
	$this->result['pager']=$this->pager;
	   }
   
   private function get_pages()
   {
	$a=array();  
	
	if ($this->currentPage<=($this->shownPages+1)){
		for ($i=1;$i<$this->currentPage;$i++){
			$a[]=$i;   
		}
		}else{
			$a[]=1;
			$a[]="...";
		for ($i=($this->currentPage-$this->shownPages);$i<$this->currentPage;$i++){
			$a[]=$i;   
		}
	}
	$a[]="<b>".$this->currentPage."</b>";
	
	if (($this->currentPage+$this->shownPages)>=$this->pageNumber){
		for ($i=$this->currentPage+1; $i<=$this->pageNumber; $i++){
			$a[]=$i;
		}
	}else{
		for ($i=$this->currentPage+1; $i<=($this->currentPage+$this->shownPages); $i++){
			$a[]=$i;
		}
		$a[]="...";
		$a[]=$this->pageNumber;
	}
	$this->pager=$a;
	return;
	}
	
		
		
   
   private function get_content()
   {
	  $this->mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	  $this->mysqli->query("SET NAMES utf8");
	  $content=array();
	  $query="SELECT COUNT(*) FROM `pager` WHERE 1";
	  $result=$this->mysqli->query($query);
	  $a=$result->fetch_row();
	  $itemNumber=$a[0]; 
	  $result->free();
	  $query="SELECT * FROM `pager` WHERE 1 ORDER BY `".$this->sorter."` LIMIT ".$this->currentItem.",".$this->pcsPerPage;
	  $result=$this->mysqli->query($query);  
	  $this->pageNumber=$itemNumber/$this->pcsPerPage;
	  while ($a=$result->fetch_assoc()){
		  $rawcontent[]=$a;
	  }
	  $result->free();
	  $this->mysqli->close();
	    if ($this->currentPage>$this->pageNumber){
		  $this->error("invalid current page number");}
		if (defined("SHOWNFIELDS")){
			$b=explode(",",SHOWNFIELDS);
			foreach ($b as $value){
				foreach ($rawcontent as $key->$value1){
					if ($value==$key){
						$this->content[$key]=$value;
						}
					}
			}
		}else if (defined("UNSHOWNFIELDS")){
			$b=explode(",",SHOWNFIELDS);
			foreach ($b as $value){
				foreach ($rawcontent as $key->$value1){
					if ($value==$key){
						$this->content[$key]=$value;
						}
					}
			}
		}else{
			$this->content=$rawcontent;
		}
		return;
				  
	}
}


$a = new Paginator();
$b=$a->set_parameters();
$c=$b['pager'];
$d=$b['content'];

for ($i=0;$i<count($c);$i++){
echo $c[$i]."|";
}
