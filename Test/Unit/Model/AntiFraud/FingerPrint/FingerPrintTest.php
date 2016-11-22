<?php
/**
 * @author      Webjump Core Team <dev@webjump.com>
 * @copyright   2016 Webjump (http://www.webjump.com.br)
 * @license     http://www.webjump.com.br  Copyright
 *
 * @link        http://www.webjump.com.br
 *
 */

namespace Webjump\BraspagPagador\Test\Unit\Model\AntiFraud\FingerPrint;


use Webjump\BraspagPagador\Model\AntiFraud\FingerPrint\FingerPrint;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Session\SessionManagerInterface;

class FingerPrintTest extends \PHPUnit_Framework_TestCase
{
    const SRC_PNG_IMG_URL = 'https://h.online-metrix.net/fp/clear.png';
    const SRC_JS_URL = 'https://h.online-metrix.net/fp/clear.png';
    const SRC_FLASH_URL = 'https://h.online-metrix.net/fp/clear.png';

    const ORG_ID = '1snn5n9w';

    const SESSION_ID = '123456789987654321';
    const MERCHANT_ID = 'BC5D3432-527F-40C6-84BF-C549285536BE';

    /** @var FingerPrint */
    private $fingerPrint;
    /** @var \PHPUnit_Framework_MockObject_MockObject */
    private $scopeFingerPrintMock;
    /** @var \PHPUnit_Framework_MockObject_MockObject */
    private $sessionMock;

    protected function setUp()
    {
        $this->scopeFingerPrintMock = $this->getMockBuilder(ScopeConfigInterface::class)
            ->getMockForAbstractClass();

        $this->sessionMock = $this->getMockBuilder(SessionManagerInterface::class)
            ->getMockForAbstractClass();
    }

    public function testGetSrcPngImageUrl()
    {
        $this->scopeFingerPrintMock->expects($this->once())
            ->method('getValue')
            ->with(FingerPrint::XML_SRC_PNG_IMAGE_URL)
            ->will($this->returnValue(self::SRC_PNG_IMG_URL));

        $this->fingerPrint = new FingerPrint($this->scopeFingerPrintMock, $this->sessionMock);

        $this->assertEquals(self::SRC_PNG_IMG_URL, $this->fingerPrint->getSrcPngImageUrl());
    }

    public function testGetSrcJsUrl()
    {
        $this->scopeFingerPrintMock->expects($this->once())
            ->method('getValue')
            ->with(FingerPrint::XML_SRC_JS_URL)
            ->will($this->returnValue(self::SRC_JS_URL));

        $this->fingerPrint = new FingerPrint($this->scopeFingerPrintMock, $this->sessionMock);

        $this->assertEquals(self::SRC_JS_URL, $this->fingerPrint->getSrcJsUrl());
    }

    public function testGetSrcFlashUrl()
    {
        $this->scopeFingerPrintMock->expects($this->once())
            ->method('getValue')
            ->with(FingerPrint::XML_SRC_FLASH_URL)
            ->will($this->returnValue(self::SRC_FLASH_URL));

        $this->fingerPrint = new FingerPrint($this->scopeFingerPrintMock, $this->sessionMock);

        $this->assertEquals(self::SRC_FLASH_URL, $this->fingerPrint->getSrcFlashUrl());
    }

    public function testGetOrgId()
    {
        $this->scopeFingerPrintMock->expects($this->once())
            ->method('getValue')
            ->with(FingerPrint::XML_ORG_ID)
            ->will($this->returnValue(self::ORG_ID));

        $this->fingerPrint = new FingerPrint($this->scopeFingerPrintMock, $this->sessionMock);

        $this->assertEquals(self::ORG_ID, $this->fingerPrint->getOrgId());
    }

    public function testGetSessionId()
    {
        $this->scopeFingerPrintMock->expects($this->once())
            ->method('getValue')
            ->with('payment/braspag_pagador_global/merchant_id')
            ->will($this->returnValue(self::MERCHANT_ID));

        $this->sessionMock->expects($this->once())
            ->method('getSessionId')
            ->will($this->returnValue(self::SESSION_ID));

        $this->fingerPrint = new FingerPrint($this->scopeFingerPrintMock, $this->sessionMock);

        $sessionIdExpected = self::SESSION_ID . self::MERCHANT_ID;

        $this->assertEquals($sessionIdExpected, $this->fingerPrint->getSessionId());
    }

}