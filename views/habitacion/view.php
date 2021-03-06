<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\editable\Editable;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use app\models\User;

use app\models\TipoHabitacion;

/* @var $this yii\web\View */
/* @var $model app\models\Habitacion */

$this->title = 'Habitación '.$model->descripcion;
$this->params['breadcrumbs'][] = ['label' => 'Habitaciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="habitacion-view">

    <h1><?= Html::encode($this->title) ?></h1>


<div class="row">
  <div class="col-md-6">

        <?php
        $user= new User();
        /*if($privilegio[0]['crear_habitacion'] == 0){


        $js = "function(){
          $(_grid).options({
              mode:view,
          });
        }";
      } else{
        $js = "function(){
          $(_grid).options({
              mode:edit,
          });
        }";
      }*/
            echo DetailView::widget([
                'model'=>$model,
                'condensed'=>true,
                'hover'=>true,
                'options'=>[
                    'id'=>'_grid',
                ],
                'mode' =>DetailView::MODE_VIEW,
                'deleteOptions'=>[
                  'params'=>['id' => $model->id],
                  'url'=> ['delete', 'id' => $model->id],
                  'data'=> [
                    //'confirm'=>'¿Está seguro que desea eliminar esta habitación?',
                    'method'=>'post',
                  ],
                ],
                'panel'=>[
                    'heading'=>'Vista Habitación',
                    'type'=>DetailView::TYPE_INFO,

                ],
                'attributes'=>
                [
                    [
                      'attribute'=>'id',
                      'format'=>'raw',
                      'label'=>'ID',
                      'displayOnly'=>true,
                    ],
                    'descripcion',
                    [
                        'attribute'=>'tipo_habitacion',
                        'format'=>'raw',
                        'value'=>  $model->obtenerTipoHabitacion($model->tipo_habitacion),
                        'type'=>DetailView::INPUT_SELECT2,
                        'widgetOptions'=>[
                            'data'=>ArrayHelper::map(TipoHabitacion::find()->all(), 'id', 'descripcion'),
                            'options' => ['placeholder' => 'Selecciona una opción'],
                            'pluginOptions' => ['allowClear'=>true, 'width'=>'100%'],
                        ],
                    ],
                    [
                        'attribute'=>'status',
                        'label'=>'Estado',
                        'format'=>'raw',
                        'value'=>$model->status ? '<span class="label label-success">Activa </span>' : '<span class="label label-danger">Inactiva</span>',
                        'type'=>DetailView::INPUT_SWITCH,
                        'widgetOptions' =>
                        [
                            'pluginOptions' =>
                            [
                                'onText' => 'Activa',
                                'offText' => 'Inactiva',
                            ]
                        ],
                    ],
                    'capacidad',
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
      </div>
</div>
