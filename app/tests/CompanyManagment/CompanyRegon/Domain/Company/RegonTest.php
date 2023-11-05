<?php

namespace App\Tests\CompanyManagment\CompanyRegon\Domain\Company;

use CompanyManagment\CompanyRegon\Domain\Company\Exception\RegonInvalid;
use CompanyManagment\CompanyRegon\Domain\Company\Regon;
use PHPUnit\Framework\TestCase;

class RegonTest extends TestCase
{
    public function testRegonCanBeCreated(): void
    {
        $regon = Regon::create('070569406');

        $this->assertSame($regon->getRegon(), '070569406');
    }

    /**
     * @dataProvider invalidRegonProvider
     */
    public function testExceptionThorownWhenInvalidRegon($invalidRegon)
    {

        $this->expectException(RegonInvalid::class);
        $this->expectExceptionMessage("Invalid regon number.");

        $regon = Regon::create($invalidRegon);
    }

    public function invalidRegonProvider()
    {

        return [
            ['070569408'],
            ['0705694081'],
            ['070569408a'],
        ];
    }
}
