<?php

namespace frontend\models;

use common\models\User;
use Yii;
use yii\base\Model;
use yii\httpclient\Client;
use yii\httpclient\CurlTransport;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $passwordConfirm;

    public $employeeNumber;

    public $staffRegistration;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],

            ['passwordConfirm', 'required'],
            ['passwordConfirm', 'compare', 'compareAttribute' => 'password', 'message' => 'Passwords do not match'],

            ['staffRegistration', 'boolean'],

            [['employeeNumber'], 'required', 'on' => 'staff'], // employeeNumber is required only in staff scenario


        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['staff'] = [
            'username',
            'email',
            'password',
            'passwordConfirm',
            'employeeNumber',
            'staffRegistration',
        ];
        return $scenarios;
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();

        return $user->save() && $this->sendEmail($user);
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }


    /* Make a Get request for assignes
     * The JSON format is:
     * {
     *   "90254 - melvineobuya@gmail.com": "OBUYA",
     *  "90252 - lauraombogo@gmail.com": "LORRAINE",
     * }
     */

    public function fetchAssignees()
    {
        $endpoint = env('ASSIGNEE_ENDPOINT');
        $client = new Client([
            'transport' => CurlTransport::class,
        ]);

        $request = $client->createRequest()
            ->setMethod('GET')
            ->setUrl($endpoint)
            ->addHeaders(['Content-Type' => 'application/json'])
            ->setFormat(Client::FORMAT_JSON)  // Ensures JSON encoding for request
            ->setOptions([
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false
            ]);

        $response = $request->send();
        Yii::info('Raw response content: ' . $response->content, 'api_debug');
        if ($response->isOk) { // Check if the response status is 200-299
            return $response->data; // Return the relevant response data
        } else {
            // Log error details if needed and return a clear message
            return [
                'status' => $response->statusCode,
                'error' => $response->data ?? 'Unexpected error occurred'
            ];
        }
    }
}
