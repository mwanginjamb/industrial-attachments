<?php

namespace frontend\models;

use common\jobs\ApplicationStatusNotificationJob;
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
const STATUS_SELECTED = 5;
const STATUS_UNSUCCESSFUL = 6;




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
     * Gets query for [[Status0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus0()
    {
        return $this->hasOne(ApplicationStatus::class, ['id' => 'status']);
    }

    // longlist memmbership

    public function getLongListApplications()
    {
        return $this->hasMany(LongListApplication::class, ['application_id' => 'id']);
    }

    // If placement field is updated , update status to review
   /* public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if (!$insert && $this->isAttributeChanged('placement')) {
                $this->status = self::STATUS_UNDER_REVIEW;
            }
            return true;
        }
        return false;
    }
        */


    // Current longList application

    public function getCurrentLongListItem()
    {
        return $this->hasOne(LongListApplication::class, ['application_id' => 'id']);
    }


    // change detection for status attr

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if (!isset($changedAttributes['status'])) {
            return;
        }

        if ($changedAttributes['status'] == $this->status) {
            return;
        }

        $supportedStatuses = [
            self::STATUS_SUBMITTED,
            self::STATUS_UNDER_REVIEW,
            self::STATUS_SELECTED,
            self::STATUS_UNSUCCESSFUL,
        ];

        if (!in_array($this->status, $supportedStatuses)) {
            return;
        }

        $job =  new ApplicationStatusNotificationJob([
            'applicationId' => $this->id,
            'status' => $this->status
        ]);
       Yii::$app->queue->push($job);
    }

    

   

}
