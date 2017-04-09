<?php

class TConfig
{

    var $baseFolder = __DIR__;

    var $sourceFolder = "";

    var $functions = [
        "__"
    ];

    var $skipFolders = [
        "vendor",
        "storage"
    ];

    var $languageFiles = [
        "resources/lang/nl.json"
    ];

    var $keepUnused = true;

    var $outPath = "resources/lang/temp";
}

?>