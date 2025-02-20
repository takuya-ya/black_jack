<?php

namespace BlackJack\Tests;

use PHPUnit\Framework\TestCase;
use BlackJack\Dealer;
use BlackJack\Deck;
use BlackJack\PlayerFactory;

class PlayerFactoryTest extends TestCase
{
    public function testConstructInitializeProperty()
    {
        $dealerMock = $this->createMock(Dealer::class);
        $deckMock = $this->createMock(Deck::class);
        $playerNames = ['takuya', 'toki', 'asuka'];

        $factory = new PlayerFactory($dealerMock, $deckMock, $playerNames);
        $players = $factory->players;
        $this->assertCount(count($playerNames), $players);
    }
}
