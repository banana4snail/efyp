<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;
use app\modules\students\models\Title;
$session = Yii::$app->session;

$this->title = $students->name;
if($session['role']=="lecturer"){
	$this->params['breadcrumbs'][] = ['label' => 'View Students', 'url' => ['students/view-own-students']];
	$this->params['breadcrumbs'][] = ['label' => $this->title];
}
else if($session['role']=="fypCoordinator"){
    $this->params['breadcrumbs'][] = ['label' => 'Search', 'url' => ['coordinatorhome/search']];	
	$this->params['breadcrumbs'][] = ['label' => 'Students', 'url' => ['index']];
	$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['students/view','id'=>$students->studentID]];
	$this->params['breadcrumbs'][] = ['label' => 'Students Profile'];
}	
else{
	$this->params['breadcrumbs'][] = ['label' => 'Students', 'url' => ['index']];
	$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['students/view','id'=>$students->studentID]];
	$this->params['breadcrumbs'][] = ['label' => 'Students Profile'];
}
?>

<h2><?= Html::encode("Student's Profile") ?></h2>

<div class="box">
	<div class="center">Personal Details</div>
	<div class="details">
		<?= DetailView::widget([
				'model' => $students,
				'attributes' => [
					'name',
					['label' => 'Race',
		            'value' => $students->raceText,
		            ],
		            ['label' => 'Gender',
		            'value' => $students->genderText,
		            ],
		            'studentID',
		            ['label' => 'Faculty',
	                'value' => $students->faculty0->faculty,
	                ],
	                ['label' => 'Course',
	                'value' => $students->course0->courseName,
	                ],
	                'email',
	                'phone',
	                ['label' => 'Category',
	                'value' => $students->fypType0->fypType,
	                ],
	                ['label' => 'FYP Title',
	                'value' => (($title!=null) ? $title->title : "Unregistered"),
	                ],
	                ['label' => 'Supervisor',
	                'value' => (($title!=null) ? $title->supervisor0->name : "Not set"),
	                ],
	                ['label' => 'Co-Supervisor',
	                'value' => (($title!=null) ?($title->coSupervisor!=null)? $title->coSupervisor0->name:"Not set" : "Not set"),
	                ],

	                ['label' => 'Moderator',
	                'value' => (($title!=null) ?($title->moderator!=null)? $title->moderator0->name:"Not set" : "Not set"),


	                ],
				],

			])

		?>
		<div class="btn_wrapper">
		<?php $session = Yii::$app->session;
		if(Yii::$app->user->can('supervisor') && $session['role'] =="lecturer"){ ?>
			<?= Html::a('View Log Book', ['logbook/view-own-studentslb', 'id' => $students->studentID], ['class' => 'btn btn-primary']) ?>
		<?php } ?>

		</div>
	</div>
	<div class="pic">
		<?php echo '<img src="profilepic/'.$students->picture.'">'; ?> 
		
	</div>
</div>

<style type="text/css">
	.box{
		width:1100px;
		height:600px;
		box-shadow: 10px 10px 50px #888888;
		padding:24px;
		border-radius: 25px;
	}

	.center{
		text-align: center;
		font-family: inherit;
		font-size: 18px;
		margin-bottom: 10px;
	}

	.details{
		width: 850px;
		float: left;
	}

	.pic{
		float: left;
		width: 160px;
		height: 180px;
/*		background-color: black;*/
		margin-left: 30px;
	}

	img{
		vertical-align: inherit;
		height: 100%;
	}

	.btn_wrapper{
		float: right;
	}
</style>