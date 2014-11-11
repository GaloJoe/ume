

<?php echo $form->labelEx($model, 'Blocos'); ?>
<?php echo $form->checkBoxList($model, 'referencia', $blocos); ?>
<?php echo $form->error($model, 'referencia'); ?>