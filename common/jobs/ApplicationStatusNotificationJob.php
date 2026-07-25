    <?php
    namespace common\jobs;

    use Yii;
    use yii\base\BaseObject;
    use yii\queue\JobInterface;
    use frontend\models\Application;

    class ApplicationStatusNotificationJob extends BaseObject implements JobInterface
    {
        public int $applicationId;
        public int $status;

        public function execute($queue)
        {
           (new common\services\ApplicationNotificationService())
           ->sendStatusNotification($this->applicationId, $this->status);          
        }
    }