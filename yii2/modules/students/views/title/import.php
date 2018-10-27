<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$session = Yii::$app->session;

$this->title = "Import CSV";
if($session['role']=="admin"){
	$this->params['breadcrumbs'][] = ['label' => 'Titles', 'url' => ['index']];
	$this->params['breadcrumbs'][] = ['label' => $this->title];
}
?>

<h1>Import CSV</h1>
<?= Html::img('@web/sample/title_import.PNG', ['alt'=>'some', 'class'=>'thing','height'=>'80','width'=>'1200']);?><br/>
<h4>Template: <a href='../web/sample/title_sample.csv'download>title_sample.csv</a></h4><br/>
<?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data']]); ?>
    <?= $form->field($model,'file')->fileInput() ?><br/>
    
    <div class="form-group"> 
        <?= Html::a('Cancel', ['/students/title'], ['class'=>'btn btn-default']) ?>
        <?= Html::submitButton('Save',['class'=>'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end(); ?>