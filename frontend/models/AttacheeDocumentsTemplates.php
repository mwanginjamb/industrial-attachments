<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "attachee_documents_templates".
 *
 * @property int $id
 * @property string|null $document_description
 * @property string|null $notes
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property AttacheeDocuments[] $attacheeDocuments
 */
class AttacheeDocumentsTemplates extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'attachee_documents_templates';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['document_description', 'notes', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'default', 'value' => null],
            [['notes'], 'string'],
            [['created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['document_description'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'document_description' => 'Document Description',
            'notes' => 'Notes',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * Gets query for [[AttacheeDocuments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAttacheeDocuments()
    {
        return $this->hasMany(AttacheeDocuments::class, ['document_type' => 'id']);
    }

}
