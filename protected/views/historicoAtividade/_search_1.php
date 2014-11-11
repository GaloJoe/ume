<div class="wide form">

    <?php
    $form = $this->beginWidget('GxActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>

    <div class="row">
        <?php echo $form->label($model, 'empreiteiro'); ?>
        <?php
        $condition = 'perfil = ' . '"empreiteiro"';
        ?>
        <?php echo $form->dropDownList($model, 'empreiteiro', GxHtml::listDataEx(Usuario::model()->findAllAttributes(null, true, $condition)), array('empty' => 'Selecionar Empreiteiro')); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'data_inicial'); ?>
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name' => 'data_inicial',
            'language' => 'pt-BR',
            // additional javascript options for the date picker plugin
            'options' => array(
                'dateFormat' => 'dd/mm/yy',
                'showAnim' => 'fold',
            ),
            'htmlOptions' => array(
                'style' => 'height:20px;'
            ),
        ));
        ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'data_final'); ?>
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name' => 'data_final',
            'language' => 'pt-BR',
            // additional javascript options for the date picker plugin
            'options' => array(
                'dateFormat' => 'dd/mm/yy',
                'showAnim' => 'fold',
            ),
            'htmlOptions' => array(
                'style' => 'height:20px;'
            ),
        ));
        ?>
    </div>

    <div class="row buttons">
        <?php echo GxHtml::submitButton(Yii::t('app', 'Search')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->
