<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \frontend\models\PasswordResetRequestForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Request password reset | ' . Yii::$app->name;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="min-h-screen flex flex-col md:flex-row">

    <section class="w-full md:w-3/4 lg:w-4/5 flex items-center justify-center p-2 md:p-4 bg-surface">
        <div class="w-full max-w-md">
            <div class="mb-10">
                <h3 class="font-headline text-3xl font-bold text-on-surface mb-2 tracking-tight">Welcome Back</h3>
                <p class="text-on-surface-variant font-body">Please fill out your email. A link to reset password will
                    be sent there.</p>
            </div>

            <?php $form = ActiveForm::begin([
                'id' => 'request-password-reset-form',
                'options' => ['class' => 'space-y-6'],
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"relative group\">{input}</div>\n{error}",
                    'labelOptions' => ['class' => 'block font-label text-sm font-semibold text-on-surface-variant'],
                    'inputOptions' => ['class' => 'w-full pl-12 pr-4 py-3.5 bg-white border ring-1 ring-outline-variant/30 rounded-xl focus:ring-2 focus:ring-primary outline-none transition-all'],
                ]
            ]); ?>

            <?= $form->errorSummary($model) ?>

            <?= $form->field($model, 'email')->textInput(['autofocus' => true, 'placeholder' => 'Enter Your Registered E-mail', 'type' => 'email']) ?>

            <?= Html::submitButton('Request Password Reset <span class="material-symbols-outlined">arrow_forward</span>', [
                'class' => 'w-full py-4 bg-primary text-white font-headline font-bold rounded-xl shadow-lg shadow-primary/20 hover:bg-primary-container transition-all flex items-center justify-center gap-2',
                'name' => 'reset-button'
            ]) ?>

            <?php ActiveForm::end(); ?>

            <div class="mt-2 flex flex-col gap-1">
                <div class="text-xs text-gray-500">
                    Remembered your password?
                    <?= Html::a('Sign in', ['site/login'], [
                        'class' => 'font-semibold text-primary hover:underline'
                    ]) ?>
                </div>
            </div>

        </div>
    </section>

</div>