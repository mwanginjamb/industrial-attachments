<?php

namespace frontend\models;

/**
 * This is the ActiveQuery class for [[LongListApplication]].
 *
 * @see LongListApplication
 */
class LongListApplicationQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return LongListApplication[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return LongListApplication|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
