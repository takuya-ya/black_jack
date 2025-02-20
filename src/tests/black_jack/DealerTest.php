<?php

namespace BlackJack\Tests;

use PHPUnit\Framework\TestCase;
use BlackJack\Dealer;
use BlackJack\Deck;
use BlackJack\Card;

class DealerTest extends TestCase
{
    public function testDealStartCard()
    {
        $expectedCards = ['K1', 'D1'];
        $deckMock = $this->createMock(Deck::class);
        $deckMock->expects($this->once())
            ->method('drawCard')
            ->with(2)
            ->willReturn($expectedCards);

        $dealer = new Dealer($deckMock);
        $result = $dealer->dealStartHands($deckMock);

        // カードの枚数を確認
        $this->assertSame($expectedCards, $result);
    }

    public function testDealAddCard()
    {
        $deck = new Deck(new Card());
        $dealer = new Dealer($deck);

        // カードの枚数を確認
        $this->assertSame(1, count($dealer->dealAddCard($deck)));
    }
}
