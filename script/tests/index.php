<?php
require_once('simpletest/unit_tester.php');
require_once('simpletest/reporter.php');
require_once('../lib/init.inc.php');


$test = &new GroupTest('All Tests');


$files = `find .  | grep \\\\.test\\\\.php`;
$files = explode("\n", $files);
foreach ($files as $file) {
 if($file) $test->addTestFile($file);
}

if (TextReporter::inCli()) {
    exit ($test->run(new TextReporter()) ? 0 : 1);
}
$test->run(new HtmlReporter());



