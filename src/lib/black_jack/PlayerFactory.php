<?php

namespace BlackJack;

use BlackJack\Dealer;
use BlackJack\Deck;

class PlayerFactory
{
    public $players = [];
    // 各プレイヤーのインスタンス作成
    public function __construct(private Dealer $dealer, private Deck $deck, private array $playerNames)
    {
      foreach ($this->playerNames as $playerName) {
          $this->players[$playerName] = new Player($this->dealer, $playerName);
      }
    }
}
