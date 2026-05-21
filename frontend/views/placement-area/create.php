<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\PlacementArea $model */

$this->title = Yii::t('app', 'Create Placement Area');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Placement Areas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="placement-area-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
