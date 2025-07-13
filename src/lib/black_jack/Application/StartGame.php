<?php

namespace BlackJack\Application;

require dirname(__DIR__, 3) . "/vendor/autoload.php";

use BlackJack\Domain\Card;
use BlackJack\Domain\Deck;
use BlackJack\Domain\Dealer;
use BlackJack\Application\Game;
use BlackJack\Application\GameProcess;
use BlackJack\Support\PokerOutput;
use BlackJack\Domain\PointCalculator;
use BlackJack\Support\PlayerFactory;

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
