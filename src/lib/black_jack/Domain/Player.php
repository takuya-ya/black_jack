<?php

namespace BlackJack\Domain;

use BlackJack\Domain\Dealer;

class Player
{
    private array $hand = [];
    public function __construct(
        public Dealer $dealer,
        public string $playerName
    ) {}

    //手札取得処理の変更に対応させる、また、手札プロパティ変更を防止の為、メソッドを通して手札情報を取得。
    public function getHand(): array
    {
        return $this->hand;
    }

    // 初回手札を取得
    public function drawStartHand(): void
    {
        $this->hand = $this->dealer->dealStartHands();
    }

    public function addCard(): array
    {
        return $this->dealer->dealAddCard();
    }
}
