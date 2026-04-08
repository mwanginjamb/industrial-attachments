<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var common\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$this->title = 'Register | Create an Account';
?>

<div class="min-h-screen flex flex-col md:flex-row">


    <section class="w-full md:w-3/4 lg:w-4/5 flex items-center justify-center p-2 md:p-4 bg-surface">
        <div class="w-full max-w-md">
            <div class="mb-10">
                <h3 class="font-headline text-3xl font-bold text-on-surface mb-2 tracking-tight">

                    <?= Html::encode($this->title) ?>
                </h3>
                <p class="text-on-surface-variant font-body">Please fill out the following fields to signup:</p>
            </div>

            <?php $form = ActiveForm::begin([
                'id' => 'form-signup',
                'options' => ['class' => 'space-y-6'],
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"relative group\">{input}</div>\n{error}",
                    'labelOptions' => ['class' => 'block font-label text-sm font-semibold text-on-surface-variant'],
                    'inputOptions' => ['class' => 'w-full pl-12 pr-4 py-3.5 bg-white border ring-1 ring-outline-variant/30 rounded-xl focus:ring-2 focus:ring-primary outline-none transition-all'],
                ],
            ]); ?>

            <!-- Add an error summary -->
            <?= $form->errorSummary($model) ?>

            <?= $form->field($model, 'username')->textInput([
                'autofocus' => true,
<<<<<<< HEAD
                'placeholder' => 'Your Username'
            ])->label('Username') ?>
=======
                'placeholder' => 'Username'
            ])->label('Your Username') ?>
>>>>>>> 534df7ed4e4875c0ee17e8884e31c8cec2ed5499

            <?= $form->field($model, 'email')->textInput([
                'type' => 'email',
                'placeholder' => 'Your E-mail Address'
            ])->label('Email') ?>

            <?= $form->field($model, 'password')->passwordInput([
                'placeholder' => '••••••••'
            ]) ?>

            <?= $form->field($model, 'passwordConfirm')->passwordInput([
                'placeholder' => '••••••••'
            ]) ?>


            <div class="mt-2 flex flex-col gap-1">


            </div>

            <?= Html::submitButton('Register to Portal <span class="material-symbols-outlined">arrow_forward</span>', [
                'class' => 'w-full py-4 bg-primary text-white font-headline font-bold rounded-xl shadow-lg shadow-primary/20 hover:bg-primary-container transition-all flex items-center justify-center gap-2',
                'name' => 'signup-button'
            ]) ?>

            <?php ActiveForm::end(); ?>

            <div class="mt-12 pt-8 border-t border-surface-container-highest text-center">
                <div class="text-xs text-gray-500">
                    Already have an Account ?
                    <?= Html::a('Sign In', ['site/login'], [
                        'class' => 'font-semibold text-primary hover:underline'
                    ]) ?>
                </div>
            </div>
        </div>
    </section>
</div>