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
                __METHOD__
            );
            return false;
        }

        if (!isset($this->handlers[$status])) {
            return false;
        }

        $method = $this->handlers[$status];

        $this->$method($application);

        return true;


    }

    // selection email notification

    private function sendSelectionEmail(Application $application)
    {
        if (
            !$application->attachee ||
            empty($application->attachee->email_address)
        ) {
            return;
        }

        Yii::$app->mailer
            ->compose()
            ->setTo($application->attachee->email_address)
            ->setSubject('Industrial Attachment Application Outcome')
            ->setTextBody(
                "Dear {$application->attachee->name},\n\n"
                . "Congratulations.\n\n"
                . "We are pleased to inform you that your application for industrial attachment has been successful.\n\n"
                . "You will receive further communication regarding reporting dates, departmental placement and onboarding arrangements.\n\n"
                . "We look forward to hosting you.\n\n"
                . "Kind regards,\n"
                . "HR Team"
            )
            ->send();
    }

     // Rejection Email
    private function sendRegretEmail(Application $application)
    {
        if (
            !$application->attachee ||
            empty($application->attachee->email_address)
        ) {
            return;
        }

        Yii::$app->mailer
            ->compose()
            ->setTo($application->attachee->email_address)
            ->setSubject('Industrial Attachment Application Outcome')
            ->setTextBody(
                "Dear {$application->attachee->name},\n\n"

                . "Thank you for your interest in our Industrial Attachment Programme and for taking the time to submit your application.\n\n"

                . "After careful consideration of all applications received, we regret to inform you that your application was not successful for application intake.\n\n"

                . "The selection process was highly competitive, and many strong applications were received. This outcome should not be viewed as a reflection of your abilities, academic achievements or future potential.\n\n"

                . "We sincerely appreciate your interest in our institution and encourage you to apply again for future opportunities where eligible.\n\n"

                . "We wish you success in your studies and future career pursuits.\n\n"

                . "Kind regards,\n"
                . "HR Team"
            )
            ->send();
    }

    private function sendSubmissionEmail(
    Application $application
    ): bool {

        if (
            !$application->attachee ||
            empty($application->attachee->email_address)
        ) {
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
                "Dear {$application->attachee->name},\n\n"

                . "Thank you for applying to the Industrial Attachment Programme.\n\n"

                . "We have successfully received your application and it is now awaiting processing.\n\n"

                . "Should any additional information be required, you will be contacted through this email address.\n\n"

                . "Thank you for your interest in our institution.\n\n"

                . "Kind regards,\n"
                . "HR Team"
            )
            ->send();
}

    private function sendReviewEmail(
    Application $application
): bool {

    if (
        !$application->attachee ||
        empty($application->attachee->email_address)
    ) {
        return false;
    }

    $placementName =
        $application->placementArea->name ?? 'assigned department';

    return Yii::$app->mailer
        ->compose()
        ->setTo(
            $application->attachee->email_address
        )
        ->setSubject(
            'Industrial Attachment Application Under Review'
        )
        ->setTextBody(
            "Dear {$application->attachee->name},\n\n"

            . "Your application has progressed to the departmental review stage.\n\n"

            . "It has been assigned to {$placementName} for evaluation.\n\n"

            . "The department will review your application together with other submissions before a final decision is made.\n\n"

            . "No further action is required from you at this time.\n\n"

            . "We appreciate your patience throughout the selection process.\n\n"

            . "Kind regards,\n"
            . "HR Team"
        )
        ->send();
}


}