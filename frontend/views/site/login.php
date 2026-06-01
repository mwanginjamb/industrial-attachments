<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var common\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$this->title = 'Login | ' . Yii::$app->name;
?>

<div class="min-h-screen flex flex-col md:flex-row">


    <section class="w-full md:w-3/4 lg:w-4/5 flex items-center justify-center p-2 md:p-4 bg-surface">
        <div class="w-full max-w-md">
            <div class="mb-10">
                <h3 class="font-headline text-3xl font-bold text-on-surface mb-2 tracking-tight">Welcome Back</h3>
                <p class="text-on-surface-variant font-body">Please enter your institutional credentials.</p>
            </div>

            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'options' => ['class' => 'space-y-6'],
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"relative group\">{input}</div>\n{error}",
                    'labelOptions' => ['class' => 'block font-label text-sm font-semibold text-on-surface-variant'],
                    'inputOptions' => ['class' => 'w-full pl-12 pr-4 py-3.5 bg-white border ring-1 ring-outline-variant/30 rounded-xl focus:ring-2 focus:ring-primary outline-none transition-all'],
                ],
            ]); ?>

            <?= $form->errorSummary($model) ?>

            <?= $form->field($model, 'username')->textInput([
                'autofocus' => true,
                'placeholder' => 'student.name@university.edu'
            ])->label('Your Username') ?>

            <?= $form->field($model, 'password')->passwordInput([
                'placeholder' => '••••••••'
            ]) ?>

            <div class="flex items-center justify-between py-2">
                <?= $form->field($model, 'rememberMe')->checkbox([
                    'template' => "<div class=\"flex items-center gap-3\">{input} {label}</div>\n{error}",
                    'class' => 'w-5 h-5 rounded border-outline-variant text-primary'
                ]) ?>



            </div>

            <div class="mt-2 flex flex-col gap-1">
                <?= Html::a('Forgot password?', ['site/request-password-reset'], [
                    'class' => 'text-xs font-semibold text-primary hover:underline'
                ]) ?>

                <div class="text-xs text-gray-500">
                    Need new verification email?
                    <?= Html::a('Resend', ['site/resend-verification-email'], [
                        'class' => 'font-semibold text-primary hover:underline'
                    ]) ?>
                </div>
            </div>

            <?= Html::submitButton('Sign In to Portal <span class="material-symbols-outlined">arrow_forward</span>', [
                'class' => 'w-full py-4 bg-primary text-white font-headline font-bold rounded-xl shadow-lg shadow-primary/20 hover:bg-primary-container transition-all flex items-center justify-center gap-2',
                'name' => 'login-button'
            ]) ?>

            <?php ActiveForm::end(); ?>

            <div class="mt-12 pt-8 border-t border-surface-container-highest text-center">
                <p class="text-on-surface-variant mb-6">New to the industrial attachment program?</p>

                <div class="flex flex-row gap-1 flex-shrink">

                    <?= Html::a('New Attachee Account', ['site/signup'], [
                        'class' => 'inline-flex items-center justify-center gap-2 px-8 py-3.5 border-2 border-primary text-primary font-headline font-bold rounded-xl hover:bg-primary/5 transition-all'
                    ]) ?>
                    <?= Html::a('New Staff Account', ['site/signup?sreg=1'], [
                        'class' => 'inline-flex items-center justify-center gap-2 px-8 py-3.5 border-2 border-primary text-primary font-headline font-bold rounded-xl hover:bg-primary/5 transition-all'
                    ]) ?>
                </div>
            </div>
        </div>
    </section>
</div>