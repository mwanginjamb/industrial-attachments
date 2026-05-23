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
 * @property int $institution_id
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
            [['user_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['expected_completion_date'], 'safe'],
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
            ['institution_id', 'integer'],
            ['institution_id', 'exist', 'skipOnError' => true, 'targetClass' => Institution::class, 'targetAttribute' => ['institution_id' => 'id']],
            ['institution_id', 'required'],
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
        return $this->hasMany(AttacheeDocuments::class, ['attachee_id' => 'id']);
    }

    // Get institution
    public function getInstitution()
    {
        return $this->hasOne(Institution::class, ['id' => 'institution_id']);
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
