<tr id="pollchoice-<?php echo $id ?>">
	<td class="weight">
		<?php echo CHtml::activeDropDownList($choice,"[$id]weight",$choice->weights, ['class'=>'form-control']); ?>
		<?php echo CHtml::error($choice,"[$id]weight"); ?>
	</td>
	<td class="label">
		<?php echo CHtml::activeTextField($choice,"[$id]label",['size'=>60,'maxlength'=>255, 'class'=>'form-control']); ?>
		<?php echo CHtml::error($choice,"[$id]label"); ?>
		<div class="errorMessage" style="display:none">You must enter a label.</div>
	</td>
	<td class="actions">
	<?php
		$deleteJs = 'jQuery("#pollchoice-'. $id .'").find("td").fadeOut(1000,function(){jQuery(this).parent().remove();});return false;';

		if (isset($choice->id)) {
			// Add AJAX delete link
			echo CHtml::ajaxLink(
				Yii::t('PollModule.poll', 'Delete'),[
					'/poll/pollchoiceBackend/delete',
					'id'      => $choice->id,
					'ajax'    => true
				],[
					'type'    => 'POST',
					'success' => 'js:function(){'. $deleteJs .'}'
				],[
					'confirm' => 'Are you sure you want to delete this item?',
					'class'   =>'btn btn-danger'
				]
			);
		}
		else {
			// Model hasn't been created yet, so just remove the DOM element
			echo CHtml::link(Yii::t('PollModule.poll', 'Delete'), '#',[
				'onclick' => 'js:'. $deleteJs,
				'class'   =>'btn btn-danger'
			]);
		}
		// Add additional hidden fields
		echo CHtml::activeHiddenField($choice,"[$id]id");
	?>
	</td>
</tr>
