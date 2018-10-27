<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\students\models\Reportsubmission */

$this->title = 'Create Reportsubmission';
$this->params['breadcrumbs'][] = ['label' => 'Reportsubmissions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reportsubmission-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
