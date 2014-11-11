<div class="form">


    <?php
    $form = $this->beginWidget('GxActiveForm', array(
        'id' => 'empreendimento-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
    ));
    ?>

    <p class="note">
        <?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
    </p>

    <?php echo $form->errorSummary($model); ?>

     <?php echo $form->labelEx($model, 'logo'); ?>
       <?php $this->widget('CMultiFileUpload', array(
               'name' => 'images',
               'accept' => 'jpeg|jpg|gif|png', // useful for verifying files
               'duplicate' => 'Duplicate file!', // useful, i think
               'denied' => 'Invalid file type', // useful, i think
               'max'=>1, // max 10 files
           )); ?>
       <?php echo CHtml::form('','post',array('enctype'=>'multipart/form-data')); ?>
       <?php echo $form->error($model, 'logo'); ?>
   <div class="row">
       <?php echo $form->labelEx($model, 'implantacao'); ?>
       <?php $this->widget('CMultiFileUpload', array(
               'name' => 'implantacaos',
               'accept' => 'jpeg|jpg|gif|png', // useful for verifying files
               'duplicate' => 'Duplicate file!', // useful, i think
               'denied' => 'Invalid file type', // useful, i think
               'max'=>1, // max 10 files
           )); ?>
       <?php echo CHtml::form('','post',array('enctype'=>'multipart/form-data')); ?>
       <?php echo $form->error($model, 'implantacao'); ?>
   </div><!-- row -->
   <div class="row">
       <?php echo $form->labelEx($model, 'implantacao_full'); ?>
       <?php $this->widget('CMultiFileUpload', array(
               'name' => 'implantacaofulls',
               'accept' => 'jpeg|jpg|gif|png', // useful for verifying files
               'duplicate' => 'Duplicate file!', // useful, i think
               'denied' => 'Invalid file type', // useful, i think
               'max'=>1, // max 10 files
           )); ?>
       <?php echo CHtml::form('','post',array('enctype'=>'multipart/form-data')); ?>
       <?php echo $form->error($model, 'implantacao_full'); ?>
   </div><!-- row -->
    <div class="row">
        <?php echo $form->labelEx($model, 'dias_reserva'); ?>
        <?php echo $form->textField($model, 'dias_reserva'); ?>
        <?php echo $form->error($model, 'dias_reserva'); ?>
    </div><!-- row -->
    <div class="row">
        <?php echo $form->labelEx($model, 'andares'); ?>
        <?php echo $form->textField($model, 'andares'); ?>
        <?php echo $form->error($model, 'andares'); ?>
    </div><!-- row -->
    <div class="row">
        <?php echo $form->labelEx($model, 'nome'); ?>
        <?php echo $form->textField($model, 'nome', array('maxlength' => 60)); ?>
        <?php echo $form->error($model, 'nome'); ?>
    </div><!-- row -->

    <?php
    echo GxHtml::submitButton(Yii::t('app', 'Save'));
    $this->endWidget();
    ?>
</div><!-- form -->