<?php
if ($this->action === 'create') {
	$pageTitle = __('Add %s', $model->singularName);
	$buttonTitle = __('Create');
	$result = null;
} else {
	$pageTitle = __('Edit %s', $model->singularName);
	$buttonTitle = __('Update');
}

$this->Admin->setBreadcrumbs($model, $result, $this->action);

echo $this->element('action_buttons'); ?>

<h2><?php echo $this->Admin->outputIconTitle($model, $pageTitle); ?></h2>

<?php echo $this->Form->create($model->alias, array('class' => 'form-horizontal', 'file' => true)); ?>

<fieldset>
	<?php // Loop over primary model fields
	foreach ($model->fields as $field => $data) {
		if (($this->action === 'create' && $field === 'id') || in_array($field, $model->admin['hideFields'])) {
			continue;
		}

		echo $this->element('input', array(
			'field' => $field,
			'data' => $data
		));
	} ?>
</fieldset>

<?php // Display HABTM fields
$habtm = array();

foreach ($model->hasAndBelongsToMany as $alias => $assoc) {
	if ($assoc['showInForm']) {
		$habtm[$alias] = $assoc;
	}
}

if ($habtm) { ?>

	<fieldset>
		<legend><?php echo __('Associate With'); ?></legend>

		<?php foreach ($habtm as $alias => $assoc) {
			$assoc['type'] = 'relation';
			$assoc['title'] = $this->Admin->introspect($assoc['className'])->pluralName;
			$assoc['hasAndBelongsToMany'] = true;

			echo $this->element('input', array(
				'field' => $alias,
				'data' => $assoc
			));
		} ?>
	</fieldset>

<?php } ?>

<div class="well align-center">
	<?php echo $this->element('redirect_to'); ?>

	<button type="submit" class="btn btn-large btn-success">
		<span class="icon-edit icon-white"></span>
		<?php echo $buttonTitle; ?>
	</button>

	<button type="reset" class="btn btn-large btn-info">
		<span class="icon-refresh icon-white"></span>
		<?php echo __('Reset'); ?>
	</button>

	<a href="<?php echo $this->Html->url(array('action' => 'index', 'model' => $model->urlSlug)); ?>" class="btn btn-large">
		<span class="icon-ban-circle"></span>
		<?php echo __('Cancel'); ?>
	</a>
</div>

<?php echo $this->Form->end(); ?>