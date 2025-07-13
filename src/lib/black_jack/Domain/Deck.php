<?php

namespace BlackJack\Domain;

use BlackJack\Domain\Card;

class Deck
{
    // ゲームで使用する山札
    public array $cardDeck = [];
    public array $drawnCard = [];

    public function __construct(public Card $card)
    {
        shuffle($this->card->cards);
        $this->cardDeck = $this->card->cards;
    }

    public function drawCard(int $drawCardNum): array
    {
        // 山札からカードを取得し、取得したカードは山札から削除
        $this->drawnCard = array_splice($this->cardDeck, 0, $drawCardNum);
        return $this->drawnCard;
    }
}
