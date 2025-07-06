<?php

namespace BlackJack;

require '../../vendor/autoload.php';
use BlackJack\Card;
use BlackJack\Deck;
use BlackJack\Dealer;
use BlackJack\Game;
use BlackJack\GameProcess;
use BlackJack\PokerOutput;
use BlackJack\PointCalculator;
use BlackJack\PlayerFactory;

$players = ['takuya', 'toki', 'asuka'];
$card = new Card();
$deckInstance = new Deck($card);
$dealer = new Dealer($deckInstance);
$pokerOutput = new PokerOutput;
$pointCalculator = new PointCalculator();
$playerFactory = new PlayerFactory($dealer, $deckInstance, $players);
$gameProcess = new GameProcess($dealer, $deckInstance, $pointCalculator, $pokerOutput);
$game = new Game($dealer, $deckInstance, $gameProcess, $pointCalculator, $pokerOutput, $playerFactory, $players);
echo $game->start();
