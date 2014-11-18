<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="pt_br" />

        <!-- blueprint CSS framework -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
        <!--[if lt IE 8]>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
        <![endif]-->

        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

        <title><?php echo CHtml::encode($this->pageTitle); ?></title>

    </head>

    <body>

        <div class="container" id="page">

            <div id="header">
                <div id="logo"><?php echo CHtml::image('images/logo/dall.jpg', 'Implantação', array('width' => 271, 'height' => 110)); ?></div>
            </div><!-- header -->

            <?php if((!($this->uniqueid == 'recibo' && ($this->action->Id == 'view' || $this->action->Id == 'generateRecibo'))) &&
                    (!($this->uniqueid == 'retencao' && $this->action->Id == 'generateRecibo')) &&
                    ($this->action->Id != 'select')) { ?>
                <div id="mainmenu">
                    <?php
                    $this->widget('zii.widgets.CMenu', array(
                        'items' => array(
                            array('label' => Yii::t('app', 'Home'), 'url' => array('/site/index')),
                            array('label' => Yii::t('app', 'Imobiliarias'), 'url' => array('/imobiliaria/index'), 'visible' => Yii::app()->user->isMaster() || Yii::app()->user->isAdmin()),
                            array('label' => Yii::t('app', 'Empreendimentos'), 'url' => array('/empreendimento/view'), 'visible' => !Yii::app()->user->isGuest && !Yii::app()->user->isAlmoxarife() && !Yii::app()->user->isEngenheiro() && !Yii::app()->user->isEmpreiteiro()),
                            array('label' => Yii::t('app', 'Usuários'), 'url' => array('/usuario/admin'), 'visible' => Yii::app()->user->isMaster() || Yii::app()->user->isAdmin()),
                            array('label' => Yii::t('app', 'Empreiteiros'), 'url' => array('/usuario/admin'), 'visible' => Yii::app()->user->isEngenheiro()),
                            array('label' => Yii::t('app', 'Relatórios'), 'url' => array('/apartamento/rel'), 'visible' => Yii::app()->user->isMaster() || Yii::app()->user->isAdmin()),
                            array('label' => Yii::t('app', 'Histórico'), 'url' => array('/historico/admin'), 'visible' => !Yii::app()->user->isGuest && !Yii::app()->user->isAlmoxarife() && !Yii::app()->user->isEngenheiro() && !Yii::app()->user->isEmpreiteiro()),
                            array('label' => Yii::t('app', 'Material'), 'url' => array('/categoria/admin'), 'visible' => Yii::app()->user->isMaster() || Yii::app()->user->isAlmoxarife() || Yii::app()->user->isEngenheiro()),
    //                        array('label' => Yii::t('app', 'Unidade Medida'), 'url' => array('/unidadeMedida/admin'), 'visible' => Yii::app()->user->isMaster() || Yii::app()->user->isAlmoxarife()),
                            array('label' => Yii::t('app', 'Medição'), 'url' => array('/atividade/admin'), 'visible' => Yii::app()->user->isMaster() || Yii::app()->user->isEmpreiteiro() ||  Yii::app()->user->isEngenheiro()),
    //                        array('label' => Yii::t('app', 'Contratos'), 'url' => array('/usuario/searchContracts'), 'visible' => Yii::app()->user->isMaster()),
    //                        array('label' => Yii::t('app', 'Perfil'), 'url' => array('/usuario/view&id=' . Yii::app()->user->id), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => Yii::t('app', 'Login'), 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest),
                            array('label' => Yii::t('app', 'Logout') . ' (' . Yii::app()->user->name . ')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest),
                        ),
                    ));
                    ?>
                </div><!-- mainmenu -->
            <?php } else if((!($this->uniqueid == 'recibo' && ($this->action->Id == 'view' || $this->action->Id == 'generateRecibo'))) &&
                    (!($this->uniqueid == 'retencao' && $this->action->Id == 'generateRecibo'))) {?>
                <div id="mainmenu">
                    <?php
                    $this->widget('zii.widgets.CMenu', array(
                        'items' => array(
                            array('label' => Yii::t('app', 'Logout') . ' (' . Yii::app()->user->name . ')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest),
                        ),
                    ));
                    ?>
                </div><!-- mainmenu -->
            <?php } ?>

            <?php echo $content; ?>

            <div class="clear"></div>

            <?php if((!($this->uniqueid == 'recibo' && ($this->action->Id == 'view' || $this->action->Id == 'generateRecibo'))) &&
                    (!($this->uniqueid == 'retencao' && $this->action->Id == 'generateRecibo'))) { ?>
                <div id="footer">
                    Copyright &copy; <?php echo date('Y'); ?> by Dall Construções.<br/>
                    All Rights Reserved.<br/>
                </div><!-- footer -->
            <?php } else { ?>
                <div id="footer">
                    Dall Construções<br/>
                </div><!-- footer -->
            <?php } ?>

        </div><!-- page -->

    </body>
</html>