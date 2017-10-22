<?php
declare(strict_types=1);
namespace App\Vc\Route;

use App\Models\Route;
use XMLView\Engine\Data\DataStore;

class OverviewLayer extends RoutePageLayer
{
    protected function routeData(DataStore $p_store,Route $p_route):void
    {
        $p_store->setValue("images",$p_route->summaryImages);
        $p_store->setValue("hasAlbumImages",!$p_route->summaryImages->isEmpty());
    }

}