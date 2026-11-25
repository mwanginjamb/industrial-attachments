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
            [['description', 'opening_date', 'closing_date', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'default', 'value' => null],
            [['description'], 'string'],
            [['opening_date', 'closing_date'], 'safe'],
            [['created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
<<<<<<< HEAD
=======
            // make description unique
            [['description'], 'unique', 'message' => 'This lot description already exists. Please choose a different description.'],
            [['opening_date'], 'compare', 'compareAttribute' => 'closing_date', 'operator' => '<', 'type' => 'datetime', 'message' => 'Opening date must be before closing date.'],
            [['closing_date'], 'compare', 'compareAttribute' => 'opening_date', 'operator' => '>', 'type' => 'datetime', 'message' => 'Closing date must be after opening date.'],
            [['opening_date', 'closing_date'], 'validateDates'],
            // Date Range Validation: Ensure that the opening_date and closing_date is =>90 days apart
            [['opening_date', 'closing_date'], 'validateDateRange'],
            [['description', 'opening_date', 'closing_date'], 'required']
>>>>>>> Featshortlist
        ];
    }


    // Custom validation function to check if opening_date is before closing_date
    public function validateDates($attribute, $params)
    {
        if ($this->opening_date && $this->closing_date) {
            $openingDate = strtotime($this->opening_date);
            $closingDate = strtotime($this->closing_date);

            if ($openingDate >= $closingDate) {
                $this->addError('opening_date', 'Opening date must be before closing date.');
                $this->addError('closing_date', 'Closing date must be after opening date.');
            }
        }
    }

    // Validate that the opening_date and closing_date are at least 90 days apart
    public function validateDateRange($attribute, $params)
    {
        if ($this->opening_date && $this->closing_date) {
            $openingDate = strtotime($this->opening_date);
            $closingDate = strtotime($this->closing_date);

            $dateDifference = abs($closingDate - $openingDate);
            $daysDifference = floor($dateDifference / (60 * 60 * 24));

            if ($daysDifference < 90) {
                $this->addError('opening_date', 'The opening date and closing date must be at least 90 days apart : Current Range - ' . $daysDifference . ' days.');
                $this->addError('closing_date', 'The opening date and closing date must be at least 90 days apart: Current Range - ' . $daysDifference . ' days.');
            }
        }
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

<<<<<<< HEAD
=======
    public function getApplicationStartDate()
    {
        if (!$this->opening_date) {
            return null;
        }

        $windowDays = (int) Yii::$app->params['lotApplicationWindowDays'];    // 75, counted back from the deadline
        $deadlineDays = (int) Yii::$app->params['lotApplicationDeadlineDays'];  // 14, counted back from opening

        try {
            $opening = new \DateTimeImmutable($this->opening_date, new \DateTimeZone(Yii::$app->timeZone));
        } catch (\Exception $e) {
            return null;
        }

        // window start = (opening - 14 days) - 75 days = opening - 89 days
        return $opening
            ->modify("-{$deadlineDays} days")
            ->modify("-{$windowDays} days")
            ->format('Y-m-d');
    }

>>>>>>> Featshortlist
    public function getApplicationDeadline()
    {
        if (!$this->closing_date) {
            return null;

        }
<<<<<<< HEAD

        return date('Y-m-d', strtotime($this->closing_date . ' -2 weeks'));
=======
        $applicationDeadlineDays = Yii::$app->params['lotApplicationDeadlineDays'];
        return date('Y-m-d', strtotime($this->opening_date . ' -' . $applicationDeadlineDays . ' days'));
>>>>>>> Featshortlist
    }

    // Milestone 2: get Placement deadline (2 weeks after closing date)

    public function getPlacementDeadline()
    {
        if (!$this->closing_date) {
            return null;
        }

<<<<<<< HEAD
        return date('Y-m-d', strtotime($this->closing_date . ' +2 weeks'));
=======
        $applicationProcessingWindow = Yii::$app->params['lotProcessingWindowDays'];
        return date('Y-m-d', strtotime($this->opening_date . ' -' . $applicationProcessingWindow . ' days'));
>>>>>>> Featshortlist
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

<<<<<<< HEAD
    public function getIsActive()
    {
        $date = date('Y-m-d');
        $days = Yii::$app->params['lotApplicationWindowDays'];
=======

    // Check if lot is active
    public function getIsActive(): bool
    {
        if (empty($this->opening_date)) {
            return false;
        }

        $windowDays = (int) Yii::$app->params['lotApplicationWindowDays'];    // 75, counted back from the deadline
        $deadlineDays = (int) Yii::$app->params['lotApplicationDeadlineDays'];  // 14, counted back from opening

        try {
            $tz = new \DateTimeZone(Yii::$app->timeZone);
            $today = new \DateTimeImmutable('today', $tz);                    // midnight, app timezone
            $opening = (new \DateTimeImmutable($this->opening_date, $tz))->setTime(0, 0);
        } catch (\Exception $e) {
            return false;
        }

        $deadline = $opening->modify("-{$deadlineDays} days");
        $windowStart = $deadline->modify("-{$windowDays} days");

        // Inclusive on both ends: open on the first day of the window and on the deadline day
        return $today >= $windowStart && $today <= $deadline;
    }
>>>>>>> Featshortlist

        return (
            strtotime($date) >= strtotime("-{$days} days", strtotime($this->opening_date))
            &&
            strtotime($date) < strtotime($this->opening_date)
        );
    }



}
