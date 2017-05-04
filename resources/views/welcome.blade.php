<?php 
use App\Vc\HomePage;

$l_page=new HomePage($tree,$locations,$routes);
$l_page->display();