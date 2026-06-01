<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "lot".
 *
 * @property int $id
 * @property string|null $description
 * @property string|null $opening_date
 * @property string|null $closing_date
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property Application[] $applications
 */
class Lot extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lot';
    }

    public function behaviors()
    {
        return [
            \yii\behaviors\BlameableBehavior::class,
            \yii\behaviors\TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'opening_date', 'closing_date', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'default', 'value' => null],
            [['description'], 'string'],
            [['opening_date', 'closing_date'], 'safe'],
            [['created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'description' => 'Description',
            'opening_date' => 'Opening Date',
            'closing_date' => 'Closing Date',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * Gets query for [[Applications]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getApplications()
    {
        return $this->hasMany(Application::class, ['lot_id' => 'id']);
    }

    /**
     * generate milestone for lots
     */

    public function getApplicationsCount()
    {
        return $this->hasMany(Application::class, ['lot_id' => 'id'])->count();
    }

    //  Milestone 1: get lot application deadline (2 weeks before closing date)

    public function getApplicationDeadline()
    {
        if (!$this->closing_date) {
            return null;

        }

        return date('Y-m-d', strtotime($this->closing_date . ' -2 weeks'));
    }

    // Milestone 2: get Placement deadline (2 weeks after closing date)

    public function getPlacementDeadline()
    {
        if (!$this->closing_date) {
            return null;
        }

        return date('Y-m-d', strtotime($this->closing_date . ' +2 weeks'));
    }

    // retrun structured lot milestone data for frontend display

    public function getMilestones()
    {
        return [
            [
                'title' => 'Application Deadline',
                'date' => $this->getApplicationDeadline(),
                'description' => $this->description
            ],
            [
                'title' => 'Placement Deadline',
                'date' => $this->getPlacementDeadline(),
                'description' => $this->description
            ],
        ];
    }

    public function getIsActive()
    {
        $date = date('Y-m-d');
        $days = Yii::$app->params['lotApplicationWindowDays'];

        return (
            strtotime($date) >= strtotime("-{$days} days", strtotime($this->opening_date))
            &&
            strtotime($date) < strtotime($this->opening_date)
        );
    }



}
