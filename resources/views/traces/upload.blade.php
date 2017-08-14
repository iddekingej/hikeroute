<?php
use App\Vc\Trace\UploadPage;

$l_page= new UploadPage($errors);
$l_page->setErrors($errors);
$l_page->display();