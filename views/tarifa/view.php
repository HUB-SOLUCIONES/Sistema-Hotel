<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use app\models\User;
use yii\helpers\ArrayHelper;
use kartik\detail\DetailView;
use kartik\editable\Editable;

use app\models\TarifaDetalladaSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Tarifa */

$this->title = 'Tarifa '.$model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Tarifa', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="tarifa-view">
    <div class="col-md-6">
            <?php
            $user= new User();
            echo DetailView::widget([
                'model'=>$model,
                'condensed'=>true,
                'hover'=>true,
                'mode'=>DetailView::MODE_VIEW,
                'deleteOptions'=>[
                  'params'=>['id' => $model->id],
                  'url'=> ['delete', 'id' => $model->id],
                  'data'=> [
                    //'confirm'=>'¿Está seguro que desea eliminar esta habitación?',
                    'method'=>'post',
                  ],
                ],
                'panel'=>[
                    'heading'=>'Vista Tarifa',
                    'type'=>DetailView::TYPE_INFO,
                ],
                'attributes'=>
                [
                    'id',
                    'nombre',
                    [
                      'attribute'=>'id_tipo_habitacion',
                      'format'=>'raw',
                      'label'=>'Tipo Habitación',
                      'displayOnly'=>true,
                    ],
                    [
                        'attribute'=>'fecha_ini',
                        'format'=>'date',
                        'value'=>$model->fecha_ini,
                        'displayOnly'=>true,
                    ],
                    [
                        'attribute'=>'fecha_fin',
                        'format'=>'date',
                        'value'=>$model->fecha_fin,
                        'displayOnly'=>true,
                    ],
                    [
                        'attribute'=>'create_user',
                        'format'=>'raw',
                        'value'=>$user->obtenerNombre($model->create_user),
                        'displayOnly'=>true,
                    ],
                    [
                        'attribute'=>'create_time',
                        'format'=>'date',
                        'value'=>$model->create_time,
                        'displayOnly'=>true,
                    ],
                ]
            ]);

        ?>
    </div>
    <div class="col-md-6">
         <?php
            $searchModel = new TarifaDetalladaSearch();
            $dataProvider = $searchModel->buscarPrecios($model->id);
            $gridColumns = [
                ['class' => 'kartik\grid\SerialColumn'],
                [
                    'attribute' => 'adultos',
                    'vAlign'=>'middle',
                    'headerOptions'=>['class'=>'kv-sticky-column'],
                    'contentOptions'=>['class'=>'kv-sticky-column'],
                ],
                [
                    'attribute' => 'precio',
                    'vAlign'=>'middle',
                    'headerOptions'=>['class'=>'kv-sticky-column'],
                    'contentOptions'=>['class'=>'kv-sticky-column'],
                ]

            ];
            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => $gridColumns,
                'containerOptions' => ['style'=>'overflow: false'], // only set when $responsive = false
                'export' => false,
                'pjax' => true,
                'bordered' => true,
                'striped' => false,
                'condensed' => false,
                'responsive' => true,
                'hover' => true,
                'floatHeader' => false,
                'showPageSummary' => true,
                'panel' => [
                    'heading'=>'Precios',
                    'type' => GridView::TYPE_PRIMARY
                ],
            ]);

        ?>
    </div>




</div>
