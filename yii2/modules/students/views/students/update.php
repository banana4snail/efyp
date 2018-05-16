<?php

use yii\helpers\Html;

$session = Yii::$app->session;
/* @var $this yii\web\View */
/* @var $model app\modules\students\models\Students */

$this->title = 'Update Students: ' . $model->name;
if($session['role']=="fypCoordinator"){
    $this->params['breadcrumbs'][] = ['label' => 'Search', 'url' => ['coordinatorhome/search']];
    $this->params['breadcrumbs'][] = ['label' => 'Students', 'url' => ['index']];
    $this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->studentID]];
}
else{
    $this->params['breadcrumbs'][] = ['label' => 'Students', 'url' => ['index']];
    $this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->studentID]];
}
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="students-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
