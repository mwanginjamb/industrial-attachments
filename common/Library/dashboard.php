<?php
namespace common\Library;
use yii\base\Component;
use frontend\models\User;
use common\models\User as CommonUser;
class Dashboard extends Component
{

    public function countActiveUsers()
    {
        return User::find()->where(['status' => CommonUser::STATUS_ACTIVE])->count();
    }

    public function countInactiveUsers()
    {
        return User::find()->where(['status' => CommonUser::STATUS_INACTIVE])->count();
    }

    public function countRequireUpdate()
    {
        return 0;
    }
}