<?
include "pager_config.php";
include "db_config.php";
include "pager.php";

class Coditioner
{

public __set($name, $value)
{
	if (!empty($this->data[$name]){
	$this->data[$name]=$value;

	}
}

public get_data()
{
	$this->mysqli=new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if (!empty($this->data["tableName"])){
		$query="SHOW TABLES FROM ".DB_NAME;
	    $result=$this->mysqli->query($query);
		while $row=$result->fetch_row(){
			if (!empty($this->tableName)){
				$this->tableName=($row[0]==$this->data["tableName"])?$row[0];
			}
		} 
		$result->free();
		$this->tableName=empty($this->tableName)?TABLENAME;
	}
	if (!empty($this->data["selectors"])){	
		$query="SHOW COLUMNS FROM ".$this->tableName;
		$result=$this->mysqli->query($query);
		while $row=$result->fetch_assoc(){
			foreach ($this->data["selectors"] as $key->$value){
				if !empty($this->selectors[$key]){
					$this->selectors[$key]=($row["field"]==$key)?$value;	
				}	
			}
			if !empty($this->sorter){
			$this->sorter=($row["field"]==$this->data["sorter"])?$row["field"];
		}
		result->free();
		$this->sorter=empty($this->sorter)?SORTER;
	}
	$this->mysqli->close();
	}
   $this->currentPage=(is_numeric($this->data["currentPage"])&&(($this->data["currentPage"]>=1)))?$this->data["currentPage"]:CURRENTPAGE;
   $this->pcsPerPage=(is_numeric($this->data["pcsPerPage"])&&(($this->data["pcsPerPage"]>=1)))?$this->data["currentPage"]:PCSPERPAGE;
   $this->shownPages=(is_numeric($this->data["shownPages"])&&(($this->data["shownPages"]>=1)))?$this->data["shownPages"]:SHOWNPAGES;
   $this->ascending=(is_bool($this->data["ascending"]))?$this->data["ascending"]:ASCENDING;
   $pager=new Paginator();
   $result=$pager->set_parameters($this->tableName, $this->currentPage, $this->sorter, $this->ascending, $this->pcsPerPage, $this->shownPages, $this->selectors);
   return ($result);
   
}

public __construct()
{}
public __destruct()
{}	
}
