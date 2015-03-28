<?php
/**
 * Отображение для _form:
 *
 *   @category YupeView
 *   @package  yupe
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 *
 *   @var $model Poll
 *   @var $form TbActiveForm
 *   @var $this PollBackendController
 **/
$form = $this->beginWidget(
	'bootstrap.widgets.TbActiveForm', array(
		'id'                     => 'poll-form',
		'enableAjaxValidation'   => false,
		'enableClientValidation' => true,
		'htmlOptions'            => array('class' => 'well'),
	)
);
?>

<div class="alert alert-info">
	<?php echo Yii::t('poll', 'Поля, отмеченные'); ?>
	<span class="required">*</span>
	<?php echo Yii::t('poll', 'обязательны.'); ?>
</div>

<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<div class="col-sm-7">
			<?php echo $form->textFieldGroup($model, 'title', [
				'widgetOptions'               => [
					'htmlOptions'             => [
						'class'               => 'popover-help',
						'data-original-title' => $model->getAttributeLabel('title'),
						'data-content'        => $model->getAttributeDescription('title')
					]
				]
			]); ?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-7">
			<?php echo $form->textAreaGroup($model, 'description', [
				'widgetOptions'               => [
					'htmlOptions'             => [
						'class'               => 'popover-help',
						'data-original-title' => $model->getAttributeLabel('description'),
						'data-content'        => $model->getAttributeDescription('description')
					]
				]
			]); ?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-7">
			<?php echo $form->dropDownListGroup($model, 'status', [
				'widgetOptions'               => [
					'data'                    =>$model->statusLabels(),
					'htmlOptions'             => [
						'class'               => 'popover-help',
						'data-original-title' => $model->getAttributeLabel('status'),
						'data-content'        => $model->getAttributeDescription('status')
					]
				]
			]); ?>
		</div>
	</div>

	<table id="poll-choices tble">
		<thead>
			<th><?php echo Yii::t('PollModule.poll', 'Weight'); ?></th>
			<th><?php echo Yii::t('PollModule.poll', 'Label'); ?></th>
			<th><?php echo Yii::t('PollModule.poll', 'Actions'); ?></th>
		</thead>
		<tbody>
		<?php
			$newChoiceCount = 0;
			foreach ($choices as $choice) {
				$this->renderPartial('/pollchoiceBackend/_formChoice', [
					'id' => isset($choice->id) ? $choice->id : 'new'. ++$newChoiceCount,
					'choice' => $choice,
				]);
			}
			++$newChoiceCount; // Increase once more for Ajax additions
		?>
		<tr id="add-pollchoice-row">
			<td class="weight"></td>
			<td class="label">
				<?php echo CHtml::textField('add_choice', '', array('size'=>70, 'id'=>'add_choice', 'class'=>'form-control')); ?>
				<div class="errorMessage" style="display:none"><?php echo Yii::t('PollModule.poll', 'You must enter a label.'); ?></div>
			</td>
			<td class="actions">
				<a href="#" class="btn btn-success" id="add-pollchoice"><?php echo Yii::t('PollModule.poll', 'Add Choice'); ?></a>
			</td>
		</tr>
		</tbody>
	</table>

	<?php
	$this->widget(
		'bootstrap.widgets.TbButton', [
			'buttonType' => 'submit',
			'context'    => 'primary',
			'label'      => Yii::t('poll', 'Сохранить Опрос и продолжить'),
		]
	); ?>
	<?php
	$this->widget(
		'bootstrap.widgets.TbButton', [
			'buttonType' => 'submit',
			'htmlOptions'=> ['name' => 'submit-type', 'value' => 'index'],
			'label'      => Yii::t('poll', 'Сохранить Опрос и закрыть'),
		]
	); ?>

<?php $this->endWidget(); ?>

<?php
$callback = Yii::app()->createUrl('/poll/pollchoiceBackend/ajaxcreate');
$csrfToken = Yii::app()->getRequest()->csrfToken;
$csrfTokenName = Yii::app()->getRequest()->csrfTokenName;
$js = <<<JS
var PollChoice = function(o) {
	this.target = o;
	this.label  = jQuery(".label input", o);
	this.weight = jQuery(".weight select", o);
	this.errorMessage = jQuery(".errorMessage", o);

	var pc = this;

	pc.label.blur(function() {
		pc.validate();
	});
}
PollChoice.prototype.validate = function() {
	var valid = true;

	if (this.label.val() == "") {
		valid = false;
		this.errorMessage.fadeIn();
	}
	else {
		this.errorMessage.fadeOut();
	}

	return valid;
}

var newChoiceCount = {$newChoiceCount};
var addPollChoice = new PollChoice(jQuery("#add-pollchoice-row"));

jQuery("tr", "#poll-choices tbody").each(function() {
	new PollChoice(jQuery(this));
});

jQuery("#add-pollchoice").click(function() {
	if (addPollChoice.validate()) {
		jQuery.ajax({
			url: "{$callback}",
			type: "POST",
			dataType: "json",
			data: {
				id: "new"+ newChoiceCount,
				label: addPollChoice.label.val(),
				{$csrfTokenName}: "{$csrfToken}"
			},
			success: function(data) {
				addPollChoice.target.before(data.html);
				addPollChoice.label.val('');
				new PollChoice(jQuery('#'+ data.id));
			}
		});

		newChoiceCount += 1;
	}

	return false;
});
JS;

Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerScript('pollHelp', $js, CClientScript::POS_END);
?>