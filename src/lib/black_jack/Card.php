<?php

namespace BlackJack;

class Card
{
    public $cards = [];
    public function __construct()
    {
        $suits = ['S', 'H', 'D', 'K'];
        $cardNumber = array_merge(range(2, 10), ['J', 'Q', 'K', 'A']);

        foreach ($suits as $suit) {
            foreach ($cardNumber as $cardNum) {
                $this->cards[] = "$suit" . "$cardNum";
            }
        }
    }
}
