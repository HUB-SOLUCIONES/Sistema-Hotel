<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;

use yii\bootstrap\Modal;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\models\HabitacionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Habitaciones';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="habitacion-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::button('Crear Habitación', ['value'=>Url::to('../habitacion/create'), 'class' => 'btn btn-success', 'id' => 'modalButton']) ?>
    </p>

    <?php
      Modal::begin([
        'header' => '<h4>Crear Caja</h4>',
        'id' => 'modal',
        'size' => 'modal-lg',
      ]);

      echo "<div id='modalContent'></div>";

      Modal::end();
    ?>

    <?php Pjax::begin(); ?>

    <p>
        <?= Html::a('Tipo Habitación', ['/tipo-habitacion/index'], ['class'=>'btn']) ?>
    </p>

    <?php
            $gridColumns = [
                ['class' => 'kartik\grid\SerialColumn'],
                [
                    'attribute' => 'id',
                    'vAlign'=>'middle',
                    'headerOptions'=>['class'=>'kv-sticky-column'],
                    'contentOptions'=>['class'=>'kv-sticky-column'],
                ],
                [
                    'attribute' => 'descripcion',
                    'vAlign'=>'middle',
                    'headerOptions'=>['class'=>'kv-sticky-column'],
                    'contentOptions'=>['class'=>'kv-sticky-column'],
                ],
                [
                    'attribute' => 'status',
                    'value'=>function ($model, $key, $index, $widget) {
                        return $model->obtenerEstado($model->status);
                    },
                    'vAlign'=>'middle',
                    'headerOptions'=>['class'=>'kv-sticky-column'],
                    'contentOptions'=>['class'=>'kv-sticky-column'],
                    'format'=>'raw'
                ],
                [
                    'attribute' => 'tipo_habitacion',
                    'value'=>function ($model, $key, $index, $widget) {
                        return $model->obtenerTipoHabitacion($model->tipo_habitacion);
                    },
                    'vAlign'=>'middle',
                    'headerOptions'=>['class'=>'kv-sticky-column'],
                    'contentOptions'=>['class'=>'kv-sticky-column'],
                    'format'=>'raw'
                ],
                [
                    'attribute' => 'capacidad',
                    'vAlign'=>'middle',
                    'headerOptions'=>['class'=>'kv-sticky-column'],
                    'contentOptions'=>['class'=>'kv-sticky-column'],
                ],

                [
                    'class' => 'kartik\grid\ActionColumn',
                    'template'=>'{view}{delete}',
                    'vAlign'=>'middle',

                ],
            ];

            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => $gridColumns,
                'containerOptions' => ['style'=>'overflow: false'], // only set when $responsive = false
                'beforeHeader'=>[
                    [
                        'options'=>['class'=>'skip-export'] // remove this row from export
                    ]
                ],
                'toolbar' =>  [
                    '{export}',
                    '{toggleData}'
                ],
                'pjax' => true,
                'bordered' => true,
                'striped' => false,
                'condensed' => false,
                'responsive' => true,
                'hover' => true,
                'floatHeader' => false,
                'showPageSummary' => true,
                'panel' => [
                    'type' => GridView::TYPE_PRIMARY
                ],
            ]);

        ?>
    <?php Pjax::end(); ?>
</div>