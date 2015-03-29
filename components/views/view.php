<?php $this->render('results', array('model' => $model)); ?>

<?php if ($userVote->id): ?>
	<p id="pollvote-<?php echo $userVote->id ?>">
		<?php echo Yii::t('PollModule.poll', 'You voted'); ?>: <strong><?php echo $userChoice->label ?></strong>.<br />
		<?php
			if ($userCanCancel) {
				echo CHtml::ajaxLink(
					Yii::t('PollModule.poll', 'Cancel Vote'),
					array('/poll/pollvote/delete', 'id' => $userVote->id, 'ajax' => true),
					array(
						'type' => 'POST',
						'success' => 'js:function(){window.location.reload();}',
					),
					array(
						'class' => 'cancel-vote',
						'confirm' => Yii::t('PollModule.poll', 'Are you sure you want to cancel your vote?')
					)
				);
			}
		?>
	</p>
<?php else: ?>
	<p><?php echo CHtml::link(Yii::t('PollModule.poll', 'Vote'), array('/poll/poll/vote', 'id' => $model->id)); ?></p>
<?php endif; ?>
