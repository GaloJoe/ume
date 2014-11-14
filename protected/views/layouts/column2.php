<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>

<?php // if ( (Yii::app()->user->isMaster() || Yii::app()->user->isAdmin()) && $this->uniqueid != 'historico' && !($this->uniqueid == 'apartamento' && ($this->action->Id == 'rel' || $this->action->Id == 'detail')) ) { ?>
<?php
if ((1 == 1 || $this->uniqueid == 'usuario' || $this->uniqueid == 'imobiliaria') &&
        (Yii::app()->user->isMaster() || Yii::app()->user->isAdmin()) && $this->uniqueid != 'historico' &&
        !($this->uniqueid == 'apartamento' && ($this->action->Id == 'rel' || $this->action->Id == 'detail')) ||
        ((Yii::app()->user->isMaster() || Yii::app()->user->isAdmin()) &
                   ($this->action->Id == 'rel' || $this->action->Id == 'listAvailable' || $this->action->Id == 'listSold' || 
                        $this->action->Id == 'listExchanged' || $this->action->Id == 'listHiring' || $this->action->Id == 'listReserved' || 
                        $this->uniqueid == 'categoria' || $this->uniqueid == 'material' || $this->uniqueid == 'movimentacao') ) ||
        ((Yii::app()->user->isMaster() || Yii::app()->user->isEngenheiro()) && $this->uniqueid == 'atividade')
) {
    ?>

    <div id="topmenu">
        <?php
        $this->widget('zii.widgets.CMenu', array(
            'items' => $this->menu,
        ));
        ?>
    </div>

    <div id="content">
        <?php echo $content; ?>
    </div><!-- content -->


    <!--    <div class="span-5 last">
            <div id="sidebar">-->

    <!--        </div> sidebar 
        </div>-->
<?php } else { ?>
    <div style="width: 100%;">
        <div id="content">
            <?php echo $content; ?>
        </div><!-- content -->
    </div>
<?php } ?>
<?php $this->endContent(); ?>