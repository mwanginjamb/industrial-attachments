<?php

return [
    'adminEmail' => env('SMTP_USERNAME'),
    'supportEmail' => env('SMTP_USERNAME'),
    'senderEmail' => env('SMTP_USERNAME'),
    'senderName' => 'KEMRI Mailer',
    'user.passwordResetTokenExpire' => 3600,
    'user.passwordMinLength' => 8,
    'lotApplicationWindowDays' => env('LOT_APPLICATION_WINDOW_DAYS', 14),
    // Array for annual quarters and their corresponding date ranges
    'quarters' => [
        'Q1' => ['start' => '01-01', 'end' => '03-31'],
        'Q2' => ['start' => '04-01', 'end' => '06-30'],
        'Q3' => ['start' => '07-01', 'end' => '09-30'],
        'Q4' => ['start' => '10-01', 'end' => '12-31'],
    ],
];

