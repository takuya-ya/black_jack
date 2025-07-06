<?php

namespace BlackJack;

class PointCalculator
{
    const FACE_CARD_VALUE = 10;
    const ACE_HIGH_VALUE = 10;
    const ACE_LOW_VALUE = 1;

    public function calculatePoint(array $hand): int
    {
        $ranks = [];
        $score = 0;
        // 手札カードのrankを抽出するため、スートを除去。
        foreach ($hand as $card) {
            $rank = substr($card, 1);

            // rankがJ,Q,Kの場合に10を代入
            $aceAndFaceCards = ['J', 'Q', 'K'];
            if (in_array($rank, $aceAndFaceCards)) {
                $rank = self::FACE_CARD_VALUE;
            }
            // rankがAの場合、スコアに応じてAを変換
            if (str_contains($rank, 'A')) {
                $rank = ($score <= 11) ? self::ACE_HIGH_VALUE : self::ACE_LOW_VALUE;
            }
            $ranks[] = (int)$rank;
            // 手札スコアを計算するため、$ranksを合算。
            $score = array_sum($ranks);
        }
        // 出力
        return $score;
    }
}
