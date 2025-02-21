<?php

namespace BlackJack;

use BlackJack\Dealer;
use BlackJack\Deck;
use BlackJack\Player;
use BlackJack\PointCalculator;
use BlackJack\PokerOutput;

class GameProcess
{
    public function __construct(
        public Dealer $dealer,
        public Deck $deck,
        public PointCalculator $pointCalculator,
        public PokerOutput $pokerOutput,
        private $inputHandle = null // テスト時に、ストリームハンドルを代入
    ) {
        $this->inputHandle = $inputHandle ?? STDIN; // nullの場合は標準入力から入力を受ける
    }

    public function setUpHands(array $players): array
    {
        // 全プレイヤーの初回手札作成。配列はプレイヤー名をキーとする連想配列。
        foreach ($players as $player) {
            $player->drawStartHand();
            $playerHands[$player->playerName] = $player->getHand();
        }

        // ディーラーの初回カード取得。
        $dealerHand = $this->dealer->dealStartHands($this->deck);

        // 各自の手札を出力
        $this->pokerOutput->displayPlayerCard($playerHands);
        $this->pokerOutput->displayDealerCard($dealerHand);

        // $playerHandsはプレイヤー名 => 手札 の連想配列
        $hands = ['playerHands' => $playerHands, 'dealerHand' => $dealerHand];
        return $hands;
    }

    // バースト判定
    public function checkBurnOut(int $score): bool {
        if ($score > 21) {
            return true;
        }
        return false;
    }

    // バースト時の処理
    public function processDealerBurnOut(int $dealerScore): bool
    {
        // バースト判定　バーストであれば、trueを受け取る
        $isBurnOut = $this->checkBurnOut($dealerScore);
        if($isBurnOut) {
            $this->pokerOutput->displayDealerBurstMessage();
            return true;
        }
        return false;
    }

    // ディーラーのカード取得
    public function addDealerCard(array $hands): int
    {
        // ディーラーのスコア計算　
        $dealerScore = $this->pointCalculator->calculatePoint($hands['dealerHand']);
        // ディーラーの2枚目のカードを開示
        $this->pokerOutput->displayAddDealerCard($hands);

        // 追加カードを取得
        $dealerScore = $this->dealerTurn($hands['dealerHand'], $dealerScore);
        return $dealerScore;
    }

    // ディーラーの追加カード取得判断のロジック
    private const DRAW_STOP_SCORE = 17;
    public function dealerTurn(array $dealerHand, int $dealerScore): int
    {
        // dealerのカードが規定値以下の場合、カードを取得
        while (self::DRAW_STOP_SCORE >= $dealerScore) {
            // カードを取得、山札から。
            $dealerHand = array_merge($dealerHand, $this->dealer->dealAddCard($this->deck));
            // 引いたカードを出力する為、変数に代入
            $drawnLastCard = end($dealerHand);
            // 手札のスコアを計算して出力
            $dealerScore = $this->pointCalculator->calculatePoint($dealerHand);
            // ディーラーが引いたカードを出力
            $this->pokerOutput->displayDealerTurn($drawnLastCard);
        }
        return $dealerScore;
    }

    // プレイヤーの追加カード取得
    public function addYourTurn(array $hand, Player $player)
    {
        while (true) {
            //プレイヤーのスコアを計算
            $playerScore = $this->pointCalculator->calculatePoint($hand);

            // バーストしていた場合はゲーム終了
            if ($playerScore > 21) {
                return $this->pokerOutput->displayYourLoseMessage();
            }

            // 現在のスコアを出力
            $this->pokerOutput->displayPlayerScore($playerScore);
            // ユーザー入力を変数へ代入
            $input = trim(fgets($this->inputHandle));

            // 追加のカードを引く場合
            if ($input == 'Y') {
                // 追加のカードを取得し、プレイヤー手札に代入
                $hand = array_merge($player->addCard(), $hand);
                // 手札の最後の値を取得し、値＝追加カードをユーザーへ表示
                $drawnLastCard = end($hand);

                // 追加カードを出力
                $this->pokerOutput->displayAddPlayerCard($drawnLastCard);
                continue;
            }
            // TODO プレイヤー名=>スコアの連想配列　
            return $playerScore;
        }
    }

    // TODO CPUの追加カード取得し処理

    public function judgeWinner(int $playerScore, int $dealerScore, array $playerName): string
    {
        $winner = 'ディーラー';
        if ($playerScore > $dealerScore) {
            $winner = $playerName;
        }

        // 勝者名を出力
        return $this->pokerOutput->displayGameResult($playerScore, $dealerScore, $winner);
    }
}
