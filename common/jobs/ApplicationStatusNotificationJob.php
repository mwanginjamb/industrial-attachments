<?php
namespace common\jobs;

use Yii;
use yii\base\BaseObject;
use yii\queue\JobInterface;
use common\services\ApplicationNotificationService;

class ApplicationStatusNotificationJob extends BaseObject implements JobInterface
{
    public int $applicationId;
    public int $status;

    public function execute($queue)
    {
        try{
            (new ApplicationNotificationService())
            ->sendStatusNotification($this->applicationId, $this->status);          
        } catch(\Throwable $e) {
            Yii::error($e->getMessage(),__METHOD__);
            throw $e;
        }
    }
}