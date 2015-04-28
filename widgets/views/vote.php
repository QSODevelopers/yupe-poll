<div class="panel panel-default">

	<div class="panel-heading">
		<div class="panel-title">
			<i class="glyphicon glyphicon-user"></i>
			<?php echo Yii::t('PollModule.poll', 'Poll'); ?>
		</div>
	</div>

	<div class="panel-body">
		<p><?php echo $this->title; ?></p>
		<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
			'id'=>'portlet-poll-form',
			'enableAjaxValidation'=>false,
		)); ?>

			<?php echo $form->errorSummary($model); ?>

			<?php echo $form->radioButtonListGroup($userVote, 'choice_id', [
				'widgetOptions'=>[
					'data'=>$choices,
				]
			]); ?>

			<?php $this->widget('bootstrap.widgets.TbButton', [
				'buttonType'=>'submit',
				'context'=>'primary',
				'label'=>Yii::t('PollModule.poll', 'Vote')
			]) ?>

		<?php $this->endWidget(); ?>
	</div>

</div>