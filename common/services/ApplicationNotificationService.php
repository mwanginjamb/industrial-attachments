<?php
namespace common\services;

use Yii;
use frontend\models\Application;

class ApplicationNotificationService 
{

    private array $handlers = [

        Application::STATUS_SELECTED
            => 'sendSelection',

        Application::STATUS_UNSUCCESSFUL
            => 'sendRegret',

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


    }

    // selection email notification

    private function sendSelectionEmail(Application $application)
    {
        if (
            !$application->attachee ||
            empty($application->attachee->email)
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
            empty($application->attachee->email)
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


}