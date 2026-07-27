<?php
namespace common\services;

use Yii;
use frontend\models\Application;

class ApplicationNotificationService 
{

    private array $handlers = [

        Application::STATUS_SUBMITTED
        => 'sendSubmissionEmail',

        Application::STATUS_UNDER_REVIEW
            => 'sendReviewEmail',

        Application::STATUS_SELECTED
            => 'sendSelectionEmail',

        Application::STATUS_UNSUCCESSFUL
            => 'sendRegretEmail',

    ];

    public function sendStatusNotification(int $applicationId, int $status):bool {

         $application = Application::findOne($applicationId);

         if (!$application) {
            Yii::warning(
                "Application {$applicationId} not found.",
                'queue.notifications'
            );
            return false;
        }

        if (!isset($this->handlers[$status])) {
             Yii::error("No handler mapped for status ID: {$status}", 'queue.notifications');
            return false;
        }

        $method = $this->handlers[$status];

        try {
            return $this->$method($application);
        } catch (\Throwable $e) {
            Yii::error("Failed sending email for Application #{$applicationId}: " . $e->getMessage(), 'queue.notification');
            return false;
        }


    }

    // selection email notification

    private function sendSelectionEmail(Application $application): bool
    {
        if (
            !$application->attachee ||
            empty($application->attachee->email_address)
        ) {
             Yii::warning(
                "Application Selection not found.",
                'queue.notifications'
            );
            return false;
        }

        return Yii::$app->mailer
            ->compose()
            ->setTo($application->attachee->email_address)
            ->setSubject('Industrial Attachment Application Outcome')
            ->setTextBody(
                "Dear {$application->attachee->name},\r\n\r\n"
                . "Congratulations.\r\n\r\n"
                . "We are pleased to inform you that your application for industrial attachment has been successful.\r\n\r\n"
                . "You will receive further communication regarding reporting dates, departmental placement and onboarding arrangements.\r\n\r\n"
                . "We look forward to hosting you.\r\n\r\n"
                . "Kind regards,\n"
                . "HR Team"
            )
            ->send();
    }

     // Rejection Email
    private function sendRegretEmail(Application $application): bool
    {
        if (
            !$application->attachee ||
            empty($application->attachee->email_address)
        ) {
            Yii::warning(
                "Application Regret not found.",
                'queue.notifications'
            );
            return false;
        }

       return Yii::$app->mailer
            ->compose()
            ->setTo($application->attachee->email_address)
            ->setSubject('Industrial Attachment Application Outcome')
            ->setTextBody(
                "Dear {$application->attachee->name},\r\n\r\n"

                . "Thank you for your interest in our Industrial Attachment Programme and for taking the time to submit your application.\r\n\r\n"

                . "After careful consideration of all applications received, we regret to inform you that your application was not successful for application intake.\r\n\r\n"

                . "The selection process was highly competitive, and many strong applications were received. This outcome should not be viewed as a reflection of your abilities, academic achievements or future potential.\r\n\r\n"

                . "We sincerely appreciate your interest in our institution and encourage you to apply again for future opportunities where eligible.\r\n\r\n"

                . "We wish you success in your studies and future career pursuits.\r\n\r\n"

                . "Kind regards,\n"
                . "HR Team"
            )
            ->send();
    }

    private function sendSubmissionEmail(Application $application): bool {

        if (
            !$application->attachee ||
            empty($application->attachee->email_address)
        ) {
            Yii::warning(
                "Application Submission could not be Sent.",
                'queue.notifications'
            );
            return false;
        }

        return Yii::$app->mailer
            ->compose()
            ->setTo(
                $application->attachee->email_address
            )
            ->setSubject(
                'Industrial Attachment Application Received'
            )
            ->setTextBody(
                "Dear {$application->attachee->name},\r\n\r\n"

                . "Thank you for applying to the Industrial Attachment Programme.\r\n\r\n"

                . "We have successfully received your application and it is now awaiting processing.\r\n\r\n"

                . "Should any additional information be required, you will be contacted through this email address.\r\n\r\n"

                . "Thank you for your interest in our institution.\r\n\r\n"

                . "Kind regards,\n"
                . "HR Team"
            )
            ->send();
}

    private function sendReviewEmail(Application $application): bool {

    if (!$application->attachee || empty($application->attachee->email_address)) {
        Yii::warning(
                "Application Review Notification Could not be Sent.",
                'queue.notifications'
            );
        return false;
    }

    $placementName = $application->placementArea->name ?? 'assigned department';

    return Yii::$app->mailer
        ->compose()
        ->setTo(
            $application->attachee->email_address
        )
        ->setSubject(
            'Industrial Attachment Application Under Review'
        )
        ->setTextBody(
            "Dear {$application->attachee->name},\r\n\r\n"

            . "Your application has progressed to the departmental review stage.\r\n\r\n"

            . "It has been assigned to {$placementName} for evaluation.\r\n\r\n"

            . "The department will review your application together with other submissions before a final decision is made.\r\n\r\n"

            . "No further action is required from you at this time.\r\n\r\n"

            . "We appreciate your patience throughout the selection process.\r\n\r\n"

            . "Kind regards,\n"
            . "HR Team"
        )
        ->send();
}


}