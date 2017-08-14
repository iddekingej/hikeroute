<?php 

use App\Vc\Lib\Engine\Gui\XMLResourcePage;

/**
 * Display View based on a resources file 
 * 
 * @param string $p_resourceFile XML Resource file 
 * @param array $p_data          Extra /parameter data to view
 */
function XMLView(string $p_resourceFile,Array $p_data=[]):void
{
    $l_file=new XMLResourcePage();
    $l_file->setResourceFile($p_resourceFile);
    $l_store=new MapData($p_data);
    $l_file->display($l_store);
}