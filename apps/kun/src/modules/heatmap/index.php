<?php

/**
 * 归档 - 热力图
 *
 * @package custom
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
?>

<!-- inject:css -->

<link rel="stylesheet" href="<?php $this->options->themeUrl('assets/heatmap/cal-heatmap.css'); ?>" />

<div class="pt-10 mx-auto <?php $this->options->viewWidth() ?>">
    <div id="cal-heatmap" class="flex-grow flex justify-center"></div>
    <div class="text-center pt-4">
        <button id="prev-month" type="button" class="items-center justify-center text-gray-500 w-10 h-10 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5 mr-1">
            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1.5em" width="1.5em" xmlns="http://www.w3.org/2000/svg">
                <path fill="none" d="M0 0h24v24H0z"></path>
                <path d="M15.41 7.41 14 6l-6 6 6 6 1.41-1.41L10.83 12z"></path>
            </svg>
        </button>
        <button id="next-month" type="button" class="items-center justify-center text-gray-500 w-10 h-10 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5">
            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1.5em" width="1.5em" xmlns="http://www.w3.org/2000/svg">
                <path fill="none" d="M0 0h24v24H0z"></path>
                <path d="M10 6 8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"></path>
            </svg>
        </button>
    </div>
    <!-- 文章列表 -->
    <h4 id="title" class="text-center mt-8">归档 <span></span></h4>
    <div id="articles" class="px-4 pt-8"></div>
</div>

<script type="text/javascript" src="<?php $this->options->themeUrl('assets/heatmap/popperjs.min.js'); ?>"></script>
<script type="text/javascript" src="<?php $this->options->themeUrl('assets/heatmap/tooltip.min.js'); ?>"></script>
<script type="text/javascript" src="<?php $this->options->themeUrl('assets/heatmap/d3.v7.min.js'); ?>"></script>
<script type="text/javascript" src="<?php $this->options->themeUrl('assets/heatmap/cal-heatmap.min.js'); ?>"></script>

<script>
    const cal = new CalHeatmap();
    const data = <?php echo getPostData(); ?>;
    const date_key_ts = data.map(i => ({
        ...i,
        date: new Date(i.date).getTime()
    }))

    const computeLayout = (startMonth, selector) => {
        const clientWidth = document.querySelector(selector).clientWidth
        // 格子的宽高
        const cellsize = 12
        // 单月每行最多6个格子
        const monthMaxCellNum = 6
        // 格子间距
        const gutter = 2;
        const monthsize = monthMaxCellNum * cellsize + (monthMaxCellNum - 1) * gutter
        const range = Math.floor(clientWidth / monthsize)
        const start = new Date(new Date().setMonth(startMonth - range + 1)).toISOString().slice(0, 7) + '-01';
        return {
            range,
            start,
            cellsize,
            gutter
        }
    }

    const renderArticles = (item) => {
        if (item) {
            document.querySelector("#title span").textContent = new Date(item.date).toISOString().split('T')[0]
            const articles = document.querySelector("#articles")
            articles.innerHTML = ''
            item.posts.forEach(post => {
                const div = document.createElement('div')
                div.classList.add('mb-4', "hvr-shrink")
                div.innerHTML = `<a href="${post.link}" class="block tracking-wider w-full post-content bg-gray-100 dark:bg-zinc-800 cursor-pointer p-4 rounded-tl-lg rounded-tr-2xl rounded-br-2xl rounded-bl-2xl" itemprop="articleBody"><p class="break-all text-sm">${post.title}</p></a>`
                articles.append(div)
            })
        }
    }

    const renderHeatMap = ({
        startMonth,
        selector
    }) => {
        cal.destroy()
        const {
            range,
            start,
            cellsize,
            gutter
        } = computeLayout(startMonth, selector)
        cal.paint({
            itemSelector: selector,
            domain: {
                type: 'month',
                gutter: gutter,
                label: {
                    text: 'YYYY-MM',
                    textAlign: 'start',
                    position: 'top'
                },
            },
            subDomain: {
                type: 'day', // ghDay
                radius: 2,
                width: cellsize,
                height: cellsize,
                gutter: gutter
            },
            data: {
                source: data,
                x: 'date',
                y: 'postNum',
                groupY: 'max',
            },
            range: range,
            date: {
                start,
                highlight: [new Date()]
            },
            scale: {
                color: {
                    type: 'threshold',
                    range: ['#C3DDFD', '#A4CAFE', '#76A9FA', '#3F83F8', '#1C64F2', '#1A56DB', '#1E429F', '#233876'],
                    domain: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                },
            },
            theme: "<?php $this->options->themeMode(); ?>",
        }, [
            [
                Tooltip,
                {
                    text: (date, value, dayjsDate) => `${value ?? '0'} 篇文章 于 ${dayjsDate.format('dddd, MMMM D, YYYY')}`
                },
            ],
        ])
        cal.on('click', (event, timestamp, value) => {
            const item = date_key_ts.find(i => i.date === timestamp)
            renderArticles(item)
        });
        document.querySelector("#prev-month").addEventListener('click', () => cal.previous(range))
        document.querySelector("#next-month").addEventListener('click', () => cal.next(range))
        // 默认显示最新文章
        const newest = data.reduce((max, c) => c.date > max.date ? c : max, data[0]);
        renderArticles(newest)
    }

    window.onload = () => renderHeatMap({
        selector: '#cal-heatmap',
        startMonth: new Date().getMonth() + 1
    })
    window.onresize = () => renderHeatMap({
        selector: '#cal-heatmap',
        startMonth: new Date().getMonth() + 1
    })
</script>
<!-- inject:js -->