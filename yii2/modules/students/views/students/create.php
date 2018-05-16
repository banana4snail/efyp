<?php

use yii\helpers\Html;

$session = Yii::$app->session;
/* @var $this yii\web\View */
/* @var $model app\modules\students\models\Students */

$this->title = 'Create Students';
if($session['role']=="fypCoordinator"){
    $this->params['breadcrumbs'][] = ['label' => 'Search', 'url' => ['coordinatorhome/search']];
    $this->params['breadcrumbs'][] = ['label' => 'Students', 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
}
else{
    $this->params['breadcrumbs'][] = ['label' => 'Students', 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;  
}
?>
<div class="students-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
