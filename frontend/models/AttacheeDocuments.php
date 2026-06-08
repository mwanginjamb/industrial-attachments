<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "attachee_documents".
 *
 * @property int $id
 * @property string|null $path
 * @property string|null $attachee_id
 * @property int|null $document_type
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property Attachee $attachee
 * @property AttacheeDocumentsTemplates $documentType
 */
class AttacheeDocuments extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'attachee_documents';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['path', 'document_type', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'default', 'value' => null],
            [['document_type', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['path'], 'string', 'max' => 250],
            [['attachee_id'], 'string', 'max' => 250],
            //[['attachee_id'], 'exist', 'skipOnError' => true, 'targetClass' => Attachee::class, 'targetAttribute' => ['attachee_id' => 'id']],
            [['document_type'], 'exist', 'skipOnError' => true, 'targetClass' => AttacheeDocumentsTemplates::class, 'targetAttribute' => ['document_type' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'path' => 'Path',
            'attachee_id' => 'Attachee ID',
            'document_type' => 'Document Type',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
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

    /**
     * Gets query for [[DocumentType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDocumentType()
    {
        return $this->hasOne(AttacheeDocumentsTemplates::class, ['id' => 'document_type']);
    }

    // Get Attached Dococuments Count for an Attachee
    public static function getDocumentsCount($attacheeId)
    {
        return self::find()->where(['attachee_id' => $attacheeId])->count();
    }

}
