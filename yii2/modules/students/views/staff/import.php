<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$session = Yii::$app->session;

$this->title = "Import CSV";
if($session['role']=="admin"){
	$this->params['breadcrumbs'][] = ['label' => 'Staff', 'url' => ['index']];
	$this->params['breadcrumbs'][] = ['label' => $this->title];
}
?>

<h1>Import CSV</h1>
<h4>Staff CSV format</h4>
<?= Html::img('@web/sample/staff_import.PNG', ['alt'=>'some', 'class'=>'thing','height'=>'75','width'=>'1000']);?><br/>
<ul>
<li>faculty number will be exactly follow the system, click 
<?= Html::a('here', ['/students/faculty']) ?> for more information</li>
<li>role number will be exactly follow the system, click 
<?= Html::a('here', ['/students/roles']) ?> for more information</li>
<li>first line of csv file will be ignored by the system</li>
<li>default password is <b>password</b></li>
</ul>
<h4>Template: <a href='../web/sample/staff_sample.csv'download>staff_sample.csv</a></h4><br/>
<?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data']]); ?>
    <?= $form->field($model,'file')->fileInput() ?><br/>
    
    <div class="form-group">
        <?= Html::a('Cancel', ['/students/staff'], ['class'=>'btn btn-default']) ?>
        <?= Html::submitButton('Save',['class'=>'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>