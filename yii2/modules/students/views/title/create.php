<?php

use yii\helpers\Html;

$session = Yii::$app->session;
/* @var $this yii\web\View */
/* @var $model app\modules\students\models\Title */

$this->title = 'Create Title';
if($session['role']=="fypCoordinator"){
$this->params['breadcrumbs'][] = ['label' => 'Search', 'url' => ['coordinatorhome/search']];
$this->params['breadcrumbs'][] = ['label' => 'Titles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
}
else{
$this->params['breadcrumbs'][] = ['label' => 'Titles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
}
?>
<div class="title-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'course' => $course,
        'supervisors' => $supervisors,
    ]) ?>

</div>
