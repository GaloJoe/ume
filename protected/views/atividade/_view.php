<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('unidade_medida')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->unidadeMedida)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('descricao')); ?>:
	<?php echo GxHtml::encode($data->descricao); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('valor_unitario')); ?>:
	<?php echo GxHtml::encode($data->valor_unitario); ?>
	<br />

</div>