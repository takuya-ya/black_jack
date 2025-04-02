<?php

namespace BlackJack;

use BlackJack\Dealer;
use BlackJack\Deck;
use BlackJack\Player;
use BlackJack\StrongCpu;

class PlayerFactory
{
    public $players = [];
    // 各プレイヤーのインスタンス作成
    public function __construct(private Dealer $dealer, private Deck $deck, private array $playerNames)
    {
        // プレイヤー名とクラス名の配列(これはコンストに渡すこと)
        $infos = [
            ['name' => $playerNames[0], 'className' => Player::class],
            ['name' => $playerNames[1], 'className' => StrongCpu::class],
            ['name' => $playerNames[2], 'className' => NormalCpu::class]
        ];

        foreach ($infos as $info) {
            // 配列の名前とクラス名を変数に代入して、下記に渡す
            $name = $info['name'];
            $className = $info['className'];
            $this->players[$name] = new $className($dealer);
            // 確かプレイヤーがユーザーのみだった時のコード↓
            // $this->players[$playerName] = new Player($dealer, $playerName);
        }
    }
}
