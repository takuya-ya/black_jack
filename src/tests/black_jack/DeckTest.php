<?php

namespace BlackJack\Tests;

use PHPUnit\Framework\TestCase;
use BlackJack\Deck;
use BlackJack\Card;

class DeckTest extends TestCase
{
    public function testConstructInitializeProperty()
    {
        $deck = new Deck(new Card());
        // カードの枚数を確認
        $this->assertSame(52, count($deck->cardDeck));
        // カードの重複を確認
        $this->assertSame(count($deck->cardDeck), count(array_unique($deck->cardDeck)));
        // 処理前と処理後のカードが同じ内容か（順不同）
        $this->assertEqualsCanonicalizing($deck->card->cards, $deck->cardDeck);
    }

    public function testDrawCard()
    {
        $deck = new Deck(new Card());
        $drawnCard = $deck->drawCard(2);

        // カードの枚数を確認
        $this->assertSame(2, count($drawnCard));
        //　引いたカードが山札から削除されているか確認
        $this->assertSame(false, in_array($drawnCard[0], $deck->cardDeck));
        $this->assertSame(false, in_array($drawnCard[1], $deck->cardDeck));
    }
}
