@extends("layouts.page")
@section("content")


<?php
\App\Vc\RouteVC::routeSearch();
\App\Vc\RouteVC::searchByLocation($tree, $locations);
\App\Vc\RouteVC::printRoutesSummary($routes);
?>

@endsection