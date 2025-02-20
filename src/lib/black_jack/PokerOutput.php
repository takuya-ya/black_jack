<?php

namespace BlackJack;

class PokerOutput
{
    public function displayPlayerCard(array $playerHands): void
    {
        foreach ($playerHands as $playerName => $playerHand) {
            echo "{$playerName}の引いた1枚目のカードは{$playerHand[0]}です。" . PHP_EOL;
            echo "{$playerName}の引いた2枚目のカードは{$playerHand[1]}です。" . PHP_EOL;
        }
    }

    public function displayDealerCard(array $dealerHand): void
    {
        echo "ディーラーの引いたカードは{$dealerHand[0]}です。" . PHP_EOL;
        echo 'ディーラーの引いた2枚目のカードはわかりません。' . PHP_EOL;
        echo PHP_EOL;
    }

    public function displayDealerTurn(string $drawnLastCard): void
    {
        echo "ディーラーの引いたカードは{$drawnLastCard}です。" . PHP_EOL;
    }

    public function displayAddDealerCard(array $hands): void
    {
        echo "ディーラーの引いた2枚目のカードは{$hands['dealerHand'][1]}でした。" . PHP_EOL;
    }

    public function displayDealerScore(int $dealerScore): void
    {
        echo "ディーラーの現在の得点は{$dealerScore}です。" . PHP_EOL;
        echo PHP_EOL;
    }

    public function displayPlayerWinMessage(): void
    {
        echo "あなたの勝ちです。";
    }

    public function displayDealerBurstMessage(): void
    {
        echo "ディーラーがバーストしました。あなたの勝ちです。" . PHP_EOL;
    }


    public function displayYourLoseMessage(): void
    {
        echo "あなたの負けです。";
    }

    public function displayGameEndMessage(): void
    {
        echo "ゲームを終了します。" . PHP_EOL;
    }

    public function displayPlayerScore(int $playerScore): void
    {
        echo "あなたの現在の得点は{$playerScore}です。カードを引きますか？（Y/N）" . PHP_EOL;
    }

    public function displayAddPlayerCard(string $drawnLastCard): void
    {
        echo "あなたの引いたカードは{$drawnLastCard}です。" . PHP_EOL;
    }

    public function displayGameResult(int $playerScore, int $dealerScore, string $winner): string
    {
        echo "あなたの得点は{$playerScore}です。" . PHP_EOL;
        echo "ディーラーの得点は{$dealerScore}です。" . PHP_EOL;
        echo PHP_EOL;
        echo "{$winner}の勝ちです！" . PHP_EOL;
        return $winner;
    }
}
