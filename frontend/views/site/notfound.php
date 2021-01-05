<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = 'Acceso Denegado';
?>
<div class="site-error">

    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

    <div class="row clearfix">
        <div class="col-md-offset-4 col-md-4">
            <div class="alert alert-danger text-center">
                El horario de registro del personal para el almuerzo es de 5:00 AM a 9:00 AM
            </div>
        </div>
    </div>

</div>
