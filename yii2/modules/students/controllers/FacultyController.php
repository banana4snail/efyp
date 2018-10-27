<?php

namespace app\modules\students\controllers;

use Yii;
use app\modules\students\models\Faculty;
use app\modules\students\models\FacultySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\students\models\CsvForm;
use yii\web\UploadedFile;

/**
 * FacultyController implements the CRUD actions for Faculty model.
 */
class FacultyController extends Controller
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
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index','view','create','update','delete','import'],
                        'roles' => ['manageFaculty'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Faculty models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FacultySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Faculty model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $faculty = Faculty::findOne($id);
        $departments = $faculty->departments;

        return $this->render('view',['departments' => $departments,'model' => $faculty]);
    }

    /**
     * Creates a new Faculty model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Faculty();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->facultyID]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Faculty model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->facultyID]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Faculty model.
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
     * Finds the Faculty model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Faculty the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Faculty::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
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
                    $faculty = new Faculty();
                    $faculty->faculty=preg_replace($find, $replace,$hasil[0]);
                    $faculty->save();
                }
                $skip++;    
            }   
            unlink('uploads/'.$filename);
          
            return $this->render('index', [
                'searchModel' => $searchModel= new FacultySearch(),
                'dataProvider' => $searchModel->search(Yii::$app->request->queryParams),
            ]);
        }
        else{
            return $this->render('import',['model'=>$model]);
        }
    }   
}
