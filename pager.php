<?php


class Paginator {
   
   var $pageNumber;
   var $pcsPerPage;
   var $sorter;
   var $ascending;
   var $itemNumber;
      

   public function set_parameters($pageNumber, $sorter, $ascending=true, $pcsPerPage=10, $shownPages=3)
   {
     if ((is_numeric($pageNumber))&&(($pageNumber>=0))){
   $this->pageNumber=$pageNumber;
   }
   else
   {
   $this->error("Неверно указана текущая страница");
   return;
   }
     if (is_numeric($pcsPerPage)){
   $this->pcsPerPage=$pcsPerPage;
   }
   else
   {
   $this->error("Неверно указано количество обьектов на странице");
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
   $this->core();
   }
   
  
   public function __construct()
   {}
   
   public function __destruct()
   {}
   
   private function error($text)
   {return ($text);}
   
   private function core()
   {
   $this->get_itemNumber();
   $this->connect();
   $this->get_content();
   $this->get_pages();
   $this->get_result();
   }
   
   private function get_itemNumber()
   {
   $this->itemNumber=($this->pageNumber+1)*($this->pcsPerPage);
   }
   
   private function connect()
   {}
   
   private function get_result()
   {}
   
   private function get_pages()
   {}
   
   private function get_content()
   {}
}

$a = new Paginator();
$a->set_parameters(1,"se");
echo "b";
