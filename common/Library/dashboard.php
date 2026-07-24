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

     public function getMetrics(int $longListId): array
    {
        $total = \frontend\models\LongListApplication::find()
            ->where([
                'long_list_id' => $longListId
            ])
            ->count();

        $selected = \frontend\models\LongListApplication::find()
            ->where([
                'long_list_id' => $longListId,
                'shortlisted' => 1
            ])
            ->count();

        $pending = max(0, $total - $selected);

        $progress = $total > 0
            ? round(($selected / $total) * 100, 1)
            : 0;

        return [
            'total' => $total,
            'selected' => $selected,
            'pending' => $pending,
            'progress' => $progress,
            'status' => $progress == 100 ? 'COMPLETE' : 'IN PROGRESS',
        ];
    }
}