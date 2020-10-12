<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\UploadForm;
use yii\web\UploadedFile;
use yii\data\SqlDataProvider;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionUpload()
    {
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->uploadedFiles = UploadedFile::getInstances($model, 'uploadedFiles');
            if ($model->upload()) {
                return $this->render('upload', ['model' => $model, 'success' => true]);
                return;
            }
        }

        return $this->render('upload', ['model' => $model, 'success' => false]);
    }

    public function actionList_upload()
    {
        if (Yii::$app->request->isPost) {
            $provider = new SqlDataProvider([
                'sql' => 'SELECT * FROM `files` WHERE `date_upload` LIKE :date',
                'params' => [':date' => Yii::$app->request->post("date_upload").'%'],
                'sort' => [
                    'attributes' => [
                        'date_upload',
                    ],
                ],
            ]);
        } else {
            $provider = new SqlDataProvider([
                'sql' => 'SELECT * FROM files',
                'sort' => [
                    'attributes' => [
                        'date_upload',
                    ],
                ],
            ]);
        }

        $models = $provider->getModels();

        return $this->render('list_upload', ['provider' => $provider], ['models' => $models]);
    }
}