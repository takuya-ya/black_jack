<?php

namespace BlackJack\Tests;

use PHPUnit\Framework\TestCase;
use BlackJack\Card;

class CardTest extends TestCase
{
    public function testCardConstruct()
    {
        $card = new Card();
        $this->assertSame('S2', $card->cards[0]);
        $this->assertSame('SA', $card->cards[12]);
        $this->assertSame('H2', $card->cards[13]);
        $this->assertSame('HA', $card->cards[25]);
        $this->assertSame('D5', $card->cards[29]);
        $this->assertSame('D9', $card->cards[33]);
        $this->assertSame('K8', $card->cards[45]);
        $this->assertSame('KA', $card->cards[51]);
    }
}
