#!/usr/bin/env php
<?php
/**
 * Build script for phar archive
 */

// Import the helper functions
require_once("src/helpers/colorize.php");
require_once("src/helpers/decorateString.php");
require_once("src/helpers/twrite.php");

twrite("Building the fsc.phar\r\n\r\n\r\n");
twrite(colorize("Checking for existing phar build\r\n", "90"));

// Check for a current Build
// As this isn't a very large archive at the moment, we can just delete and
// start from scratch
if (file_exists("build/fsc.phar")) {
    twrite(colorize("\tThere is already a build file present, attempting to delete it\r\n", "93"));
    // If a build exists we try to delte it simply for a "clean slate" to start
    // from
    if (unlink("build/fsc.phar")) {
        twrite(colorize(strtoupper("\t\tPrevious build deleted\r\n\r\n\r\n"), 32));
    }
}

$srcRoot   = __DIR__ . "/src/";
$buildRoot = __DIR__ . "/build/";

twrite(colorize("Creating fsc.phar in " . __DIR__ . $buildRoot . "\r\n\r\n", "94"));

$phar = new \Phar(
    $buildRoot . "fsc.phar",
    \FilesystemIterator::CURRENT_AS_FILEINFO | \FilesystemIterator::KEY_AS_FILENAME,
    "fsc.phar"
);

$phar->setStub($phar->createDefaultStub("index.php"));

// Beging adding all the files in
// @TODO For some reason Phar::buildFromDirectory is not adding files. While it's
// not a big issue right now, if more files are added, this could get very
// unmanageable
$phar["index.php"]                  = file_get_contents($srcRoot . "index.php");
$phar["templates/actions.txt"]      = file_get_contents($srcRoot . "templates/actions.txt");
$phar["templates/api.txt"]          = file_get_contents($srcRoot . "templates/api.txt");
$phar["templates/constants.txt"]    = file_get_contents($srcRoot . "templates/constants.txt");
$phar["templates/stores.txt"]       = file_get_contents($srcRoot . "templates/stores.txt");
$phar["help.php"]                   = file_get_contents($srcRoot . "help.php");
$phar["helpers/colorize.php"]       = file_get_contents($srcRoot . "helpers/colorize.php");
$phar["helpers/decorateString.php"] = file_get_contents($srcRoot . "helpers/decorateString.php");
$phar["helpers/twrite.php"]         = file_get_contents($srcRoot . "helpers/twrite.php");
clearstatcache();
twrite(
    "Built phar archive "
    . $buildRoot
    . "fsc.phar ("
    . filesize($buildRoot . "fsc.phar")
    . "b)\r\n"
);
twrite(colorize("All done, enjoy\r\n\r\n", 32));
sleep(1);
