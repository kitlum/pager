<?php
include "pager_config.php";
include "db_config.php";
include "pager.php";

class Wrapper{
	
	private $data=array();
	private $tableName;
	private $currentPage;
	private $sorter;
	private $ascending;
	private $pcsPerPage;
	private $shownPages;
	private $selectors=array();
	
public function __set($name, $value)
{
	if (!isset($this->data[$name]))
	$this->data[$name]=$value;
}
public function get_data()
{
	$mysqli=new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if (!empty($this->data["tableName"])){
		$query="SHOW TABLES FROM ".DB_NAME;
	    $result=$mysqli->query($query);
		while ($row=$result->fetch_row()){
			if (empty($this->tableName)){
				if($row[0]==$this->data["tableName"])
				$this->tableName=$row[0];
			}
		} 
		$result->free();
		if (empty($this->tableName))
		$this->tableName=TABLENAME;
	}
	if ((!empty($this->data["selectors"])) or (!empty($this->data["sorter"]))){	
		$query="SHOW COLUMNS FROM ".$this->tableName;
		$result=$mysqli->query($query);
		while ($row=$result->fetch_assoc()){
			if(!empty($this->data['selectors'])){
				foreach ($this->data["selectors"] as $key->$value){
					if (empty($this->selectors[$key])){
						if ($row["Field"]==$key)
							$this->selectors[$key]=$value;	
					}	
				}
			}
			if (empty($this->sorter)){
			if($row["Field"]==$this->data["sorter"])
			$this->sorter=$row["Field"];
			}
		}
		$result->free();
		if(empty($this->sorter))
		$this->sorter=SORTER;
	}
	$mysqli->close();
   $this->currentPage=(is_numeric($this->data["currentPage"])&&(($this->data["currentPage"]>=1)))?$this->data["currentPage"]:CURRENTPAGE;
   $this->pcsPerPage=(is_numeric($this->data["pcsPerPage"])&&(($this->data["pcsPerPage"]>=1)))?$this->data["pcsPerPage"]:PCSPERPAGE;
   $this->shownPages=(is_numeric($this->data["shownPages"])&&(($this->data["shownPages"]>=1)))?$this->data["shownPages"]:SHOWNPAGES;
   $this->ascending=(is_bool($this->data["ascending"]))?$this->data["ascending"]:ASCENDING;
   $pager=new Paginator();
   echo "1".!$this->data["ascending"];
   // echo($this->tableName.$this->currentPage.$this->sorter."'".$this->ascending."'".$this->pcsPerPage.$this->shownPages);
   $result=$pager->set_parameters($this->tableName, $this->currentPage, $this->sorter, $this->ascending, $this->pcsPerPage, $this->shownPages, $this->selectors);
   return ($result);
   
}
public function __construct()
{}
public function __destruct()
{}	
}
