<?php

use yii\helpers\Html;

$session = Yii::$app->session;
/* @var $this yii\web\View */
/* @var $model app\modules\students\models\Title */

$this->title = 'Update Title: ' . $model->title;
if($session['role']=="fypCoordinator"){
$this->params['breadcrumbs'][] = ['label' => 'Search', 'url' => ['coordinatorhome/search']];
$this->params['breadcrumbs'][] = ['label' => 'Titles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->titleID]];
$this->params['breadcrumbs'][] = 'Update';
}
else{
$this->params['breadcrumbs'][] = ['label' => 'Titles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->titleID]];
$this->params['breadcrumbs'][] = 'Update';
}
?>
<div class="title-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_updateform', [
        'model' => $model,
        'course' => $course,
        'courseArray' => $courseArray,
        'supervisors' => $supervisors,
    ]) ?>

</div>
