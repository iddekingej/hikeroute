<?php 
declare(strict_types=1);
namespace App\Vc\User;

use XMLView\Engine\Data\DataLayer;
use XMLView\Engine\Data\DataItemStore;
use XMLView\Engine\Data\DataStore;

class ProfileDataLayer implements DataLayer{
    
    function processData(DataStore $p_parent):DataStore
    {
        $l_user=$p_parent->getValue("user");        
        return new DataItemStore($p_parent, $l_user);        
    }
}