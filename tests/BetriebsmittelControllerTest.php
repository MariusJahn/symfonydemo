<?php

namespace App\Tests;

use App\Controller\BetriebsmittelController;
use App\Entity\Betriebsmittel;
use PHPUnit\Framework\TestCase;

class BetriebsmittelControllerTest extends TestCase
{
    public function testSomething(): void
    {
        $betriebsmittel = new Betriebsmittel();

        $betriebsmittel->setName("test");

        $this->assertEquals($betriebsmittel->getName(), "test");
    }



}
