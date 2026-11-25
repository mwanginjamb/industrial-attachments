<?php

namespace frontend\models;

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

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => 'updated_at',
                ],
            ],
            'blameable' => [
                'class' => 'yii\behaviors\BlameableBehavior',
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_by', 'updated_by'],
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => 'updated_by',
                ],
            ],
        ];
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

    /**
     * Get a single attache document given a specific attachee id and document type
     * 
     * @param int $attacheeId
     * @return \yii\db\ActiveQuery
     */
    public function getAttacheeDocument()
    {
        return $this->hasOne(AttacheeDocuments::class, ['document_type' => 'id']);
    }

    // get Total templates
    public static function getTotalTemplates()
    {
        return self::find()->count();
    }

    // Given a template id and an attachee reference, determine if that attachee has uploaded a document of that template type
    public static function getAttacheeUploadedDocument($template_id, $attachee_reference)
    {
        return AttacheeDocuments::find()->where(['document_type' => $template_id, 'attachee_id' => $attachee_reference])->andWhere(['not', ['path' => null]])->andWhere(['not', ['path' => '']])->exists();
    }

    // Return path of uploaded document given a template id and an attachee reference
    public static function getAttacheeUploadedDocumentPath($template_id, $attachee_reference)
    {
        $document = AttacheeDocuments::find()->where(['document_type' => $template_id, 'attachee_id' => $attachee_reference])->andWhere(['not', ['path' => null]])->andWhere(['not', ['path' => '']])->one();
        return $document ? $document->path : null;
    }

}
