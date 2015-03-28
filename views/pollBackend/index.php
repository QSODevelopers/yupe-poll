<?php
/**
 * Отображение для index:
 *
 *   @category YupeView
 *   @package  yupe
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
    $this->breadcrumbs = [
        Yii::app()->getModule('poll')->getCategory() => [],
        Yii::t('PollModule.poll', 'Опросы') => ['/poll/pollBackend/index'],
        Yii::t('PollModule.poll', 'Управление'),
    ];

    $this->pageTitle = Yii::t('PollModule.poll', 'Опросы - управление');

    $this->menu = [
        ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('PollModule.poll', 'Управление Опросами'), 'url' => ['/poll/pollBackend/index']],
        ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('PollModule.poll', 'Добавить Опрос'), 'url' => ['/poll/pollBackend/create']],
    ];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('PollModule.poll', 'Опросы'); ?>
        <small><?php echo Yii::t('PollModule.poll', 'управление'); ?></small>
    </h1>
</div>

<p>
    <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
        <i class="fa fa-search">&nbsp;</i>
        <?php echo Yii::t('PollModule.poll', 'Поиск Опросов');?>
        <span class="caret">&nbsp;</span>
    </a>
</p>

<div id="search-toggle" class="collapse out search-form">
    <?php
    Yii::app()->clientScript->registerScript('search', "
        $('.search-form form').submit(function () {
            $.fn.yiiGridView.update('poll-grid', {
                data: $(this).serialize()
            });

            return false;
        });
    ");
    $this->renderPartial('_search', ['model' => $model]);
?>
</div>

<br/>

<p><?php echo Yii::t('PollModule.poll', 'В данном разделе представлены средства управления Опросами'); ?></p>

<?php
 $this->widget('yupe\widgets\CustomGridView', [
    'id'           => 'poll-grid',
    'type'         => 'striped condensed',
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'columns'      => [
                'id',
                'title',
                'description',
                'status'=>[
                    'name'=>'status',
                    'filter'=>$model->statusLabels()
                ],
        [
            'class' => 'yupe\widgets\CustomButtonColumn',
        ],
    ],
]); ?>
