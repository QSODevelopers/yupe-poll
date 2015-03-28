<?php
/**
 * Отображение для create:
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
        Yii::t('poll', 'Добавление'),
    ];

    $this->pageTitle = Yii::t('poll', 'Опросы - добавление');

    $this->menu = [
        ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('poll', 'Управление Опросами'), 'url' => ['/poll/pollBackend/index']],
        ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('poll', 'Добавить Опрос'), 'url' => ['/poll/pollBackend/create']],
    ];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('poll', 'Опросы'); ?>
        <small><?php echo Yii::t('poll', 'добавление'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', ['model' => $model, 'choices'=>$choices]); ?>