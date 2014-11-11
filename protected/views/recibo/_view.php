<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('empreiteiro')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->empreiteiro0)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('data_inicial')); ?>:
	<?php echo GxHtml::encode($data->data_inicial); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('data_final')); ?>:
	<?php echo GxHtml::encode($data->data_final); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('usuario')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->usuario0)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('ativo')); ?>:
	<?php echo GxHtml::encode($data->ativo); ?>
	<br />

</div>