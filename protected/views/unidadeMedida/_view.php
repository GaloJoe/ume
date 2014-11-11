<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('empreendimento')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->empreendimento0)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('descricao')); ?>:
	<?php echo GxHtml::encode($data->descricao); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('tipo_unidade_medida')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->tipoUnidadeMedida)); ?>
	<br />

</div>