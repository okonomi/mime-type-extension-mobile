<?php

require_once 'PHPUnit/Framework/TestSuite.php';

require_once dirname(__FILE__) . '/MobileTestCase.php';


class AllTests
{
    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite();

        $suite->addTestSuite('MIME_Type_Extension_MobileTestCase');

        return $suite;
    }

}
