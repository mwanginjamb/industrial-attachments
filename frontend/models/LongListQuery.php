<?php

namespace frontend\models;

/**
 * This is the ActiveQuery class for [[LongList]].
 *
 * @see LongList
 */
class LongListQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return LongList[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return LongList|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
