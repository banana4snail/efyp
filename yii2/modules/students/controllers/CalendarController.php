<?php

namespace app\modules\students\controllers;

use Yii;
use app\modules\students\models\Calendar;
use app\modules\students\models\CalendarSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\students\models\CsvForm;
use yii\web\UploadedFile;

/**
 * CalendarController implements the CRUD actions for Calendar model.
 */
class CalendarController extends Controller
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
                        'actions' => ['index','view','create','update','delete','view-calendar','import'],
                        'roles' => ['manageCalendar'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view-calendar'],
                        'roles' => ['viewCalendar'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Calendar models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CalendarSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Calendar model.
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
     * Creates a new Calendar model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Calendar();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->calendarID]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Calendar model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->calendarID]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Calendar model.
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
     * Finds the Calendar model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Calendar the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Calendar::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    public function actionViewCalendar()
    {
        $calendar = Calendar::find()
        ->all();

        return $this->render('view-calendar',['calendar'=>$calendar]);

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
                print_r($filecsv);
            }
            $auth = Yii::$app->authManager;

            $skip = 0;
            foreach($filecsv as $data){
                if ($skip != 0){
                    $find = array('/\s+/', '/\"/');
                    $replace = '';
                    $hasil = explode(",",$data);
                    $calendar = new Calendar();
                    $calendar->activities=$hasil[0];
                    $calendar->date=Yii::$app->formatter->asDate($hasil[1], 'yyyy-MM-dd');
                    $calendar->fypTypeID=preg_replace($find, $replace,$hasil[2]);
                    $calendar->save();
                }
                $skip++;    
            }   
            unlink('uploads/'.$filename);
            return $this->redirect(['calendar/index']);
        }
        else{
            return $this->render('../import',['model'=>$model]);
        }
    }   
}
