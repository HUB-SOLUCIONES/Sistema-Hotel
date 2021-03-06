<?php

namespace app\controllers;

use Yii;
use app\models\Tarifa;
use app\models\TarifaDetallada;
use app\models\TarifaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\RegistroSistema;
use app\models\Model;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/**
 * TarifaController implements the CRUD actions for Tarifa model.
 */
class TarifaController extends Controller
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
        ];
    }

    /**
     * Lists all Tarifa models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TarifaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $id_current_user = Yii::$app->user->identity->id;
        $privilegio = Yii::$app->db->createCommand('SELECT * FROM privilegio WHERE id_usuario = '.$id_current_user)->queryAll();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'privilegio'=>$privilegio,
        ]);
    }

    /**
     * Displays a single Tarifa model.
     * @param integer $id
     * @return mixed
     */
     public function actionView($id)
     {
         $model = $this->findModel($id);
         $registroSistema= new RegistroSistema();
         if ($model->load(Yii::$app->request->post()))
         {
             $registroSistema->descripcion = Yii::$app->user->identity->nombre ." ha actualizado la tarifa ". $model->nombre;
             $id_current_user = Yii::$app->user->identity->id;
             $privilegio = Yii::$app->db->createCommand('SELECT * FROM privilegio WHERE id_usuario = '.$id_current_user)->queryAll();

             if($privilegio[0]['modificar_tarifa'] == 1){
               if ($model->save() && $registroSistema->save())
               {
                   Yii::$app->session->setFlash('kv-detail-success', 'La información se actualizo correctamente');
                   return $this->redirect(['view', 'id'=>$model->id]);
               }
               else
               {
                   Yii::$app->session->setFlash('kv-detail-warning', 'Ha ocurrido un error al guardar la información');
                   return $this->redirect(['view', 'id'=>$model->id]);

               }
             }
             else{
               Yii::$app->session->setFlash('kv-detail-warning', 'No tienes los permisos para realizar esta acción');
               return $this->redirect(['view', 'id'=>$model->id]);
             }
         }
         else
         {
             return $this->render('view', ['model'=>$model]);

         }
     }

    /**
     * Creates a new Tarifa model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $id_current_user = Yii::$app->user->identity->id;
        $privilegio = Yii::$app->db->createCommand('SELECT * FROM privilegio WHERE id_usuario = '.$id_current_user)->queryAll();

        if($privilegio[0]['crear_tarifa'] == 1){
          $modelTarifa = new Tarifa;
          $registroSistema= new RegistroSistema();
          $modelsTarifaDetallada = [new TarifaDetallada];
          if ($modelTarifa->load(Yii::$app->request->post()))
          {
              $registroSistema->descripcion = Yii::$app->user->identity->nombre ." ha creado la tarifa ". $modelTarifa->nombre;
              $modelTarifa->create_user=Yii::$app->user->identity->id;
              $modelTarifa->create_time=date('Y-m-d H:i:s');
              $registroSistema->save();
              $modelTarifaDetallada = Model::createMultiple(TarifaDetallada::classname());
              Model::loadMultiple($modelTarifaDetallada, Yii::$app->request->post());
              // ajax validation
              if (Yii::$app->request->isAjax)
              {
                  Yii::$app->response->format = Response::FORMAT_JSON;
                  return ArrayHelper::merge(
                      ActiveForm::validateMultiple($modelTarifaDetallada),
                      ActiveForm::validate($modelTarifa)
                  );
              }
              // validate all models
              $valid = $modelTarifa->validate();
              //$modelTarifaDetallada->id_tarifa=0;
              $validacion=Model::validateMultiple($modelTarifaDetallada);
              //$valid =  $validacion && $valid;
              if ($valid)
              {
                  $transaction = \Yii::$app->db->beginTransaction();
                  try
                  {
                      if ($flag = $modelTarifa->save(false))
                      {
                          foreach ($modelTarifaDetallada as $modelTarifaDetallada)
                          {
                              $modelTarifaDetallada->id_tarifa = $modelTarifa->id;
                              if (! ($flag = $modelTarifaDetallada->save(false)))
                              {
                                  $transaction->rollBack();
                                  break;
                              }
                          }
                      }
                      if ($flag)
                      {
                          $transaction->commit();
                          return $this->redirect(['view', 'id' => $modelTarifa->id]);
                      }
                  } catch (Exception $e) {
                      $transaction->rollBack();
                  }
              }
          }
        }
        else{
          return $this->redirect(['index']);
        }

        return $this->render('_form', [
            'modelTarifa' => $modelTarifa,
            'modelTarifaDetallada' => (empty($modelTarifaDetallada)) ? [new TarifaDetallada] : $modelsTarifaDetallada
        ]);
    }


    /**
     * Updates an existing Tarifa model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $tarifa = $this->findModel($id);

        $tarifa->create_user=Yii::$app->user->identity->id;
        $tarifasDetallada = $tarifa->detalleTarifa($tarifa->id);

        if ($tarifa->load(Yii::$app->request->post()))
        {

            $oldIDs = ArrayHelper::map($tarifasDetallada, 'id', 'id');
            $tarifasDetallada = Model::createMultiple(TarifaDetallada::classname(), $tarifasDetallada);
            Model::loadMultiple($tarifasDetallada, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($tarifasDetallada, 'id', 'id')));

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($tarifasDetallada),
                    ActiveForm::validate($tarifa)
                );
            }

            // validate all models
            $valid = $tarifa->validate();
            $valid = Model::validateMultiple($tarifasDetallada) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $tarifa->save()) {
                        if (! empty($deletedIDs)) {
                            TarifaDetallada::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($tarifasDetallada as $tarifaDetallada) {
                            $tarifaDetallada->id_tarifa = $tarifa->id;
                            if (! ($flag = $tarifaDetallada->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $tarifa->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('update', [
            'tarifa' => $tarifa,
            'tarifasDetallada' => (empty($tarifasDetallada)) ? [new TarifaDetallada] : $tarifasDetallada
        ]);











    }

    /**
     * Deletes an existing Tarifa model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
     public function actionDelete($id)
    	{

    		$model = $this->findModel($id);
        $id_current_user = Yii::$app->user->identity->id;
        $privilegio = Yii::$app->db->createCommand('SELECT * FROM privilegio WHERE id_usuario = '.$id_current_user)->queryAll();

        if($privilegio[0]['eliminar_tarifa'] == 1){
      		$registroSistema= new RegistroSistema();

         $model->eliminado = 1;
    			$registroSistema->descripcion = Yii::$app->user->identity->nombre ." ha eliminado la tarifa ". $model->nombre;

    			if($model->save() && $registroSistema->save()){
            Yii::$app->session->setFlash('kv-detail-success', 'La tarifa se ha eliminado correctamente');
     				return $this->redirect(['index']);
     			}
        }
        else{
          Yii::$app->session->setFlash('kv-detail-warning', 'No tienes los permisos para realizar esta acción');
          return $this->redirect(['view', 'id'=>$model->id]);
        }

    	}

    /**
     * Finds the Tarifa model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tarifa the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tarifa::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
