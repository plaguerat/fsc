#!/usr/bin/env php
<?php
fwrite(STDOUT, "Building the phar archive\r\n");

fwrite(STDOUT, "Checking for existing phar build\r\n");

if (file_exists("build/fsc.phar")) {
    fwrite(STDOUT, "There is already a build file present, attempting to delete it\r\n");
    if (unlink("build/fsc.phar")) {
        fwrite(STDOUT, "Previous build deleted\r\n");
    }
}

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
$phar["helpers/colorize.php"]    = file_get_contents($srcRoot . "helpers/colorize.php");
$phar["helpers/decorateString.php"]    = file_get_contents($srcRoot . "helpers/decorateString.php");
// $phar->buildFromDirectory($srcRoot . "templates");
fwrite(STDOUT, "All done, enjoy");
