<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>

<h1><?= $id == '' ? 'Создание ЧПУ' : 'Редактирование ЧПУ' ?></h1>

<div class="row">
    <div class="col-lg-12">

    <?php $form = ActiveForm::begin([
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
            'horizontalCssClasses' => [
                'label' => 'col-sm-4',
                'offset' => 'col-sm-offset-4',
                'wrapper' => 'col-sm-8',
                'error' => '',
                'hint' => '',
            ],
        ],
    ]); ?>

    <?= $form->field($model, 'slug')
            ->textInput(['maxlength' => true])
            ->label('ЧПУ (slug)') ?>

    <?= $form->field($model, 'route')
            ->textInput(['maxlength' => true])
            ->label('Маршрут') ?>

    <?= Html::submitButton($id == '' ? 'Создать' : 'Обновить', ['class' => $id == '' ? 'btn btn-success' : 'btn btn-primary']) ?>

    <?php ActiveForm::end() ?>
        
    </div>
</div>