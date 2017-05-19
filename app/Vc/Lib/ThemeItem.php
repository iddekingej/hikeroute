<?php 
declare(strict_types=1);
namespace App\Vc\Lib;

class ThemeItem{
    
    protected $theme;
    
    function __construct(Theme $p_theme)
    {
        $this->theme=$p_theme;       
    }
    
    function __call($p_function,$p_args)
    {
        return call_user_func_array([$this->theme,$p_function],$p_args);
    }
    
    /**
     * Get the theme manager
     * 
     * @return \App\Vc\Lib\Theme
     */
    
    function getTheme()
    {
        return $this->theme;
    }
    
  

    

}