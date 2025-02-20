<?php

namespace BlackJack\Tests;

use PHPUnit\Framework\TestCase;
use BlackJack\PokerOutput;

class PokerOutputTest extends TestCase
{
    private $pokerOutput;
    public function setUp(): void
    {
        // TestCaseのメソッド呼出し
        parent::setUp();
        // デフォルトモック値を設定
        $this->pokerOutput = new PokerOutput();
    }
    public function testDisplayPlayerCard()
    {
        $this->expectOutputString(
            "takuyaの引いた1枚目のカードは0です。" . PHP_EOL .
            "takuyaの引いた2枚目のカードは1です。" . PHP_EOL
        );
        $pokerOutput = new PokerOutput();
        $pokerOutput->displayPlayerCard(['takuya' => [0, 1]], ['takuya']);
    }

    public function testDisplayDealerCard()
    {
        $this->expectOutputString(
            "ディーラーの引いたカードは0です。" . PHP_EOL .
            "ディーラーの引いた2枚目のカードはわかりません。" . PHP_EOL . PHP_EOL
        );
        $pokerOutput = new PokerOutput();
        $pokerOutput->displayDealerCard([0, 1]);
    }

    public function testDisplayDealerTurn()
    {
        $this->expectOutputString(
            "ディーラーの引いたカードはH3です。" . PHP_EOL
        );
        $this->pokerOutput->displayDealerTurn('H3');
    }

    public function testDisplayAddDealerCard()
    {
        $this->expectOutputString(
            "ディーラーの引いた2枚目のカードはH2でした。" . PHP_EOL
        );
        $this->pokerOutput->displayAddDealerCard(['dealerHand' => ['H1', 'H2']]);
    }

    public function testDisplayDealerScore()
    {
        $this->expectOutputString(
            "ディーラーの現在の得点は10です。" . PHP_EOL .
            PHP_EOL
        );
        $this->pokerOutput->displayDealerScore(10);
    }

    public function testDisplayPlayerWinMessage()
    {
        $message = $this->pokerOutput->DisplayPlayerWinMessage();
        $this->assertSame('あなたの勝ちです。', $message);
    }

    public function testDisplayYourLoseMessage()
    {
        $message = $this->pokerOutput->displayYourLoseMessage();
        $this->assertSame('あなたの負けです。', $message);
    }

    public function testDisplayPlayerScore()
    {
        $this->expectOutputString(
            "あなたの現在の得点は10です。カードを引きますか？（Y/N）" . PHP_EOL
        );
        $this->pokerOutput->displayPlayerScore(10);
    }

    public function testDisplayAddPlayerCard()
    {
        $this->expectOutputString(
            "あなたの引いたカードはH1です。" . PHP_EOL
        );
        $this->pokerOutput->displayAddPlayerCard('H1');
    }

    public function testDisplayGameResult()
    {
        $winner = $this->pokerOutput->displayGameResult(21, 18, 'takuya');
        $this->assertSame('takuya', $winner);
    }
}
