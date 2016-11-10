<?php
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
?>

<h1>Алиасы url-адресов</h1>

<?php if(Yii::$app->session->hasFlash('success')) { ?>
<div class="alert alert-success">
    <?= Yii::$app->session->getFlash('success') ?>
</div>
<?php } ?>

<p>
    <?= Html::a('<i class="glyphicon glyphicon-plus"></i> ' . 'Cоздать элемент', Url::to('update'), ['class' => 'btn btn-primary']) ?>
</p>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        'slug',
        'route',
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update} {delete}',
            'buttons' => [
                'update' => function($url, $model, $key) {
                    return '<a href="'. Url::toRoute(['update', 'id' => $model->id]) .'" ><span class="glyphicon glyphicon-pencil"></span></a>';
                },
                'delete' => function($url, $model, $key) {
                    return '<a href="'. Url::toRoute(['delete', 'id' => $model->id]) .'" data-method="post" data-confirm="Точно удалить этот объект?"><span class="glyphicon glyphicon-trash"></span></a>';
                }
            ]
        ],
    ],
]) ?>