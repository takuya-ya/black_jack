<?php

namespace BlackJack;

use BlackJack\Dealer;
use BlackJack\Deck;
use BlackJack\Player;
use BlackJack\StrongCpu;
use BlackJack\NormalCpu;

class PlayerFactory
{
    public $players = [];

    // プレイヤー毎に異なる処理が必要なため、個別のインスタンスを作成
    public function __construct(private Dealer $dealer, private Deck $deck, private array $playerNames)
    {
        // 文字列(例'Player')の場合、名前空間が識別できずエラーになる場合があるため、::class(完全修飾クラス名)を使用
        $infos = [
            ['name' => $playerNames[0], 'className' => Player::class],
            ['name' => $playerNames[1], 'className' => StrongCpu::class],
            ['name' => $playerNames[2], 'className' => NormalCpu::class]
        ];

        foreach ($infos as $info) {
            $name = $info['name'];
            $className = $info['className'];
            $this->players[$name] = new $className($dealer);
        }
    }
}
