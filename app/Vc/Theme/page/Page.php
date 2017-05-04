<?php 
declare(strict_types=1);
namespace App\Vc\Theme\Page;

use App\Vc\Lib\ThemeItem;

class Page extends ThemeItem
{
    function pageHeader($p_title,Array $p_js,Array $p_css)
    {
?>
<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- CSRF Token -->
<meta name="csrf-token" content="<?=$this->e(csrf_token())?>">
<title><?=$this->e($p_title)?></title>
<link href="/css/main.css" rel="stylesheet" />
<script type='text/javascript' src='/js/core.js'></script>
<script type='text/javascript' src='/js/main.js'></script>
<?php
foreach($p_css as $l_css){
    ?><link href='<?=$this->e($l_css)?>' rel='stylesheet' /><?php   
}
foreach($p_js as $l_js){
    ?>
    <script type='text/javascript' src='<?=$this->e($l_js)?>'></script>
    <?php    
}
?>
</head>
<body>
	<div class="apptitle">
		<table class="apptitle_table">
			<tr>
				<td class="apptitle_title"><?=__("Hiking routes")?></td>
				<td class="apptitle_name">
					<?php if(!\Auth::user()){?>
					| <a class="buttonLink"	href="<?=route('login')?>"><?=__("Login")?></a>
					&nbsp; <a class="buttonLink" href="<?=route('register')?>"><?=__("Register")?></a>
					 <? } else {?>
					 <a href="{{ Route('user.profile') }}"	class="apptitle_name">
					 <?=\Auth::user()?\Auth::user()->name:__("Guest")?>
					</a>
					<?php }?>
				</td>
			</tr>
		</table>
	</div>
<?php       
    }
    function note($p_message)
    {
        ?><div class="page_hint"><?=$this->e($p_message)?></div><?php
    }
    
    function pageFooter()
    {
?>
</body>
</html>
<?php      
    }
    
    

}
?>