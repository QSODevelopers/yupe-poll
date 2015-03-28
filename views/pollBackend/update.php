<?php
/**
 * Отображение для update:
 *
 *   @category YupeView
 *   @package  yupe
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
    $this->breadcrumbs = [
        Yii::app()->getModule('poll')->getCategory() => [],
        Yii::t('poll', 'Опросы') => ['/poll/pollBackend/index'],
        $model->title => ['/poll/pollBackend/view', 'id' => $model->id],
        Yii::t('poll', 'Редактирование'),
    ];

    $this->pageTitle = Yii::t('poll', 'Опросы - редактирование');

    $this->menu = [
        ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('poll', 'Управление Опросами'), 'url' => ['/poll/pollBackend/index']],
        ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('poll', 'Добавить Опрос'), 'url' => ['/poll/pollBackend/create']],
        ['label' => Yii::t('poll', 'Опрос') . ' «' . mb_substr($model->id, 0, 32) . '»'],
        ['icon' => 'fa fa-fw fa-pencil', 'label' => Yii::t('poll', 'Редактирование Опроса'), 'url' => [
            '/poll/pollBackend/update',
            'id' => $model->id
        ]],
        ['icon' => 'fa fa-fw fa-eye', 'label' => Yii::t('poll', 'Просмотреть Опрос'), 'url' => [
            '/poll/pollBackend/view',
            'id' => $model->id
        ]],
        ['icon' => 'fa fa-fw fa-trash-o', 'label' => Yii::t('poll', 'Удалить Опрос'), 'url' => '#', 'linkOptions' => [
            'submit' => ['/poll/pollBackend/delete', 'id' => $model->id],
            'confirm' => Yii::t('poll', 'Вы уверены, что хотите удалить Опрос?'),
            'csrf' => true,
        ]],
    ];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('poll', 'Редактирование') . ' ' . Yii::t('poll', 'Опроса'); ?>        <br/>
        <small>&laquo;<?php echo $model->title; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', ['model' => $model, 'choices'=>$choices]); ?>