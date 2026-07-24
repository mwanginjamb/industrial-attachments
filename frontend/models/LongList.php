<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "long_list".
 *
 * @property int $id
 * @property int|null $lot_id
 * @property int|null $placement_id
 * @property string|null $description
 * @property string|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property Application[] $applications
 * @property LongListApplication[] $longListApplications
 * @property Lot $lot
 */
class LongList extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'long_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lot_id', 'description', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 'OPEN'],
            [['lot_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['description'], 'string'],
            [['status'], 'string', 'max' => 255],
            ['placement_id', 'integer'],
            [['lot_id'], 'exist', 'skipOnError' => true, 'targetClass' => Lot::class, 'targetAttribute' => ['lot_id' => 'id']],
            [['placement_id'], 'exist', 'skipOnError' => true, 'targetClass' => PlacementArea::class, 'targetAttribute' => ['placement_id' => 'id']],
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
            'description' => 'Description',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * Gets query for [[Applications]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getApplications()
    {
        return $this->hasMany(Application::class, ['id' => 'application_id'])->viaTable('long_list_application', ['long_list_id' => 'id']);
    }

    /**
     * Gets query for [[LongListApplications]].
     *
     * @return \yii\db\ActiveQuery|LongListApplicationQuery
     */
    public function getLongListApplications()
    {
        return $this->hasMany(LongListApplication::class, ['long_list_id' => 'id']);
    }

    // Get shortlisted applications for this long list
    public function getShortlistedApplications()
    {
        return $this->hasMany(LongListApplication::class, ['long_list_id' => 'id'])
            ->where(['shortlisted' => true]);
    }

    /**
     * Gets query for [[Lot]].
     *
     * @return \yii\db\ActiveQuery|LotQuery
     */
    public function getLot()
    {
        return $this->hasOne(Lot::class, ['id' => 'lot_id']);
    }

    /**
     * {@inheritdoc}
     * @return LongListQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LongListQuery(get_called_class());
    }

}
