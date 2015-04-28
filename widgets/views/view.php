<div class="panel panel-default">

	<div class="panel-heading">
		<div class="panel-title">
			<i class="glyphicon glyphicon-user"></i>
			<?php echo Yii::t('PollModule.poll', 'Poll'); ?>
		</div>
	</div>

	<div class="panel-body">
		<?php echo $this->title; ?>

		<?php $this->render('results', array('model' => $model)); ?>

		<?php if ($userVote->id): ?>
			<p id="pollvote-<?php echo $userVote->id ?>">
				<?php echo Yii::t('PollModule.poll', 'You voted'); ?>: <strong><?php echo $userChoice->label ?></strong>.<br />
				<?php
					if ($userCanCancel) {
						$csrfToken = Yii::app()->getRequest()->csrfToken;
						$csrfTokenName = Yii::app()->getRequest()->csrfTokenName;
						echo CHtml::ajaxLink(
							Yii::t('PollModule.poll', 'Cancel Vote'),
							array('/poll/pollvoteBackend/delete', 'id' => $userVote->id, 'ajax' => true),
							array(
								'data'=>[$csrfTokenName=>$csrfToken],
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
	</div>
</div>