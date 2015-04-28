<div class="label">
	<?php echo CHtml::encode($choice->label); ?>
</div>
<?php
	$this->widget(
		'booster.widgets.TbProgress',
		array(
			'context' => 'info', // 'success', 'info', 'warning', or 'danger'
			'percent' => $percent,
		)
	);
?>
<div class="pull-right">
	<span class="percent"><?php echo $percent; ?>%</span>
	<span class="votes">(<?php echo $voteCount; ?> <?php echo $voteCount == 1 ? Yii::t('PollModule.poll', 'Vote') : Yii::t('PollModule.poll', 'Votes'); ?>)</span>
</div>
<div class="clearfix"></div>