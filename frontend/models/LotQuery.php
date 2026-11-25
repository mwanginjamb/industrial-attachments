<?php

namespace frontend\models;
use Yii;

/**
 * This is the ActiveQuery class for [[Lot]].
 *
 * @see Lot
 */
class LotQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * SQL condition for "the application window is open on :lotActiveDate".
     * Mirrors Lot::getIsActive(): the window runs from (opening - deadlineDays - windowDays)
     * to the application deadline (opening - deadlineDays), inclusive on both days.
     */
    private function activeCondition($date)
    {
        $windowDays = (int) Yii::$app->params['lotApplicationWindowDays'];     // 75, counted back from the deadline
        $deadlineDays = (int) Yii::$app->params['lotApplicationDeadlineDays']; // 14, counted back from opening
        $startDays = $windowDays + $deadlineDays;

        return new \yii\db\Expression(
            "(:lotActiveDate >= DATE_SUB(DATE(opening_date), INTERVAL {$startDays} DAY)"
            . " AND :lotActiveDate <= DATE_SUB(DATE(opening_date), INTERVAL {$deadlineDays} DAY))",
            [':lotActiveDate' => $date ?: date('Y-m-d')]
        );
    }

    // Lots whose application window is open (same rule as Lot::getIsActive())
    public function active($date = null)
    {
        return $this->andWhere($this->activeCondition($date));
    }

    // Order lots with an open application window first
    public function orderByActive($date = null)
    {
        $cond = $this->activeCondition($date);

        return $this->addOrderBy(new \yii\db\Expression("CASE WHEN {$cond->expression} THEN 1 ELSE 0 END DESC", $cond->params));
    }

    /**
     * {@inheritdoc}
     * @return Lot[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Lot|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
