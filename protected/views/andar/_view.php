<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('descricao')); ?>:
	<?php echo GxHtml::encode($data->descricao); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('bloco')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->bloco0)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('posicao')); ?>:
	<?php echo GxHtml::encode($data->posicao); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('ativo')); ?>:
	<?php echo GxHtml::encode($data->ativo); ?>
	<br />

</div>