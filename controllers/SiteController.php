<?php

namespace app\controllers;

use app\models\BalanceDataProvider;
use app\models\BalanceHelper;
use app\models\BalanceHistory;
use app\models\UserIdFormModel;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
	/**
	 * {@inheritdoc}
	 */
	public function behaviors ()
	{
		return [
			'access' => [
				'class' => AccessControl::className (),
				'only'  => ['logout'],
				'rules' => [
					[
						'actions' => ['logout'],
						'allow'   => true,
						'roles'   => ['@'],
					],
				],
			],
			'verbs'  => [
				'class'   => VerbFilter::className (),
				'actions' => [
					'logout' => ['post'],
				],
			],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function actions ()
	{
		return [
			'error'   => [
				'class' => 'yii\web\ErrorAction',
			],
			'captcha' => [
				'class'           => 'yii\captcha\CaptchaAction',
				'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
			],
		];
	}

	/**
	 * Displays homepage.
	 *
	 * @return string
	 */
	public function actionIndex ()
	{
//		return $this->render ( 'index' );
		return $this->actionGetUserBalance ();
	}

	/**
	 * Login action.
	 *
	 * @return Response|string
	 */
	public function actionLogin ()
	{
		if (!Yii::$app->user->isGuest)
		{
			return $this->goHome ();
		}

		$model = new LoginForm();
		if ($model->load ( Yii::$app->request->post () ) && $model->login ())
		{
			return $this->goBack ();
		}

		$model->password = '';

		return $this->render ( 'login', [
			'model' => $model,
		] );
	}

	/**
	 * Logout action.
	 *
	 * @return Response
	 */
	public function actionLogout ()
	{
		Yii::$app->user->logout ();

		return $this->goHome ();
	}

	/**
	 * Displays contact page.
	 *
	 * @return Response|string
	 */
	public function actionContact ()
	{
		$model = new ContactForm();
		if ($model->load ( Yii::$app->request->post () ) && $model->contact ( Yii::$app->params['adminEmail'] ))
		{
			Yii::$app->session->setFlash ( 'contactFormSubmitted' );

			return $this->refresh ();
		}

		return $this->render ( 'contact', [
			'model' => $model,
		] );
	}

	/**
	 * Displays about page.
	 *
	 * @return string
	 */
	public function actionAbout ()
	{
		return $this->render ( 'about' );
	}

	/** Display UserBalance page
	 * @return string
	 * @throws \Exception
	 */
	public function actionGetUserBalance (): string
	{
		$userIdFormModel = new UserIdFormModel();

		if ($userIdFormModel->load ( Yii::$app->request->post () ) && $userIdFormModel->validate ())
		{

			$dataProvider = new BalanceDataProvider([
				'query' => "userBalance",
				'key' => "id",
				'userId' => $userIdFormModel->userId
			]);
			$dataProvider2 = new BalanceDataProvider([
				'query' => "history",
				'key' => "id",
				'limit' => 50,
				'userId' => $userIdFormModel->userId
			]);
			return $this->render ( 'user-balance', ['dataProvider' => $dataProvider, 'dataProvider2' => $dataProvider2] );
		}
		else
		{
			return $this->render ( 'entry-user-id', ['model' => $userIdFormModel] );
		}
	}
}
