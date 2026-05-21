<?php

namespace frontend\models;

/**
 * This is the ActiveQuery class for [[PlacementArea]].
 *
 * @see PlacementArea
 */
class PlacementAreaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return PlacementArea[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PlacementArea|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
