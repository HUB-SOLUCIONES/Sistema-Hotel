<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\editable\Editable;
use yii\helpers\Url;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\TipoHabitacion */

$this->title ='Tipo de Habitación '. $model->descripcion;
$this->params['breadcrumbs'][] = ['label' => 'Tipo Habitaciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipo-habitacion-view">
    <h1><?= Html::encode($this->title) ?></h1>


<div class="row">
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
                    'heading'=>'Vista Tipo de Habitación',
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
                        'attribute'=>'create_time',
                        'format'=>'date',
                        'value'=>$model->create_time,
                        'displayOnly'=>true,
                    ],
                    [
                        'attribute'=>'create_user',
                        'format'=>'raw',
                        'value'=>$user->obtenerNombre($model->create_user),
                        'displayOnly'=>true,
                    ],
                ]
            ]);

        ?>
        </div>

</div>
