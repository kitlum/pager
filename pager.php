<?php
class Paginator {
   private $currentPage;
   private $currentItem;
   private $pageNumber;
   private $pcsPerPage;
   private $sorter;
   private $ascending;
   private $itemNumber;
   private $shownPages;
   private $selectors=array();
      
   public function set_parameters($tableName, $currentPage, $sorter, $ascending, $pcsPerPage, $shownPages, $selectors=array())
   {
     $this->tableName=$tableName;
     $this->selectors=$selectors;
	 $this->currentPage=$currentPage;
	 $this->sorter=$sorter;
	 $this->ascending=$ascending;
	 $this->pcsPerPage=$pcsPerPage;
	 $this->shownPages=$shownPages;
	 $output=$this->core();
	 return $output;
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
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		$mysqli->query("SET NAMES utf8");
		$content=array();
		if ($this->selectors=array()){
		$query="SELECT COUNT(*) FROM `".$this->tableName."` WHERE 1";
		}else{
			$query="SELECT COUNT(*) FROM `".$this->tableName."` WHERE";
			$i=0;
			if (empty($this->selectors))
			$query.=" 1" ;
			foreach ($this->selectors as $key->$value){
			  if ($i!=0){
				  $query .=" AND ";
			  }
			  $i++;
			  $query.=" ".$key;
			  if (count($value)==1)
			  {
				$query.="=".$value[0];
			  }else if(count($value)==2){
				$query.=" BETWEEN ".$value[0]." AND ".$value[1];
			  }  
			}		  
		}
	  $result=$mysqli->query($query);
	  $a=$result->fetch_row();
	  $itemNumber=$a[0]; 
	  $result->free();
	  if ($this->selectors==array()){
		$query="SELECT * FROM `".$this->tableName."` WHERE 1 ";
		}else{
			$query="SELECT * FROM'".$this->tableName."` WHERE";
			$i=0;
			foreach ($this->selectors as $key->$value){
			  if ($i!=0){
				  $query.=" AND ";
			  }
			  $i++;
			  $query.=" ".$key;
			  if (count($value)==1)
			  {
				$query.="=".$value[0];
			  }else if(count($value)==2){
				$query=" BETWEEN ".$value[0]." AND ".$value[1];
			  }  
			}		  
		}
	  $query.="ORDER BY `".$this->sorter."`";
	  if ($this->ascending){
		  $query.=" ASC";
	  }else{
		  $query.=" DESC";
	  }
	  $query.=" LIMIT ".$this->currentItem.",".$this->pcsPerPage;
      echo $query;		   
	  $result=$mysqli->query($query);  
	  $this->pageNumber=$itemNumber/$this->pcsPerPage;
	  while ($a=$result->fetch_assoc()){
		  $rawcontent[]=$a;
	  }
	  $result->free();
	  $mysqli->close();
	  if($this->currentPage>$this->pageNumber)  
	  $this->currentPage=$this->pageNumber;
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
