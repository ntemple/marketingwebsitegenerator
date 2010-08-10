#!/usr/bin/php
<?php

# rm -f files-$1.txt
# svn diff --summarize https://marketingwebsitegenerator.googlecode.com/svn/tags/script/mwg-1.2.0 https://marketingwebsitegenerator.googlecode.com/svn/tags/script/mwg-$version | grep -v test |  grep -v "^D" | cut -b 84- > files-$version.txt

$version = $argv[1];
$files = "files-$version.txt";
if (! file_exists($files)) {
  echo("Could not find $files\n");
  die(1);
}

$lines = file($files);
$lines[] = "templates/.htaccess";
`rm -rf out`;
@mkdir("out");
foreach ($lines as $line) {
  $line = trim($line);
 $in = "./mwg-$version/$line";
 $out = "./out/"; // $line";
 $cmd =  "cp --parents $in $out";
 `$cmd`;
# print "$cmd\n";
}
`mv out/mwg-$version/templates/ out/mwg-$version/templates-$version`;
`cd out/mwg-$version; zip -r ../../mwg-$version-1.2.0-update.zip *`;
echo "s3cmd -P put mwg-$1-1.2.0-update.zip s3://network.intellispire.com/mwg/core/1.2/\n";



