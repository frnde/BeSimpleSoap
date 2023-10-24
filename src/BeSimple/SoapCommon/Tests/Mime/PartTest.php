<?php

/*
 * This file is part of the BeSimpleSoapBundle.
 *
 * (c) Christian Kerl <christian-kerl@web.de>
 * (c) Francis Besset <francis.besset@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace BeSimple\SoapCommon\Tests;

use BeSimple\SoapCommon\Mime\AbstractPart;
use BeSimple\SoapCommon\Mime\AbstractPartHeader;

class PartTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $p = new AbstractPart('<xml1/>', 'text/xml', 'utf-8', AbstractPart::ENCODING_BINARY, 'urn:myuniqueresource');

        $this->assertEquals('<xml1/>', $p->getContent());
        $this->assertEquals('text/xml', $p->getHeader('Content-Type'));
        $this->assertEquals('utf-8', $p->getHeader('Content-Type', 'charset'));
        $this->assertEquals(AbstractPart::ENCODING_BINARY, $p->getHeader('Content-Transfer-Encoding'));
        $this->assertEquals('<urn:myuniqueresource>', $p->getHeader('Content-ID'));
    }

    public function testDefaultConstructor()
    {
        $p = new AbstractPart();

        $this->assertNull($p->getContent());
        $this->assertEquals('application/octet-stream', $p->getHeader('Content-Type'));
        $this->assertEquals('utf-8', $p->getHeader('Content-Type', 'charset'));
        $this->assertEquals(AbstractPart::ENCODING_BINARY, $p->getHeader('Content-Transfer-Encoding'));
        $this->assertRegExp('~<urn:uuid:.*>~', $p->getHeader('Content-ID'));
    }

    public function testSetContent()
    {
        $p = new AbstractPart();

        $p->setContent('<xml1/>');
        $this->assertEquals('<xml1/>', $p->getContent());
    }

    public function testGetMessagePart()
    {
        $p = new AbstractPart('<xml1/>', 'text/xml', 'utf-8', AbstractPart::ENCODING_BINARY, 'urn:myuniqueresource');

        $messagePart = "Content-Type: text/xml; charset=utf-8\r\n" .
        "Content-Transfer-Encoding: binary\r\n" .
        "Content-ID: <urn:myuniqueresource>\r\n" .
        "\r\n".
        "<xml1/>";

        $this->assertEquals($messagePart, $p->getMessagePart());
    }
}
