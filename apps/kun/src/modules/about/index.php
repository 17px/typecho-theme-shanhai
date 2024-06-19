<?php

/**
 * 留言
 *
 * @package custom
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
?>

<!-- inject:css -->

<link rel="stylesheet" href="//cdn.jsdelivr.net/cal-heatmap/3.3.10/cal-heatmap.css" />

<div class="pt-20 mx-auto <?php $this->options->viewWidth() ?>">
        
    <div id="cal-heatmap" class="graph-container bg-transparent"></div>
    <article class="markdown-body"><?php $this->content() ?></article>
    <?php $this->need('comments.php'); ?>
</div>

<script type="text/javascript" src="//d3js.org/d3.v3.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/cal-heatmap/3.3.10/cal-heatmap.min.js"></script>
<script>
    var datas = {};
    var start = new Date("2017-1-1".replace(/-/g, "/"));
    var end = new Date("2017-12-31".replace(/-/g, "/"));
    do {
        var value = Math.floor(Math.random() * 30);
        var startYML = start.getFullYear() + "-" + (start.getMonth() + 1) + "-" + start.getDate()
        var timeStamp = (Date.parse(startYML)) / 1000;
        datas[timeStamp] = value;
        start.setDate(start.getDate() + 1);
    } while (end >= start);
    console.log(datas)
    var cal = new CalHeatMap();
    cal.init({
        //from 2017,0,1
        start: new Date(2017, 0, 1),
        data: datas,
        domain: "month",
        subDomain: "day",
        // subDomain: "x_day",
        range: 12,
        tooltip: true,
        cellsize: 15,
        cellpadding: 3,
        domainGutter: 15,
        cellSize: 10,
        // displayLegend: false
    });
</script>
<!-- inject:js -->