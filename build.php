#!/usr/bin/env php
<?php
fwrite(STDOUT, "Building the phar archive\r\n");
$srcRoot   = __DIR__ . "/src/";
$buildRoot = __DIR__ . "/build/";

$phar = new \Phar(
    $buildRoot . "fsc.phar",
    \FilesystemIterator::CURRENT_AS_FILEINFO | \FilesystemIterator::KEY_AS_FILENAME,
    "fsc.phar"
);
$phar->setStub($phar->createDefaultStub("index.php"));
$phar["index.php"]               = file_get_contents($srcRoot . "index.php");
$phar["templates/actions.txt"]   = file_get_contents($srcRoot . "templates/actions.txt");
$phar["templates/api.txt"]       = file_get_contents($srcRoot . "templates/api.txt");
$phar["templates/constants.txt"] = file_get_contents($srcRoot . "templates/constants.txt");
$phar["templates/stores.txt"]    = file_get_contents($srcRoot . "templates/stores.txt");
$phar["help.php"]                = file_get_contents($srcRoot . "help.php");
// $phar->buildFromDirectory($srcRoot . "templates");
fwrite(STDOUT, "All done, enjoy");
