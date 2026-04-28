<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "attachee".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $name
 * @property string|null $year_of_study
 * @property string|null $course_name
 * @property string|null $expected_completion_date
 * @property string|null $area_of_interest
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $level_of_education
 * @property string|null $attachee_reference
 *
 * @property Application[] $applications
 * @property AttacheeDocuments[] $attacheeDocuments
 * @property User $user
 */
class Attachee extends \yii\db\ActiveRecord
{

    public $application_letter;
    public $school_letter;
    public $national_id;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'attachee';
    }


    public function behaviors()
    {
        return [
            \yii\behaviors\TimestampBehavior::class,
            \yii\behaviors\BlameableBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'name', 'year_of_study', 'course_name', 'expected_completion_date', 'area_of_interest', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'default', 'value' => null],
            //set expected_completion_date to be a date
            [['expected_completion_date'], 'date', 'format' => 'php:Y-m-d'],
            // set expected_completion_date to be in the future by atleast 3 months
            ['expected_completion_date', 'compare', 'compareValue' => date('Y-m-d', strtotime('+3 months')), 'operator' => '>', 'type' => 'date'],
            // set required fields
            [['name', 'year_of_study', 'course_name', 'expected_completion_date', 'area_of_interest', 'level_of_education'], 'required', 'on' => 'update'],
            [['user_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            // [['expected_completion_date'], 'safe'],
            [['area_of_interest'], 'string'],
            [['name'], 'string', 'max' => 150],
            [['year_of_study'], 'string', 'max' => 20],
            [['course_name'], 'string', 'max' => 250],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\User::class, 'targetAttribute' => ['user_id' => 'id']],
            ['user_id', 'required'],
            ['level_of_education', 'integer'],
            ['attachee_reference', 'string', 'max' => 50],

            //set attachee reference to be unique
            ['attachee_reference', 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'name' => 'Name',
            'year_of_study' => 'Year Of Study',
            'course_name' => 'Course Name',
            'expected_completion_date' => 'Expected Completion Date',
            'area_of_interest' => 'Area Of Interest',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'level_of_education' => 'Level Of Education',
            'attachee_reference' => 'Attachee Reference',
        ];
    }

    //validates if attachee profile is complete by checking if the required fields are filled
    public static function isComplete($attachee)
    {
        return $attachee->name && $attachee->year_of_study && $attachee->course_name && $attachee->expected_completion_date && $attachee->area_of_interest && $attachee->level_of_education;
    }

    /**
     * Gets query for [[Applications]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getApplications()
    {
        return $this->hasMany(Application::class, ['attachee_id' => 'id']);
    }

    /**
     * Gets query for [[AttacheeDocuments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAttacheeDocuments()
    {
        return $this->hasMany(AttacheeDocuments::class, ['attachee_id' => 'attachee_reference']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    // Add attachee reference generation logic in the form "ATTACHEEYYYYMMDDHHMMSS"
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                // Generate attachee reference only for new records
                $this->attachee_reference = 'ATTACHEE' . date('YmdHis');
            }
            return true;
        }
        return false;
    }

}
