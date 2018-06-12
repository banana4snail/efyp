<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\students\models\Logbook */
/* @var $form yii\widgets\ActiveForm */

$this->params['breadcrumbs'][] = ['label' => 'View Students', 'url' => ['students/view-own-students']];
$this->params['breadcrumbs'][] = ['label' => $student->name, 'url' => ['students/view-own-students-profile','id'=>$student->studentID]];
$this->params['breadcrumbs'][] = ['label' => 'Logbooks', 'url' => ['view-own-studentslb','id'=>$student->studentID]];
$this->params['breadcrumbs'][] = 'Give Comment';

?>

<div class="logbook-form">
	    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'logbookID',
            'week',
            'logbookactivity:ntext',
            'files',
            // 'acknowledgement',
            // 'comment',
            // 'student_fk',
        ],
    ]) ?>


    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'acknowledgement')->radioList($model->acknowledge) ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>