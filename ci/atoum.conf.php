<?php

/*
Sample atoum configuration file to have tests results in xUnit format.
Do "php path/to/test/file -c path/to/this/file" or "php path/to/atoum/scripts/runner.php -c path/to/this/file -f path/to/test/file" to use it.
*/

use \mageekguy\atoum;

/*
This will ad the default CLI report
*/
$script->addDefaultReport();

/*
Please replace in next line /path/to/destination/directory/atoum.xunit.xml by your output file for xUnit report.
*/
$xunitWriter = new atoum\writers\file('/phptest/ci/logs/atoum.xunit.xml');

/*
Generate a xUnit report.
*/
$xunitReport = new atoum\reports\asynchronous\xunit();
$xunitReport->addWriter($xunitWriter);

$runner->addReport($xunitReport);