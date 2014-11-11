<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<h1>Bem-vindo ao sistema Dall Construções</h1>

<?php 
if(!Yii::app()->user->isGuest) {
    echo '<p>Utilize uma das opções no menu acima.</p>';
} else {
    echo '<p>Efetue login no sistema para utilizá-lo.</p>';
}
?>
<!--<p>You may change the content of this page by modifying the following two files:</p>-->
<ul>
	<!--<li>View file: <code><?php // echo __FILE__; ?></code></li>-->
	<!--<li>Layout file: <code><?php // echo $this->getLayoutFile('main'); ?></code></li>-->
</ul>