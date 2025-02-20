<?php

namespace BlackJack\Tests;

use PHPUnit\Framework\TestCase;
use BlackJack\GameProcess;
use BlackJack\Card;
use BlackJack\Deck;
use BlackJack\Dealer;
use BlackJack\Player;
use BlackJack\PointCalculator;
use BlackJack\PokerOutput;

class GameProcessTest extends TestCase
{
    private $handle = '';
    private $deck;
    private $dealer;
    private $pointCalculator;
    private $pokerOutput;
    private $dealerMock;

    public function setUp(): void
    {
        // TestCaseのメソッド呼出し
        parent::setUp();
        // デフォルトモック値を設定
        $this->handle = fopen('php://temp', 'r+');
        $this->deck = new Deck(new Card());
        $this->dealer = new Dealer($this->deck);
        $this->pointCalculator = new PointCalculator();
        $this->pokerOutput = new PokerOutput();

        $this->dealerMock = $this->createMock(Dealer::class);
        $this->dealerMock->method('dealAddCard')->willReturn(['H6']);
    }

    public function tearDown(): void
    {
        fclose($this->handle);
        // TestCaseのメソッド呼出して初期化
        parent::tearDown();
    }

    public function testSetUpHands()
    {
        $expectedPlayer = ['H1', 'D3'];
        $expectedDealer = ['K1', 'K2'];
        $playerMock = $this->getMockBuilder(Player::class)
                ->setConstructorArgs([$this->dealer, 'takuya'])
                ->getMock(); //モックインスタンスの作成
        $playerMock->method('getHand')->willReturn($expectedPlayer);

        $this->dealerMock->method('dealStartHands')->willReturn($expectedDealer);

        // 返り値として、プライヤーとディーラーの手札を含む配列を確認
        $gameProcess = new GameProcess($this->dealerMock, $this->deck, $this->pointCalculator, $this->pokerOutput);
        $hands = $gameProcess->setUpHands([$playerMock]);
        $this->assertSame(['playerHands' => ['takuya' => $expectedPlayer], 'dealerHand' => $expectedDealer], $hands);

        // TODO:複数プレイヤーの場合
    }

    public function testDealerTurn()
    {
        $gameProcess = new GameProcess($this->dealerMock, $this->deck, $this->pointCalculator, $this->pokerOutput);
        $dealerScore = $gameProcess->dealerTurn(['D1', 'DA'], 11);
        $this->assertSame(23, $dealerScore);
    }

    public function testAddDealerCard()
    {
        $gameProcess = new GameProcess($this->dealerMock, $this->deck, $this->pointCalculator, $this->pokerOutput);
        // 返り値を確認
        $dealerScore = $gameProcess->addDealerCard(['dealerHand' => ['D10', 'D5']]);
        $this->assertSame(21, $dealerScore);
    }

    public function testAddYourTurn()
    {
        // setUp::addCardに設定した帰り値が上書き出来なかった為、モックを初期化
        $this->dealerMock = $this->createMock(Dealer::class);
        $this->dealerMock->method('dealAddCard')
                ->willReturnOnConsecutiveCalls(['D3'], ['K10']);

        $player = new Player($this->dealerMock, 'takuya');

        // 返り値の確認
        fwrite($this->handle, "Y\nN\n"); // ユーザー入力の代替値を設定
        rewind($this->handle); //ストリームポインタをリセット

        $gameProcess = new GameProcess($this->dealerMock, $this->deck, $this->pointCalculator, $this->pokerOutput, $this->handle);

        $playerScore = $gameProcess->addYourTurn(['D6', 'D7'], $player);
        $this->assertSame(16, $playerScore);

        // スコアが21を超えた場合に、バースト判定の確認
        fwrite($this->handle, "Y\nY\n");
        rewind($this->handle);

        $message = $gameProcess->addYourTurn(['D6', 'D7'], $player);
        $this->assertSame('あなたの負けです。', $message);
    }

    public function testCheckBurnOut() {
        $gameProcess = new GameProcess($this->dealerMock, $this->deck, $this->pointCalculator, $this->pokerOutput);
        $this->assertSame(true, $gameProcess->checkBurnOut(22));
    }
    // public function testJudgeWinner()
    // {
    //     $deck = new Deck(new Card());
    //     $pointCalculator = new PointCalculator();

    //     $mock = $this->createMock(Dealer::class);

    //     // 返り値の確認
    //     $gameProcess = new GameProcess($mock, $this->deck, $this->pointCalculator, $this->pokerOutput);
    //     $winner = $gameProcess->judgeWinner(21, 20, 'takuya');
    //     $this->assertSame('takuya', $winner);
    //     $winner = $gameProcess->judgeWinner(20, 21, 'takuya');
    //     $this->assertSame('ディーラー', $winner);
    // }
}
