<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var common\models\LoginForm $model */

use common\Library\FormUi;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\web\View;

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

            <?php if ($model->staffRegistration): ?>

                <div>

                    <?= $form->field($model, 'employeeNumber')->textInput([
                        'placeholder' => 'Employee Number',
                        'autocomplete' => 'off'
                    ])->label('Employee Number') ?>

                    <?php // $form->field($model, 'staffRegistration', FormUi::checkboxFieldConfig())->checkbox(FormUi::checkboxConfig('Signup as Staff ?')) ?>

                    <!-- helper text -->
                    <p class="text-xs text-gray-500 mt-1">
                        Enter your official employee number to auto-fill your account details.
                    </p>

                    <!-- loading state -->
                    <div id="employee-lookup-status" class="hidden text-xs mt-2 text-primary font-medium">
                    </div>

                    <!-- success state -->
                    <div id="employee-success" class="hidden text-sm mt-2 text-green-600 font-medium">
                    </div>

                    <!-- error state -->
                    <div id="employee-error" class="hidden text-sm mt-2 text-red-500 font-medium">
                    </div>



                </div>
            <?php endif; ?>

            <?= $form->field($model, 'username')->textInput([
                'autofocus' => true,
                'placeholder' => 'Your Username',
                'readonly' => $model->staffRegistration,
                'autocomplete' => 'off',
                'class' =>
                    'w-full px-4 py-3.5 border rounded-xl outline-none transition-all ' .
                    ($model->staffRegistration
                        ? 'bg-gray-100 cursor-not-allowed'
                        : 'bg-white'),
            ])->label('Username') ?>

            <?= $form->field($model, 'email')->textInput([
                'type' => 'email',
                'placeholder' => 'Your E-mail Address',
                'readonly' => $model->staffRegistration,
                'autocomplete' => 'off',
                'class' =>
                    'w-full px-4 py-3.5 border rounded-xl outline-none transition-all ' .
                    ($model->staffRegistration
                        ? 'bg-gray-100 cursor-not-allowed'
                        : 'bg-white'),
            ])->label('Email') ?>

            <!-- Password Field -->
            <div>

                <?= $form->field($model, 'password')->passwordInput([
                    'placeholder' => '••••••••',
                    'autocomplete' => 'new-password',
                    'id' => 'signupform-password',
                ]) ?>

                <!-- strength meter -->
                <div class="mt-2">
                    <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div id="password-strength-bar" class="h-full transition-all duration-300 w-0">
                        </div>
                    </div>

                    <div id="password-strength-text" class="text-xs mt-1 text-gray-500">
                        Password strength
                    </div>
                </div>

                <!-- show password -->
                <button type="button" id="toggle-password" class="text-xs text-primary mt-2 hover:underline">
                    Show Password
                </button>

            </div>

            <?= $form->field($model, 'passwordConfirm')->passwordInput([
                'placeholder' => '••••••••',
                'autocomplete' => 'new-password'
            ]) ?>


            <div class="mt-2 flex flex-col gap-1">


            </div>

            <?= Html::submitButton('Register to Portal <span class="material-symbols-outlined">arrow_forward</span>', [
                'class' => 'w-full py-4 bg-primary text-white font-headline font-bold rounded-xl shadow-lg shadow-primary/20 hover:bg-primary-container transition-all flex items-center justify-center gap-2',
                'name' => 'signup-button',
                'id' => 'signup-submit-btn',
                'disabled' => $model->staffRegistration,
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

<?php

$lookupUrl = yii\helpers\Url::to(['site/lookup-employee']);

$js = <<<JS
const employeeInput =
    document.getElementById('signupform-employeenumber');

const usernameInput =
    document.getElementById('signupform-username');

const emailInput =
    document.getElementById('signupform-email');

const passwordInput =
    document.getElementById('signupform-password');

const submitBtn =
    document.getElementById('signup-submit-btn');

const statusBox =
    document.getElementById('employee-lookup-status');

const successBox =
    document.getElementById('employee-success');

const errorBox =
    document.getElementById('employee-error');

let debounceTimeout = null;

 
if (employeeInput) {

    employeeInput.addEventListener('input', function () {

        clearTimeout(debounceTimeout);

        const employeeNumber = this.value.trim();

        // reset states
        successBox.classList.add('hidden');
        errorBox.classList.add('hidden');

        if (!employeeNumber) {
            submitBtn.disabled = true;
            return;
        }

        debounceTimeout = setTimeout(async () => {

            try {

                statusBox.classList.remove('hidden');
                statusBox.innerText = 'Looking up employee...';

                const response = await fetch(
                    '{$lookupUrl}?employeeNumber=' +
                    encodeURIComponent(employeeNumber)
                );

                const data = await response.json();

                statusBox.classList.add('hidden');

                if (data.success) {

                    usernameInput.value =
                        data.username.toLowerCase();

                    emailInput.value =
                        data.email.toLowerCase();

                    successBox.innerText =
                        '✓ Employee verified successfully';

                    successBox.classList.remove('hidden');

                    errorBox.classList.add('hidden');

                    submitBtn.disabled = false;

                    passwordInput.focus();

                } else {

                    submitBtn.disabled = true;

                    errorBox.innerText =
                        data.message || 'Employee not found';

                    errorBox.classList.remove('hidden');

                    successBox.classList.add('hidden');

                }

            } catch (error) {

                console.error(error);

                submitBtn.disabled = true;

                statusBox.classList.add('hidden');

                errorBox.innerText =
                    'Could not connect to employee directory';

                errorBox.classList.remove('hidden');
            }

        }, 600);

    });

    /*
|--------------------------------------------------------------------------
| PASSWORD VISIBILITY TOGGLE
|--------------------------------------------------------------------------
*/

const togglePasswordBtn =
    document.getElementById('toggle-password');

togglePasswordBtn.addEventListener('click', function () {

    if (passwordInput.type === 'password') {

        passwordInput.type = 'text';

        this.innerText = 'Hide Password';

    } else {

        passwordInput.type = 'password';

        this.innerText = 'Show Password';
    }   
});
}

/*
|--------------------------------------------------------------------------
| PASSWORD STRENGTH METER
|--------------------------------------------------------------------------
*/

const strengthBar =
document.getElementById('password-strength-bar');

const strengthText =
document.getElementById('password-strength-text');

passwordInput.addEventListener('input', function () {

    const password = this.value;

    let strength = 0;

    if (password.length >= 8) strength++;
    if (/[A-Z]/.test(password)) strength++;
    if (/[0-9]/.test(password)) strength++;
    if (/[^A-Za-z0-9]/.test(password)) strength++;

    let width = '0%';
    let text = 'Weak';

    if (strength === 1) {
        width = '25%';
        text = 'Weak';
    }

    if (strength === 2) {
        width = '50%';
        text = 'Fair';
    }

    if (strength === 3) {
        width = '75%';
        text = 'Good';
    }

    if (strength === 4) {
        width = '100%';
        text = 'Strong';
    }

    strengthBar.style.width = width;

    strengthText.innerText =
        password.length ? 'Password strength: ' + text : 'Password strength';
});

JS;

$this->registerJs($js, View::POS_READY);
?>