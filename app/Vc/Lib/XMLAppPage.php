<?php

declare(strict_types=1);
namespace App\Vc\Lib;

use XMLView\Widgets\Base\XMLResourcePage;

/**
 * Pages that allready the XML VC's need some app specific page header. This is not
 * possible yet in the XML VC's so this is
 *
 */
class XMLAppPage extends XMLResourcePage
{
    function themeHeader():void
    {
        $this->theme->app_page_XMLPage->themeHeader();
    }
}