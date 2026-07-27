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
        try {
            $service = new ApplicationNotificationService();
            $success = $service->sendStatusNotification($this->applicationId, $this->status);

            if (!$success) {
                // Custom warning if soft failure occurs without throwing an exception
                Yii::warning(
                    "Notification job skipped or failed silently for Application #{$this->applicationId}.",
                    'queue.notifications'
                );
            }
        } catch (\Throwable $e) {
            // Include stack trace so you know where it broke
            Yii::error(
                "Job failed for Application #{$this->applicationId}: {$e->getMessage()}\n{$e->getTraceAsString()}",
                'queue.notifications'
            );

            // Rethrowing allows yii2-queue to trigger retry mechanisms / ttr timeout
            throw $e;
        }
    }
}