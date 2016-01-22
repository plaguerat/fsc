<?php
require_once("phar://fsc.phar/help.php");
require_once("phar://fsc.phar/helpers/colorize.php");
require_once("phar://fsc.phar/helpers/decorateString.php");

fwrite(STDOUT, "One moment\r\n\r\n");
sleep(1);

$shortOpts = "h";

// Arguments that should be passed in
$longOpts = [ "store:", "storepath:" ];

// Get the arguments/options from input
$opts = getopt($shortOpts, $longOpts);
if (isset($opts["h"])) {
    displayHelp();
    exit();
}

// Without a store name, there is no need to proceed
if (! isset($opts["storepath"])) {
    fwrite(STDOUT, colorize(strtoupper("no storepath entered, aborting!!! \r\n\r\n\r\n"), 31));
    exit(1);
}

// If the store isn't set, we can't really do anything
if (! isset($opts["store"])) {
    fwrite(STDOUT, colorize(strtoupper("no store entered, aborting!!! \r\n\r\n\r\n"), 31));
    exit(1);
}

// Remove any trailing slash to make things nice and uniform
$storePath = preg_replace("~/$~", "", $opts["storepath"]);

// Due to some issue with file_exists, we need to use absolute paths
// @TODO This might be overcome by checking if it is relative and prepending the
// directory to it
if (preg_match("~^\.~", $storePath)) {
    fwrite(STDOUT, colorize("Please use absolute paths\r\n\r\n", 34));
    exit;
}
$storeName = $opts["store"];

// Don't think we need to add this since we're using absolute paths.
// This will change if relative paths are allowed

// We have, at a minimun, the stores directory
fwrite(STDOUT, colorize("Time to create some new flux architecture\r\n\r\n", 4));
fwrite(STDOUT, "Store name: " . colorize($storeName, 34) . "\r\n");

// Begin creating things :-)
$lowerReplace = "[__type__]";
$upperReplace = "[__u_type__]";

$searches = [
    "[_lower_]"      => strtolower($storeName),
    "[_upper_]"      => strtoupper($storeName),
    "[_capitalize_]" => ucfirst($storeName)
];

$parseString = function ($template) use ($searches) {
    return str_ireplace(
        array_keys($searches),
        array_values($searches),
        file_get_contents("phar://fsc/templates/" . $template)
    );
};

$files = [
    "actions"   => "Actions",
    "api"       => "API",
    "constants" => "Constants",
    "stores"     => "Store"
];

foreach ($files as $key => $value) {
    $dirPath = sprintf("%s/%s", $storePath, $key);
    if (! is_dir($dirPath)) {
        fwrite(
            STDOUT,
            colorize(
                sprintf(
                    "%s directory not found in %s\r\n\tAttempt to create it (Y/N) (N will skip):",
                    $key,
                    $storePath
                ),
                37
            )
        );
        $create = trim(fgets(STDIN));
        if (strcasecmp("Y", $create) === 0) {
            fwrite(STDOUT, colorize("Attempting to create directory\r\n", 32));
            if (! @mkdir($dirPath)) {
                fwrite(STDOUT, colorize("Could not create Directory, skipping\r\n", 37));
                sleep(2);
                continue;
            }
            fwrite(STDOUT, colorize("Directory successfully created", 32));
        } else {
            fwrite(STDOUT, colorize("Skipping!", 35));
            continue;
        }
    }
    $filepath = sprintf("%s/%s/%s%s.jsx", $storePath, $key, $storeName, $value);
    fwrite(STDOUT, "\r\n\r\nChecking " . $filepath . "\r\n");
    if (file_exists($filepath)) {
        fwrite(STDOUT, "\t" . colorize(colorize(strtoupper("file exists, overwrite(Y/N): "), "1"), 34));
        $overwrite = trim(fgets(STDIN));
        if (strcasecmp($overwrite, "y") !== 0) {
            fwrite(STDOUT, colorize("Skipping " . $filepath . "\r\n", 32));
            continue;
        }
    }
    fwrite(STDOUT, colorize("\t ... Creating " . $filepath . "\r\n", 36));
    $template = $parseString($key . ".txt");
    file_put_contents($filepath, $template);
}

fwrite(
    STDOUT,
    colorize(
        colorize(
            "\r\n\r\nAll your file are ready to "
            . colorize("rock and roll", 1) . " \r\n\r\n\r\n",
            37
        ),
        1
    )
);
sleep(2);
