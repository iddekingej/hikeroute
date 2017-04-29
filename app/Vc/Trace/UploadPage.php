<?php 
declare(strict_types=1);
namespace App\Vc\Trace;

use App\Vc\Lib\HtmlPage;
use App\Lib\Frm;


class UploadPage extends HtmlPage{
    private $errors;

    function __construct($p_errors){
        $this->errors=$p_errors;
        parent::__construct();
    }

    function content(){
        Frm::header(__("Upload new trace"),"traces.save", []);
        Frm::file("routefile",__("GPX file"),$this->errors);
        Frm::submit(Route("traces.list"));
    }
}