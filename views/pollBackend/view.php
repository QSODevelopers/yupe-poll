<?php
/**
 * Отображение для view:
 *
 *   @category YupeView
 *   @package  yupe
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
    $this->breadcrumbs = array(
        Yii::app()->getModule('poll')->getCategory() => array(),
        Yii::t('poll', 'Опросы') => array('/poll/pollBackend/index'),
        $model->title,
    );

    $this->pageTitle = Yii::t('poll', 'Опросы - просмотр');

    $this->menu = array(
        array('icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('poll', 'Управление Опросами'), 'url' => array('/poll/pollBackend/index')),
        array('icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('poll', 'Добавить Опрос'), 'url' => array('/poll/pollBackend/create')),
        array('label' => Yii::t('poll', 'Опрос') . ' «' . mb_substr($model->id, 0, 32) . '»'),
        array('icon' => 'fa fa-fw fa-pencil', 'label' => Yii::t('poll', 'Редактирование Опроса'), 'url' => array(
            '/poll/pollBackend/update',
            'id' => $model->id
        )),
        array('icon' => 'fa fa-fw fa-eye', 'label' => Yii::t('poll', 'Просмотреть Опрос'), 'url' => array(
            '/poll/pollBackend/view',
            'id' => $model->id
        )),
        array('icon' => 'fa fa-fw fa-trash-o', 'label' => Yii::t('poll', 'Удалить Опрос'), 'url' => '#', 'linkOptions' => array(
            'submit' => array('/poll/pollBackend/delete', 'id' => $model->id),
            'confirm' => Yii::t('poll', 'Вы уверены, что хотите удалить Опрос?'),
            'csrf' => true,
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('poll', 'Просмотр') . ' ' . Yii::t('poll', 'Опроса'); ?>        <br/>
        <small>&laquo;<?php echo $model->title; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
'data'       => $model,
'attributes' => array(
        'id',
        'title',
        'description',
        'status',
),
)); ?>
