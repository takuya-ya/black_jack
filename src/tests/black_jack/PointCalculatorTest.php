<?php

namespace BlackJack\Tests;

use PHPUnit\Framework\TestCase;
use BlackJack\PointCalculator;

class PointCalculatorTest extends TestCase
{
    public function testPointCalculator()
    {
        $pointCalculator = new PointCalculator();
        $point = $pointCalculator->calculatePoint(['H3', 'H1']);
        $this->assertSame(4, $point);
        $point = $pointCalculator->calculatePoint(['HQ', 'DK', 'K1']);
        $this->assertSame(21, $point);
        $point = $pointCalculator->calculatePoint(['HQ', 'DK', 'KA']);
        $this->assertSame(21, $point);
        $point = $pointCalculator->calculatePoint(['SJ', 'KK', 'SA']);
        $this->assertSame(21, $point);
        $point = $pointCalculator->calculatePoint(['S4', 'KA', 'S1']);
        $this->assertSame(15, $point);
    }
}
