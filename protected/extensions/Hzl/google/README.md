--------------------------------------
-- Scott Huang's first widget 
-- Learn from Yiiwheels  
-- Dec 31, 2013  ;  Xiamen, China
-- Zhiliang.Huang@gmail.com
--------------------------------------

Examples:
<div class="row"> 
    <div class="span6" >  
        <?php
//very useful google chart
        $this->widget('ext.Hzl.google.HzlVisualizationChart', array('visualization' => 'PieChart',
            'data' => array(
                array('Task', 'Hours per Day'),
                array('Work', 11),
                array('Eat', 2),
                array('Commute', 2),
                array('Watch TV', 2),
                array('Sleep', 7)
            ),
            'options' => array('title' => 'My Daily Activity')));
        
        $this->widget('ext.Hzl.google.HzlVisualizationChart', array('visualization' => 'LineChart',
            'data' => array(
                array('Task', 'Hours per Day'),
                array('Work', 11),
                array('Eat', 2),
                array('Commute', 2),
                array('Watch TV', 2),
                array('Sleep', 7)
            ),
            'options' => array('title' => 'My Daily Activity')));
        ?>

    </div>
</div>

<div class="row"> 
    <div class="span6" >  
<?php
$this->widget('ext.Hzl.google.HzlVisualizationChart', 
        array('visualization' => 'Gauge','packages'=>'gauge',
    'data' => array(
        array('Label', 'Value'),
        array('Memory', 80),
        array('CPU', 55),
        array('Network', 68),
    ),
    'options' => array(
        'width' => 400,
        'height' => 120,
        'redFrom' => 90,
        'redTo' => 100,
        'yellowFrom' => 75,
        'yellowTo' => 90,
        'minorTicks' => 5
    )
));
?>
    </div>
</div>


