<?php

/*
Sample atoum configuration file to have tests results in xUnit format.
Do "php path/to/test/file -c path/to/this/file" or "php path/to/atoum/scripts/runner.php -c path/to/this/file -f path/to/test/file" to use it.
*/

use \mageekguy\atoum;

// This will ad the default CLI report
$script->addDefaultReport();


// Generate a xUnit report.
$xunitWriter = new atoum\writers\file('ci/logs/atoum.xunit.xml');
$xunitReport = new atoum\reports\asynchronous\xunit();
$xunitReport->addWriter($xunitWriter);
$runner->addReport($xunitReport);

// Generate a clover report
$cloverWriter = new atoum\writers\file('ci/logs/atoum.clover.xml');
$cloverReport = new atoum\reports\asynchronous\clover();
$cloverReport->addWriter($cloverWriter);
$runner->addReport($cloverReport);

// Generate a HTML report
$coverageHtmlField = new atoum\report\fields\runner\coverage\html('Coverage','ci/html/coverage');
// $coverageHtmlField->setRootUrl('http://url/of/web/site');
$script->addDefaultReport()->addField($coverageHtmlField);
