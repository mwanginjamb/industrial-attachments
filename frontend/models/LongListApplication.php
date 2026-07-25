<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "long_list_application".
 *
 * @property int $id
 * @property int|null $long_list_id
 * @property int|null $application_id
 * @property int|null $shortlisted
 * @property string|null $remarks
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property Application $application
 * @property LongList $longList
 */
class LongListApplication extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'long_list_application';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['long_list_id', 'application_id', 'remarks', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'default', 'value' => null],
            [['shortlisted'], 'default', 'value' => 0],
            [['long_list_id', 'application_id', 'shortlisted', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['remarks'], 'string'],
            [['long_list_id', 'application_id'], 'unique', 'targetAttribute' => ['long_list_id', 'application_id']],
            [['application_id'], 'exist', 'skipOnError' => true, 'targetClass' => Application::class, 'targetAttribute' => ['application_id' => 'id']],
            [['long_list_id'], 'exist', 'skipOnError' => true, 'targetClass' => LongList::class, 'targetAttribute' => ['long_list_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'long_list_id' => 'Long List ID',
            'application_id' => 'Application ID',
            'shortlisted' => 'Shortlisted',
            'remarks' => 'Remarks',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * Gets query for [[Application]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getApplication()
    {
        return $this->hasOne(Application::class, ['id' => 'application_id']);
    }

    /**
     * Gets query for [[LongList]].
     *
     * @return \yii\db\ActiveQuery|LongListQuery
     */
    public function getLongList()
    {
        return $this->hasOne(LongList::class, ['id' => 'long_list_id']);
    }


    public function getLot()
    {
        return $this->hasOne(
            Lot::class,
            ['id' => 'lot_id']
        );
    }

    public function getPlacement()
    {
        return $this->hasOne(
            PlacementArea::class,
            ['id' => 'placement_id']
        );
    }


    /**
     * {@inheritdoc}
     * @return LongListApplicationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LongListApplicationQuery(get_called_class());
    }


    public function beforeSave($insert)
    {
        if (!$insert) {

            if (
                $this->longList &&
                $this->longList->status === 'CLOSED'
            ) {
                $this->addError(
                    'shortlisted',
                    'This long list has been finalized.'
                );

                return false;
            }
        }

        return parent::beforeSave($insert);
    }

}
