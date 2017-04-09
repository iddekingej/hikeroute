<?php
namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Checks if value is a integer, if not than the request is aborted
     * with a 500.
     *
     * @param integer $p_value            
     */
    function checkInteger($p_value)
    {
        if (! is_numeric($p_value)) {
            abort(500);
        }
    }

    /**
     * Displays and error page
     *
     * @param String $p_message
     *            Message to display
     * @return unknown
     */
    protected function displayError(string $p_message)
    {
        return View("errors.notallowed", [
            "message" => $p_message
        ]);
    }
}
