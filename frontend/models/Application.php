<?php

namespace frontend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "application".
 *
 * @property int $id
 * @property int|null $lot_id
 * @property int|null $attachee_id
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $placement
 * @property bool|null $closed
 *
 * @property Attachee $attachee
 * @property Lot $lot
 * @property ApplicationStatus $status0
 */
class Application extends \yii\db\ActiveRecord
{

    // status constants : submitted, under review, accepted, placed
    const STATUS_SUBMITTED = 1;
    const STATUS_UNDER_REVIEW = 2;
    const STATUS_ACCEPTED = 3;
    const STATUS_PLACED = 4;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'application';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            BlameableBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lot_id', 'attachee_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'default', 'value' => null],
            [['lot_id', 'attachee_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['attachee_id'], 'exist', 'skipOnError' => true, 'targetClass' => Attachee::class, 'targetAttribute' => ['attachee_id' => 'id']],
            [['lot_id'], 'exist', 'skipOnError' => true, 'targetClass' => Lot::class, 'targetAttribute' => ['lot_id' => 'id']],
            //[['status'], 'exist', 'skipOnError' => true, 'targetClass' => ApplicationStatus::class, 'targetAttribute' => ['status' => 'id']],

            [['placement'], 'integer'],
            [['closed'], 'boolean'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lot_id' => 'Lot ID',
            'attachee_id' => 'Attachee ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'placement' => 'Placement',
            'closed' => 'Closed',
        ];
    }

    /**
     * Gets query for [[Attachee]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAttachee()
    {
        return $this->hasOne(Attachee::class, ['id' => 'attachee_id']);
    }

    // Get Attache Institution
    public function getAttacheInstitution()
    {
        return $this->hasOne(Institution::class, ['id' => 'institution_id'])->via('attachee');
    }

    // Get Applications Placement Area
    public function getPlacementArea()
    {
        return $this->hasOne(PlacementArea::class, ['id' => 'placement']);
    }

    /**
     * Gets query for [[Lot]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLot()
    {
        return $this->hasOne(Lot::class, ['id' => 'lot_id']);
    }

    /**
     * Gets query for [[Status]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus0()
    {
        return $this->hasOne(ApplicationStatus::class, ['id' => 'status']);
    }

}
