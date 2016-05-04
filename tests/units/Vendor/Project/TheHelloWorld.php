<?php
# tests/units/Vendor/Project/HelloWorld.php

// The test class has is own namespace :
// The namespace of the tested class + "test\units"
namespace Vendor\Project\tests\units;

// You must include the tested class (if you have no autoloader)
require_once __DIR__ . '/../../../../src/Vendor/Project/TheHelloWorld.php';

use atoum;

/*
 * Test class for Vendor\Project\HelloWorld
 *
 * Note that they had the same name that the tested class
 * and that it derives frim the atoum class
 */
class HelloWorld extends atoum
{
    /*
     * This method is dedicated to the getHiAtoum() method
     */
    public function testGetHiAtoum ()
    {
        $this
            // creation of a new instance of the tested class
            ->given($this->newTestedInstance)

            ->then

            // we test that the getHiAtoum method returns
            // a string...
            ->string($this->testedInstance->getHiAtoum())
            // ... and that this string is the one we want,
            // namely 'Hi atoum !'
            ->isEqualTo('Hi atoum !')
        ;
    }
}