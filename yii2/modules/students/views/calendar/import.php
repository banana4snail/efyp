<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$session = Yii::$app->session;

$this->title = "Import CSV";
if($session['role']=="admin"){
	$this->params['breadcrumbs'][] = ['label' => 'Calendars', 'url' => ['index']];
	$this->params['breadcrumbs'][] = ['label' => $this->title];
}
?>

<h1>Import CSV</h1>
<h4>Calendar CSV format</h4>
<?= Html::img('@web/sample/calendar_import.PNG', ['alt'=>'some', 'class'=>'thing','height'=>'120','width'=>'450']);?><br/>
<h4>Template: <a href='../web/sample/calendar_sample.csv'download>calendar_sample.csv</a></h4><br/>
<?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data']]); ?>
    <?= $form->field($model,'file')->fileInput() ?><br/>
    
    <div class="form-group"> 
        <?= Html::a('Cancel', ['/students/calendar'], ['class'=>'btn btn-default']) ?>
        <?= Html::submitButton('Save',['class'=>'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end(); ?>