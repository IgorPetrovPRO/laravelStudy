<?php

namespace Tests\Unit\Support\ValueObjects;

use Support\ValueObject\Price;
use Tests\TestCase;

class PriceTest extends TestCase
{
    /** @test */

    public function it_all():void
    {
        $price = Price::make(10000);

        $this->assertInstanceOf(Price::class,$price);
        $this->assertEquals(100, $price->value());
        $this->assertEquals(10000,$price->raw());
        $this->assertEquals('RUB' , $price->currency());
        $this->assertEquals('₽',$price->symbol());
        //TODO
        //$this->assertEquals('100 ₽',$price); не отрабатывает верно

        $this->expectException(\InvalidArgumentException::class);

        Price::make(-10000);
        Price::make(10000,'USD');


    }
}
