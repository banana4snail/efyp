<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$session = Yii::$app->session;

$this->title = "Import CSV";
if($session['role']=="admin"){
	$this->params['breadcrumbs'][] = ['label' => 'Students', 'url' => ['index']];
	$this->params['breadcrumbs'][] = ['label' => $this->title];
}
?>

<h1>Import CSV</h1>
<h4>Student CSV format</h4>
<?= Html::img('@web/sample/student_import.PNG', ['alt'=>'some', 'class'=>'thing','height'=>'75','width'=>'1000']);?><br/>
<h4>Template: <a href='../web/sample/student_sample.csv'download>student_sample.csv</a></h4><br/>
<?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data']]); ?>
    <?= $form->field($model,'file')->fileInput() ?><br/>
    
    <div class="form-group"> 
        <?= Html::a('Cancel', ['/students/students'], ['class'=>'btn btn-default']) ?>
        <?= Html::submitButton('Save',['class'=>'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end(); ?>