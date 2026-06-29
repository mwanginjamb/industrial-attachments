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
            [['description', 'opening_date', 'closing_date'], 'default', 'value' => null],
            [['description'], 'string'],
            [['description', 'opening_date', 'closing_date'], 'required'],
            [['opening_date', 'closing_date'], 'date', 'format' => 'php:Y-m-d\TH:i'],
            [['created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            // make description unique
            [['description'], 'unique'],
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

    // Applicant Count per Lot
    public function getApplicationsCount()
    {
        return $this->hasMany(Application::class, ['lot_id' => 'id'])->count();
    }

    // Pending  Review

    public function getReviewed()
    {
        return $this->hasMany(Application::class, ['lot_id' => 'id'])->andWhere(['is not', 'placement', null]);
    }

    public function getReviewedCount()
    {
        return $this->getReviewed()->count();
    }

    // Get Percentage for reviewed applications on this lot

    public function getPercentageReviewed()
    {
        $total = $this->getApplicationsCount();
        $reviewed = $this->getReviewedCount();

        if ($total == 0) {
            return 0;
        }

        return ($reviewed / $total);
    }


    //  Milestone 1: get lot application deadline (2 weeks before closing date)

    public function getApplicationStartDate()
    {
        if (!$this->opening_date) {
            return null;
        }
        $applicationWIndow = Yii::$app->params['lotApplicationWindowDays'];
        return date('Y-m-d', strtotime($this->opening_date . ' -' . $applicationWIndow . ' days'));
    }

    public function getApplicationDeadline()
    {
        if (!$this->opening_date) {
            return null;
        }

        return date('Y-m-d', strtotime($this->opening_date . ' -1 day'));
    }

    // Milestone 2: get Placement deadline (2 weeks after closing date)

    public function getPlacementDeadline()
    {
        if (!$this->closing_date) {
            return null;
        }

        $applicationProcessingWindow = Yii::$app->params['lotProcessingWindowDays'];
        return date('Y-m-d', strtotime($this->opening_date . ' -' . $applicationProcessingWindow . ' days'));
    }

    // retrun structured lot milestone data for frontend display

    public function getMilestones()
    {
        return [
            [
                'title' => 'Application Start Date',
                'date' => $this->getApplicationStartDate(),
                'description' => $this->description
            ],
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


    // Check if lot is active
    public function getIsActive()
    {
        if (empty($this->opening_date)) {
            return false;
        }
        // Application window (days)
        $days = Yii::$app->params['lotApplicationWindowDays'];
        $today = new \DateTime();
        $opening = new \DateTime($this->opening_date);
        $start = (clone $opening)->modify("-{$days} days");
        return ($today >= $start && $today < $opening);
    }

    public static function find()
    {
        return new LotQuery(get_called_class());
    }

    // convert opening and closing date to mysql format before saving to database
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            if (!empty($this->opening_date)) {
                $this->opening_date = date(
                    'Y-m-d H:i:s',
                    strtotime($this->opening_date)
                );
            }

            if (!empty($this->closing_date)) {
                $this->closing_date = date(
                    'Y-m-d H:i:s',
                    strtotime($this->closing_date)
                );
            }

            return true;
        }

        return false;
    }

    // During update preload DB values to form fields in the correct format
    public function afterFind()
    {
        parent::afterFind();

        if (!empty($this->opening_date)) {
            $this->opening_date = date(
                'Y-m-d\TH:i',
                strtotime($this->opening_date)
            );
        }

        if (!empty($this->closing_date)) {
            $this->closing_date = date(
                'Y-m-d\TH:i',
                strtotime($this->closing_date)
            );
        }
    }



}
