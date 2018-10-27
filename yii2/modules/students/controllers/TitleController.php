<?php

namespace app\modules\students\controllers;

use Yii;
use app\modules\students\models\Title;
use app\modules\students\models\TitleSearch;
use app\modules\students\models\CsvForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\students\models\Course;
use yii\web\UploadedFile;

use yii\db\Query;

/**
 * TitleController implements the CRUD actions for Title model.
 */
class TitleController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            // 'access' => [
            //     'class' => \yii\filters\AccessControl::className(),
            //     'rules' => [
            //         [
            //             'allow' => true,
            //             'actions' => ['index','view','create','update','delete','updateform','import'],
            //             'roles' => ['manageTitle'],
            //         ],
            //         [
            //             'allow' => true,
            //             'actions' => ['view-title','view-details'],
            //             'roles' => ['viewTitle'],
            //         ],
            //         [
            //             'allow' => true,
            //             'actions' => ['allocate-students'],
            //             'roles' => ['allocateTitle'],
            //         ],
            //     ],
            // ],
        ];
    }

    /**
     * Lists all Title models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TitleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Title model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Title model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Title();

        $connection = \Yii::$app->db;
        $sql = $connection->createCommand('SELECT * FROM staff WHERE `role` like "%3%"');
        $supervisors = $sql->queryAll();

        // var_dump($supervisors);exit();
        $course = Course::find()
                    ->all();

        if ($model->load($post = Yii::$app->request->post())) {

          
          
            if($post['Title']['courseArray']){
                $model->course = implode(",", $post['Title']['courseArray']);
            }
            // var_dump($model);exit();
          
            $model->save();

            return $this->redirect(['view', 'id' => $model->titleID]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'course' => $course,
                'supervisors' => $supervisors,
            ]);
        }
    }

    /**
     * Updates an existing Title model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        // var_dump($model);exit();

        $connection = \Yii::$app->db;
        $sql = $connection->createCommand('SELECT * FROM staff WHERE `role` like "%3%"');
        $supervisors = $sql->queryAll();

        $course = Course::find()
                    ->all();

        if ($model->load($post = Yii::$app->request->post()) ) {
            
            if($post['Title']['courseArray'][1]){
                array_shift($post['Title']['courseArray']);
                $model->course = implode(",", $post['Title']['courseArray']);
            }
            
          // var_dump($model);exit();
            $model->save();

            return $this->redirect(['view', 'id' => $model->titleID]);
        } else {

          // var_dump($model->course);exit();

          $courseArray = explode(",", $model->course);

            return $this->render('update', [
                'model' => $model,
                'course' => $course,
                'courseArray' => $courseArray,
                'supervisors' => $supervisors,
            ]);
        }
    }

    /**
     * Deletes an existing Title model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Title model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Title the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Title::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionViewTitle()
    {
        $titles = Title::find()
        ->all();

        return $this->render('view-title',['titles'=>$titles]);

    }

        public function actionViewDetails($id)
    {

        // var_dump($id); exit();
        // $model = $this->findModel($id);
        // var_dump($model);exit();
        $titles = Title::find()
        ->where(['titleID'=>$id])
        ->one();

        // $superVisor = $titles->supervisor0->name;

        // var_dump($superVisor);exit();
        return $this->render('view-details',['titles'=>$titles]);

    }

    public function actionAllocateStudents($user){
        
        $titles = Title::find()
        ->where(['supervisor'=>$user])
        ->all();

        return $this->render('allocate-students',['titles'=>$titles]);
    }

    public function actionRegisterStudent($student,$title){

        $model = $this->findModel($title);
        $model->student_fk = $student;
        $model->status = 1;
        $model->save();
        $titles = Title::find()
        ->where(['supervisor'=>1])
        ->all();
        // var_dump($student);exit();
        // $result = Yii::$app->db->createCommand('UPDATE title SET status=:1,student_fk=:$studentID WHERE titleID=:$titleID') ->execute();
          return $this->redirect(['lecturerhome/index']);
    }

    public function actionImport()
    {
        $model = new CsvForm;

        if ($model->load($post = Yii::$app->request->post())) {
            
            $file = UploadedFile::getInstance($model,'file');
            $filename = 'Data.'.$file->extension;
            $upload = $file->saveAs('uploads/'.$filename);

            if($upload){
                define('CSV_PATH','uploads/');
                $csv_file = CSV_PATH . $filename;
                $filecsv = file($csv_file);
                //print_r($filecsv);
            }
            $auth = Yii::$app->authManager;

            $skip = 0;
            foreach($filecsv as $data){
                if ($skip != 0){
                    $find = array('/\s+/', '/\"/');
                    $replace = '';
                    $hasil = explode(",",$data);
                    $title = new Title();
                    $title->title = $hasil[0];
                    $title->batch= $hasil[1];
                    $title->category= $hasil[2];
                    $title->faculty= $hasil[3];
                    $title->departments= $hasil[4];
                    $title->descriptions= $hasil[5];
                    $title->equipment= $hasil[6];
                    $title->requirements= $hasil[7];
                    $title->industrialLinks= $hasil[8];
                    $title->commProjects= $hasil[9];
                    $title->supervisor= $hasil[10];
                    $title->coSupervisor= $hasil[11];
                    $title->moderator= $hasil[12];
                    if(isset($hasil[15])){
                        $title->course= preg_replace($find, $replace, $hasil[13].','.$hasil[14].','.$hasil[15]);
                    }elseif(isset($hasil[14])){
                        $title->course= preg_replace($find, $replace, $hasil[13].','.$hasil[14]);
                    }elseif(isset($hasil[13])){
                        $title->course= $hasil[13];
                    }
                    $title->save();
                }
                $skip++;    
            }   
            unlink('uploads/'.$filename);

        return $this->render('index', [
            'searchModel' => $searchModel = new TitleSearch(),
            'dataProvider' => $searchModel->search(Yii::$app->request->queryParams),
        ]);
        }
        else{
            return $this->render('import',['model'=>$model]);
        }
    }   
}
