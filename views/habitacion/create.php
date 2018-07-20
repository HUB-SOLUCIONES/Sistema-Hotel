<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Habitacion */

$this->title = 'Crear Habitación';
$this->params['breadcrumbs'][] = ['label' => 'Habitaciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="habitacion-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
