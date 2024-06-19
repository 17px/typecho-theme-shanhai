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

<link rel="stylesheet" href="<?php $this->options->themeUrl('assets/heatmap/cal-heatmap.css'); ?>" />

<div class="pt-20 mx-auto <?php $this->options->viewWidth() ?>">

    <div id="cal-heatmap" class="bg-transparent"></div>

    <article class="markdown-body"><?php $this->content() ?></article>
    <?php $this->need('comments.php'); ?>
</div>

<script type="text/javascript" src="<?php $this->options->themeUrl('assets/heatmap/popperjs.min.js'); ?>"></script>
<script type="text/javascript" src="<?php $this->options->themeUrl('assets/heatmap/tooltip.min.js'); ?>"></script>
<script type="text/javascript" src="<?php $this->options->themeUrl('assets/heatmap/d3.v7.min.js'); ?>"></script>
<script type="text/javascript" src="<?php $this->options->themeUrl('assets/heatmap/cal-heatmap.min.js'); ?>"></script>


<?php

// 获取数据库对象
$db = Typecho_Db::get();
$prefix = $db->getPrefix();

// 查询所有文章
$rows = $db->fetchAll($db->select()->from($prefix . 'contents')->where('type = ?', 'post'));

$data = [];
foreach ($rows as $row) {
    $timestamp = $row['created']; // 获取秒级 Unix 时间戳
    $day = date('Y-m-d', $timestamp); // 标准化到每天的日期字符串
    if (isset($data[$day])) {
        $data[$day] += 1;
    } else {
        $data[$day] = 1;
    }
}

// 将数据转换为期望的数组格式
$result = [];
foreach ($data as $date => $postNum) {
    $result[] = ['date' => $date, 'postNum' => $postNum];
}

// 将结果转换为 JSON 格式
$jsonData = json_encode($result);
?>


<script>
    const cal = new CalHeatmap();
    const data = <?php echo $jsonData; ?>;
    const parent = document.querySelector("#cal-heatmap")
    const gutter = 4;
    const maxDaysPerMonth = 31; // 假设每月最多 30 天
    const totalGutterWidth = gutter * (maxDaysPerMonth - 1); 
    const availableWidth = parent.clientWidth - totalGutterWidth;
    const cellSize = Math.floor(availableWidth / maxDaysPerMonth);

    console.log(parent.clientWidth)
    console.log('%capps/kun/src/modules/about/index.php:56 data', 'color: #007acc;', data);
    try {
        cal.paint({
            itemSelector: "#cal-heatmap",
            domain: {
                type: 'month',
                gutter: gutter,
                label: {
                    text: 'MMM',
                    textAlign: 'start',
                    position: 'top'
                },
            },
            subDomain: {
                type: 'ghDay',
                radius: 2,
                width: 11,
                height: 11,
                gutter: gutter
            },
            data: {
                source: data,
                x: 'date',
                y: d => +d['postNum'],
                groupY: 'max',
            },
            range: 10,
            date: {
                start: new Date('2024-01-01')
            },
            scale: {
                color: {
                    type: 'threshold',
                    range: ['#C3DDFD', '#A4CAFE', '#76A9FA', '#3F83F8', '#1C64F2', '#1A56DB', '#1E429F', '#233876'],
                    domain: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                },
            },
        }, [
            [
                Tooltip,
                {
                    text: function(date, value, dayjsDate) {
                        return (
                            (value ? value : 'No') +
                            ' 篇文章 于 ' +
                            dayjsDate.format('dddd, MMMM D, YYYY')
                        );
                    },
                },
            ],
        ]);
    } catch (error) {
        console.error("Initialization failed:", error);
    }
</script>
<!-- inject:js -->