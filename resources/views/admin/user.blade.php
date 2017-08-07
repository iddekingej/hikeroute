<?php

use App\Vc\Admin\UserAdminPage;

$l_page=new UserAdminPage($cmd, $user, $errors);
$l_page->display();

