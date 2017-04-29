<?php 
use App\Vc\User\EditPage;

$l_editPage=new EditPage($user,$errors);
$l_editPage->display();

?>