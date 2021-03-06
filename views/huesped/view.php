<?php

use yii\helpers\Html;
use app\models\User;
use kartik\detail\DetailView;
use kartik\editable\Editable;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Huesped */

$this->title = 'Huésped '. $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Huéspedes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="huesped-view">

    <h1><?= Html::encode($this->title) ?></h1>


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
                    'heading'=>'Vista Huésped',
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
                    'nombre',
                    'email:email',
                    'calle',
                    'ciudad',
                    'colonia',
                    'estado',
                    'pais',
                    'cp',
                    'telefono',
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
