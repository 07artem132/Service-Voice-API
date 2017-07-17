<?php

namespace Doctrine\Tests\DBAL\Driver\Mysqli;

use Doctrine\DBAL\Driver\Mysqli\MysqliConnection;
use Doctrine\DBAL\Driver\Mysqli\MysqliException;
use Doctrine\Tests\DbalTestCase;

class MysqliConnectionTest extends DbalTestCase
{
    /**
     * The mysqli driver connection mock under test.
     *
     * @var \Doctrine\DBAL\Driver\Mysqli\MysqliConnection|\PHPUnit_Framework_MockObject_MockObject
     */
    private $connectionMock;

    protected function setUp()
    {
        if ( ! extension_loaded('mysqli')) {
            $this->markTestSkipped('mysqli is not installed.');
        }

        parent::setUp();

        $this->connectionMock = $this->getMockBuilder(MysqliConnection::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
    }

    public function testDoesNotRequireQueryForServerVersion()
    {
        $this->assertFalse($this->connectionMock->requiresQueryForServerVersion());
    }

    public function testRestoresErrorHandlerOnException()
    {
        $handler = function () { self::fail('Never expected this to be called'); };
        $default_handler = set_error_handler($handler);

        try {
            new MysqliConnection(['host' => '255.255.255.255'], 'user', 'pass');
            self::fail('An exception was supposed to be raised');
        } catch (MysqliException $e) {
            self::assertSame('Network is unreachable', $e->getMessage());
        }

        self::assertSame($handler, set_error_handler($default_handler), 'Restoring error handler failed.');
        restore_error_handler();
        restore_error_handler();
    }

    /**
     * @dataProvider secureMissingParamsProvider
     */
    public function testThrowsExceptionWhenMissingMandatorySecureParams(array $secureParams)
    {
        $this->expectException(MysqliException::class);
        $msg = '"ssl_key" and "ssl_cert" parameters are mandatory when using secure connection parameters.';
        $this->expectExceptionMessage($msg);

        new MysqliConnection($secureParams, 'xxx', 'xxx');
    }

    public function secureMissingParamsProvider()
    {
        return [
            [
                ['ssl_cert' => 'cert.pem']
            ],
            [
                ['ssl_key' => 'key.pem']
            ],
            [
                ['ssl_key' => 'key.pem', 'ssl_ca' => 'ca.pem', 'ssl_capath' => 'xxx', 'ssl_cipher' => 'xxx']
            ],
            [
                ['ssl_ca' => 'ca.pem', 'ssl_capath' => 'xxx', 'ssl_cipher' => 'xxx']
            ]
        ];
    }
}

