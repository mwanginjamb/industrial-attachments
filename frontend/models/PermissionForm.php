<?php

namespace app\models;

use yii\base\Model;
use yii\rbac\DbManager;
use Yii;


class PermissionForm extends Model
{
    public $name;
    public $description;
    public $parent;
    public $originalName;

    public function scenarios()
    {
        return [
            'create' => ['name', 'description', 'parent'],
            'update' => ['name', 'description', 'parent', 'originalName'],
        ];
    }

    public function rules()
    {
        return [
            [['name', 'description'], 'required'],
            [['name'], 'string', 'max' => 64],
            [['description'], 'string', 'max' => 255],
            ['parent', 'validateParentExists'],
            ['name', 'validateUniqueName', 'on' => 'create'],
            ['name', 'validateRenamedPermission', 'on' => 'update'],
        ];
    }

    public function validateUniqueName($attribute)
    {
        $auth = new Yii::$app->authManager;
        if ($auth->getPermission($this->$attribute)) {
            $this->addError($attribute, 'This permission name already exists');
        }
    }

    public function validateRenamedPermission($attribute)
    {
        if ($this->name !== $this->originalName) {
            $auth = Yii::$app->authManager;
            if ($auth->getPermission($this->name) !== null) {
                $this->addError($attribute, 'This permission name already exists');
            }
        }
    }

    public function validateParentExists(string $attribute): void
    {
        // Parent is optional, so only validate if a value is provided
        if (empty($this->$attribute)) {
            return;
        }

        $auth = new DbManager();
        if (!$auth->getPermission($this->$attribute)) {
            $this->addError($attribute, 'The selected parent permission does not exist');
        }

    }

    // get parent name given a permission name
    public function getParentName($permissionName)
    {
        $auth = new DbManager();
        $parents = $auth->getParents($permissionName);
        return array_keys($parents);
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Permission Name',
            'description' => 'Description',
            'parent' => 'Parent Permission',
        ];
    }
}