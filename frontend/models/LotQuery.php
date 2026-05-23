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

  public function active($date = null)
    {
        $date = $date ?: date('Y-m-d');

        // Application window (days)
        $days = Yii::$app->params['lotApplicationWindowDays'];

         return $this->andWhere([
            'and',
            ['<=', new \yii\db\Expression("DATE_SUB(opening_date, INTERVAL {$days} DAY)"), $date],
            ['>', 'opening_date', $date],
        ]);
    }

    // Add a scope for ordering by active state
    public function orderByActive($date = null)
    {
        $date = $date ?: date('Y-m-d');
        $days = Yii::$app->params['lotApplicationWindowDays'];

        return $this->addOrderBy(new \yii\db\Expression("
            CASE 
                WHEN '{$date}' >= DATE_SUB(opening_date, INTERVAL {$days} DAY)
                AND '{$date}' < opening_date
                THEN 1
                ELSE 0
            END DESC
        "));
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
