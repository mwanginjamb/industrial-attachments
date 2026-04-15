<?php

/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:09 PM
 */

namespace frontend\models;

use Yii;
use yii\base\Model;


class File extends Model
{

    public $attachee_id; // the id of the entity that the file is attached to
    public $document_type; // metadata loop id from Attachment Document Types table
    public $service; // the service that the file is attached to
    public $attachment; // the actual file uploaded reference
    public $isNewRecord;

    /*public function __construct(array $config = [])
    {
        return $this->getLines($this->No);
    }*/

    public function rules()
    {
        return [
            [['attachment'], 'file', 'mimeTypes' => ['application/pdf']],
            [['attachment'], 'file', 'maxSize' => '15728640'], //15mb
            [['attachment_multiple'], 'file', 'skipOnEmpty' => false, 'maxSize' => 15 * 1024 * 1024, 'maxFiles' => 1],
        ];
    }

    public function attributeLabels()
    {
        return [];
    }
}
