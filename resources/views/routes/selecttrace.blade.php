<?php 
    use App\Vc\Route\SelectTracePage;

    $l_page=new SelectTracePage($traces, $next, $id_route);
    $l_page->display();
    