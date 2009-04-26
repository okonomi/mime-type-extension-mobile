<?php

require_once 'PHPUnit/Framework.php';
require_once 'MIME/Type/Extension/Mobile.php';


class MIME_Type_Extension_MobileTestCase extends PHPUnit_Framework_TestCase
{
    function testGetMIMEType()
    {
        $samples = array(
            'jpeg' => 'image/jpeg',
            'dmt'  => 'application/x-decomail-template',
        );

        $mimetype = new MIME_Type_Extension_Mobile();

        foreach ($samples as $extension => $mime) {
            $filename = "dummy.{$extension}";
            $this->assertEquals($mime,
                                $mimetype->getMIMEType($filename));
        }

        /* $filename = MIME_TYPE_EXTENSION_MOBILE_DATA_DIR.'/movie.3g2'; */
        /* $this->assertEquals('video/3gpp2', */
        /*                     $mimetype->getMIMEType($filename)); */

        $this->assertType('PEAR_Error',
                          $mimetype->getMIMEType('dummy.dmy'));
    }

    function testAddMIMEType()
    {
        $mimetype = new MIME_Type_Extension_Mobile();

        $this->assertType('PEAR_Error',
                          $mimetype->getMIMEType('dummy.dmy'));

        $mimetype->addMIMEType('dmy', 'application/x-dummy');
        $this->assertEquals('application/x-dummy',
                            $mimetype->getMIMEType('dummy.dmy'));

        $mimetype->addMIMETypes(array('dmy2' => 'application/x-dummy'));
        $this->assertEquals('application/x-dummy',
                            $mimetype->getMIMEType('dummy.dmy2'));
    }
}
