<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

function themeConfig($form)
{
    $moreConfig = new \Typecho\Widget\Helper\Form\Element\Checkbox(
        'moreConfig',
        [
            'ShowFastBar' => _t('显示文章快捷操作栏'),
            'ShowCommentEmoji' => _t('启用评论emoji表情'),
            'ShowICP' => _t('显示ICP备案号'),
            'UseKatex' => _t('文章中启用Katex公式'),
        ],
        ['ShowFastBar', 'ShowCommentEmoji', 'UseKatex'],
        _t('主题基本的配置')
    );


    $logoUrl = new \Typecho\Widget\Helper\Form\Element\Text(
        'logoUrl',
        null,
        null,
        _t('站点 LOGO 地址'),
        _t('在这里填入一个图片 URL 地址, 以在网站标题前加上一个 LOGO')
    );

    $icp = new \Typecho\Widget\Helper\Form\Element\Text(
        'icp',
        null,
        null,
        _t('icp备案号'),
        _t('请遵守法定法规')
    );

    $themeMode = new \Typecho\Widget\Helper\Form\Element\Select(
        'themeMode',
        array(
            'light' => '白天模式',
            'dark' => '黑夜模式',
        ),
        'light',
        '全局主题色模式'
    );

    $viewWidth = new \Typecho\Widget\Helper\Form\Element\Select(
        'viewWidth',
        array(
            'max-w-xl' => '576px',
            'max-w-screen-sm' => '640px',
            'max-w-screen-md' => '768px',
            'max-w-screen-lg' => "1024px"
        ),
        'max-w-screen-sm',
        '中间核心视觉区域尺寸'
    );

    $prismTheme = new \Typecho\Widget\Helper\Form\Element\Select(
        'prismTheme',
        array(
            'atom-dark' => 'atom-dark',
            'default' => 'default',
            'tomorrow' => "tomorrow",
            'one-light' => 'one-light'
        ),
        'atom-dark',
        'prism代码高亮主题'
    );

    $markdownTheme = new \Typecho\Widget\Helper\Form\Element\Select(
        'markdownTheme',
        array(
            'github-markdown-light' => 'github-markdown-light',
            'github-markdown-dark' => 'github-markdown-dark',
        ),
        'github-markdown-light',
        'markdown主题'
    );

    $mottoSelect = new \Typecho\Widget\Helper\Form\Element\Select(
        'mottoSelect',
        array(
            'shici' => '今日诗词',
            'description' => '个人资料',
        ),
        'shici',
        '首页Banner区域',
        '推荐 "今日诗词"，根据时间、地点、天气、事件智能推荐'
    );

    $fontFamily = new \Typecho\Widget\Helper\Form\Element\Select(
        'fontFamily',
        array(
            'base' => '默认字体',
            'LXGW WenKai' => '落霞孤鹜(文楷)',
        ),
        'base',
        '全局字体',
        '字体方案：<a href="https://chinese-fonts-cdn.deno.dev">中文网字计划</a>，先进的工程化确保极快的加载速度'
    );

    $form->addInput($moreConfig->multiMode());
    $form->addInput($logoUrl);
    $form->addInput($icp);
    $form->addInput($fontFamily);
    $form->addInput($themeMode);
    $form->addInput($viewWidth);
    $form->addInput($prismTheme);
    $form->addInput($markdownTheme);
    $form->addInput($mottoSelect);
}

function analyzePostContent($content)
{
    // 包含图片
    if (strpos($content, '<img') !== false) {
        preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $matches);
        return '<img class="w-[20px] h-[20px] inline-block rounded" src="' . $matches[1][0] . '" />';
    }
    // 包含代码
    if (strpos($content, '<code') !== false || strpos($content, '<pre') !== false) {
        return '<svg height="1.5em" width="1.5em" class="inline-block" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24"  xmlns="http://www.w3.org/2000/svg"><path fill="none" d="M0 0h24v24H0V0z"></path><path d="M9.4 16.6 4.8 12l4.6-4.6L8 6l-6 6 6 6 1.4-1.4zm5.2 0 4.6-4.6-4.6-4.6L16 6l6 6-6 6-1.4-1.4z"></path></svg>';
    }

    return '<svg height="1.5em" width="1.5em" class="inline-block" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path fill="none" d="M0 0h24v24H0z"></path><path d="M2.5 4v3h5v12h3V7h5V4h-13zm19 5h-9v3h3v7h3v-7h3V9z"></path></svg>';
}



/**
 * 获取博主gravatar头像
 */
function getGravatar($email, $size = 80, $default = 'identicon', $rating = 'g')
{
    $url = 'https://www.gravatar.com/avatar/';
    $url .= md5(strtolower(trim($email)));
    $url .= "?s=$size&d=$default&r=$rating";
    return $url;
}


function get_word_count($text)
{
    $text = strip_tags($text); // 去掉 HTML 标签
    $word_count = str_word_count($text); // 计算单词数
    return $word_count;
}

function get_reading_time($text)
{
    $word_count = get_word_count($text);
    $words_per_minute = 200; // 平均每分钟阅读 200 个单词
    $reading_time = ceil($word_count / $words_per_minute); // 计算阅读时间并向上取整
    return $reading_time . ' min read';
}

function getCommentDetails($parentId)
{
    $db = Typecho_Db::get();
    // 选择作者和文本内容
    $query = $db->select('author')->from('table.comments')->where('coid = ?', $parentId);
    $result = $db->fetchRow($query);
    return $result ? $result['author'] : '';
}

/**
 * 获取前一篇文章
 */
function getAdjacentArticle($widget, $direction = 'prev', $default = ['url' => 'javascript:void(0);', 'title' => '没有了'])
{
    $db = Typecho_Db::get();
    $operator = $direction === 'prev' ? '<' : '>';
    $order = $direction === 'prev' ? Typecho_Db::SORT_DESC : Typecho_Db::SORT_ASC;

    $sql = $db->select()->from('table.contents')
        ->where('table.contents.created ' . $operator . '?', $widget->created)
        ->where('table.contents.status = ?', 'publish')
        ->where('table.contents.type = ?', $widget->type)
        ->order('table.contents.created', $order)
        ->limit(1);

    $content = $db->fetchRow($sql);

    if ($content) {
        $content = $widget->filter($content);
        return [
            'url' => !empty($content['permalink']) ? $content['permalink'] : $default['url'],
            'title' => !empty($content['title']) ? $content['title'] : $default['title']
        ];
    }

    return $default;  // 如果没有相邻文章，则返回默认值
}




/**
 * 文章阅读次数
 */
function get_post_view($archive)
{
    $cid = $archive->cid;
    $db = Typecho_Db::get();
    $prefix = $db->getPrefix();

    // 检查并添加 'views' 字段
    if (!array_key_exists('views', $db->fetchRow($db->select()->from('table.contents')))) {
        $db->query('ALTER TABLE `' . $prefix . 'contents` ADD `views` INT(10) DEFAULT 0;');
        echo format_views(0);
        return;
    }

    // 获取阅读次数
    $row = $db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $cid));

    // 更新阅读次数
    if ($archive->is('single')) {
        $views = Typecho_Cookie::get('extend_contents_views');
        if (empty($views)) {
            $views = array();
        } else {
            $views = explode(',', $views);
        }
        if (!in_array($cid, $views)) {
            $db->query($db->update('table.contents')->rows(array('views' => (int) $row['views'] + 1))->where('cid = ?', $cid));
            array_push($views, $cid);
            $views = implode(',', $views);
            Typecho_Cookie::set('extend_contents_views', $views); //记录查看cookie
        }
    }

    echo format_views($row['views']);
}

/**
 *  辅助函数：将数字格式化为带 "k" 的格式
 */
function format_views($views)
{
    if ($views >= 1000) {
        return round($views / 1000, 1) . 'k';
    }
    return $views;
}


/**
 * 用户os
 */
function getPlatformKey()
{
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    if (stripos($userAgent, 'Macintosh') !== false || stripos($userAgent, 'Mac OS') !== false) {
        return '⌘';
    } else {
        return 'ctrl';
    }
}

function getFontCdn($key)
{
    $cdnMap = array(
        'LXGW WenKai' => 'https://chinese-fonts-cdn.deno.dev/chinesefonts3/packages/lxgwwenkai/dist/LXGWWenKai-Bold/result.css',
    );
    return array_key_exists($key, $cdnMap) ?  $cdnMap[$key] : null;
}


/**
 * 获取所有文章的数据，包括日期、文章数量、文章标题和链接，并返回 JSON 格式的数据
 *
 * @return string JSON 格式的数据
 */
function getPostData()
{
    // 获取数据库对象
    $db = Typecho_Db::get();
    $prefix = $db->getPrefix();
    $options = Helper::options(); // 获取Typecho的设置选项

    // 查询所有文章
    $rows = $db->fetchAll($db->select()->from($prefix . 'contents')->where('type = ?', 'post'));

    $data = [];
    foreach ($rows as $row) {
        $timestamp = $row['created']; // 获取秒级 Unix 时间戳
        $day = date('Y-m-d', $timestamp); // 标准化到每天的日期字符串

        // 获取文章标题和链接
        $title = $row['title'];
        $slug = $row['slug'];
        $cid = $row['cid'];
        $permalink = Typecho_Router::url('post', array('cid' => $cid), $options->index);

        if (isset($data[$day])) {
            $data[$day]['postNum'] += 1;
            $data[$day]['posts'][] = ['title' => $title, 'link' => $permalink];
        } else {
            $data[$day] = [
                'postNum' => 1,
                'posts' => [['title' => $title, 'link' => $permalink]]
            ];
        }
    }

    // 将数据转换为期望的数组格式
    $result = [];
    foreach ($data as $date => $info) {
        $result[] = [
            'date' => $date,
            'postNum' => $info['postNum'],
            'posts' => $info['posts']
        ];
    }

    // 将结果转换为 JSON 格式
    return json_encode($result);
}

function getAllTags()
{
    $db = Typecho_Db::get(); // 获取数据库对象
    $options = Helper::options(); // 获取Typecho的设置选项
    $prefix = $db->getPrefix();

    // 查询所有标签
    $sql = $db->select()->from($prefix . 'metas')
        ->where('type = ?', 'tag')
        ->order($prefix . 'metas.order', Typecho_Db::SORT_ASC);
    $tags = $db->fetchAll($sql);

    $result = [];
    foreach ($tags as $tag) {
        $result[] = [
            'name' => $tag['name'],
            'link' => Typecho_Router::url('tag', ['slug' => $tag['slug']], $options->index) // 构建正确的标签链接
        ];
    }

    return $result;
}


// 定义函数，用于获取RSS内容并返回JSON对象
function fetchRssFeeds($rssUrls)
{
    // 初始化返回结果数组
    $result = [];

    // 遍历每个RSS URL
    foreach ($rssUrls as $url) {
        // 使用 cURL 获取RSS内容
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        $rssContent = curl_exec($ch);
        $curlError = curl_error($ch);
        curl_close($ch);

        // 检查是否有错误
        if ($rssContent === false) {
            $result[$url] = ['error' => $curlError];
            continue;
        }

        // 解析RSS内容
        $rss = simplexml_load_string($rssContent);
        if ($rss === false) {
            $errors = libxml_get_errors();
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->message;
            }
            $result[$url] = ['error' => $errorMessages];
            libxml_clear_errors();
            continue;
        }

        // 提取channel信息
        $channel = [
            'title' => (string)$rss->channel->title,
            'link' => (string)$rss->channel->link,
            'description' => (string)$rss->channel->description,
            'language' => (string)$rss->channel->language,
            'lastBuildDate' => strtotime((string)$rss->channel->lastBuildDate),
            'pubDate' => strtotime((string)$rss->channel->pubDate),
        ];

        // 提取RSS项
        $items = [];
        foreach ($rss->channel->item as $item) {
            $namespaces = $item->getNamespaces(true);
            $content = $item->children($namespaces['content']);
            $encodedContent = (string)$content->encoded;

            $items[] = [
                'title' => (string)$item->title,
                'link' => (string)$item->link,
                'description' => mb_substr(strip_tags($encodedContent), 0, 150) . '...',
                'pubDate' => strtotime((string)$item->pubDate),
            ];
        }

        // 添加到结果数组
        $result[$url] = [
            'channel' => $channel,
            'items' => $items,
        ];
    }

    // 返回JSON对象
    return json_encode($result);
}


function modifyLinks($html)
{
    // 图标映射数组
    $iconMap = [
        "unknown" =>
        '<svg class="w-5 h-5 flex-shrink-0" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5z"></path></svg>',
        "gif" => '<svg class="w-5 h-5 flex-shrink-0" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2H9v-1h3a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM3.278 13.124a1.4 1.4 0 0 0-.14-.492 1.3 1.3 0 0 0-.314-.407 1.5 1.5 0 0 0-.48-.275 1.9 1.9 0 0 0-.636-.1q-.542 0-.926.229a1.5 1.5 0 0 0-.583.632 2.1 2.1 0 0 0-.199.95v.506q0 .408.105.745.105.336.32.58.213.243.533.377.323.132.753.132.402 0 .697-.111a1.29 1.29 0 0 0 .788-.77q.097-.261.097-.551v-.797H1.717v.589h.823v.255q0 .199-.09.363a.67.67 0 0 1-.273.264 1 1 0 0 1-.457.096.87.87 0 0 1-.519-.146.9.9 0 0 1-.305-.413 1.8 1.8 0 0 1-.096-.615v-.499q0-.547.234-.85.237-.3.665-.301a1 1 0 0 1 .3.044q.136.044.236.126a.7.7 0 0 1 .17.19.8.8 0 0 1 .097.25zm1.353 2.801v-3.999H3.84v4h.79Zm1.493-1.59v1.59h-.791v-3.999H7.88v.653H6.124v1.117h1.605v.638z"></path></svg>',
        "jpeg" => '<svg class="w-5 h-5 flex-shrink-0" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zm-4.34 8.132q.114.23.14.492h-.776a.8.8 0 0 0-.097-.249.7.7 0 0 0-.17-.19.7.7 0 0 0-.237-.126 1 1 0 0 0-.299-.044q-.428 0-.665.302-.234.301-.234.85v.498q0 .351.097.615a.9.9 0 0 0 .304.413.87.87 0 0 0 .519.146 1 1 0 0 0 .457-.096.67.67 0 0 0 .272-.264q.09-.164.091-.363v-.255H8.24v-.59h1.576v.798q0 .29-.097.55a1.3 1.3 0 0 1-.293.458 1.4 1.4 0 0 1-.495.313q-.296.111-.697.111a2 2 0 0 1-.753-.132 1.45 1.45 0 0 1-.533-.377 1.6 1.6 0 0 1-.32-.58 2.5 2.5 0 0 1-.105-.745v-.506q0-.543.2-.95.201-.406.582-.633.384-.228.926-.228.357 0 .636.1.28.1.48.275t.314.407ZM0 14.786q0 .246.082.465.083.22.243.39.165.17.407.267.246.093.569.093.63 0 .984-.345.357-.346.358-1.005v-2.725h-.791v2.745q0 .303-.138.466t-.422.164a.5.5 0 0 1-.454-.246.6.6 0 0 1-.073-.27H0Zm4.92-2.86H3.322v4h.791v-1.343h.803q.43 0 .732-.172.305-.177.463-.475.162-.302.161-.677 0-.374-.158-.677a1.2 1.2 0 0 0-.46-.477q-.3-.18-.732-.179Zm.546 1.333a.8.8 0 0 1-.085.381.57.57 0 0 1-.238.24.8.8 0 0 1-.375.082H4.11v-1.406h.66q.327 0 .512.182.185.181.185.521Z"></path></svg>',
        "jpg" => '<svg class="w-5 h-5 flex-shrink-0" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zm-4.34 8.132q.114.23.14.492h-.776a.8.8 0 0 0-.097-.249.7.7 0 0 0-.17-.19.7.7 0 0 0-.237-.126 1 1 0 0 0-.299-.044q-.428 0-.665.302-.234.301-.234.85v.498q0 .351.097.615a.9.9 0 0 0 .304.413.87.87 0 0 0 .519.146 1 1 0 0 0 .457-.096.67.67 0 0 0 .272-.264q.09-.164.091-.363v-.255H8.24v-.59h1.576v.798q0 .29-.097.55a1.3 1.3 0 0 1-.293.458 1.4 1.4 0 0 1-.495.313q-.296.111-.697.111a2 2 0 0 1-.753-.132 1.45 1.45 0 0 1-.533-.377 1.6 1.6 0 0 1-.32-.58 2.5 2.5 0 0 1-.105-.745v-.506q0-.543.2-.95.201-.406.582-.633.384-.228.926-.228.357 0 .636.1.28.1.48.275t.314.407ZM0 14.786q0 .246.082.465.083.22.243.39.165.17.407.267.246.093.569.093.63 0 .984-.345.357-.346.358-1.005v-2.725h-.791v2.745q0 .303-.138.466t-.422.164a.5.5 0 0 1-.454-.246.6.6 0 0 1-.073-.27H0Zm4.92-2.86H3.322v4h.791v-1.343h.803q.43 0 .732-.172.305-.177.463-.475.162-.302.161-.677 0-.374-.158-.677a1.2 1.2 0 0 0-.46-.477q-.3-.18-.732-.179Zm.546 1.333a.8.8 0 0 1-.085.381.57.57 0 0 1-.238.24.8.8 0 0 1-.375.082H4.11v-1.406h.66q.327 0 .512.182.185.181.185.521Z"></path></svg>',
        "tiff" => '<svg class="w-5 h-5 flex-shrink-0" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM1.928 12.512v3.337h-.794v-3.337H0v-.662h3.064v.662zm2.131-.662v3.999h-.79V11.85zm1.373 3.999v-1.59h1.606v-.64H5.432v-1.116H7.19v-.653H4.641v3.999zm2.868-1.59v1.59h-.791V11.85h2.548v.653H8.3v1.117h1.605v.638z"></path></svg>',
        "svg" => '<svg class="w-5 h-5 flex-shrink-0" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2v-1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM0 14.841a1.13 1.13 0 0 0 .401.823q.194.162.478.252.285.091.665.091.507 0 .858-.158.355-.158.54-.44a1.17 1.17 0 0 0 .187-.656q0-.336-.135-.56a1 1 0 0 0-.375-.357 2 2 0 0 0-.565-.21l-.621-.144a1 1 0 0 1-.405-.176.37.37 0 0 1-.143-.299q0-.234.184-.384.187-.152.513-.152.214 0 .37.068a.6.6 0 0 1 .245.181.56.56 0 0 1 .12.258h.75a1.1 1.1 0 0 0-.199-.566 1.2 1.2 0 0 0-.5-.41 1.8 1.8 0 0 0-.78-.152q-.44 0-.776.15-.337.149-.528.421-.19.273-.19.639 0 .302.123.524t.351.367q.229.143.54.213l.618.144q.31.073.462.193a.39.39 0 0 1 .153.326.5.5 0 0 1-.085.29.56.56 0 0 1-.256.193q-.167.07-.413.07-.176 0-.32-.04a.8.8 0 0 1-.248-.115.58.58 0 0 1-.255-.384zm4.575 1.09h.952l1.327-3.999h-.879l-.887 3.138H5.05l-.897-3.138h-.917zm5.483-3.293q.114.228.14.492h-.776a.8.8 0 0 0-.096-.249.7.7 0 0 0-.17-.19.7.7 0 0 0-.237-.126 1 1 0 0 0-.3-.044q-.427 0-.664.302-.235.3-.235.85v.497q0 .352.097.616a.9.9 0 0 0 .305.413.87.87 0 0 0 .518.146 1 1 0 0 0 .457-.097.67.67 0 0 0 .273-.263q.09-.164.09-.364v-.254h-.823v-.59h1.576v.798q0 .29-.096.55a1.3 1.3 0 0 1-.293.457 1.4 1.4 0 0 1-.495.314q-.296.111-.698.111a2 2 0 0 1-.752-.132 1.45 1.45 0 0 1-.534-.377 1.6 1.6 0 0 1-.319-.58 2.5 2.5 0 0 1-.105-.745v-.507q0-.54.199-.949.202-.406.583-.633.383-.228.926-.228.357 0 .635.1.282.1.48.275.2.176.314.407"></path></svg>',
        "bmp" => '<svg class="w-5 h-5 flex-shrink-0" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2v-1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM0 15.849h1.664q.408 0 .72-.132.315-.135.493-.386.18-.253.179-.61a1 1 0 0 0-.123-.51.85.85 0 0 0-.323-.325 1.1 1.1 0 0 0-.445-.14v-.036a1 1 0 0 0 .352-.16.8.8 0 0 0 .243-.294.9.9 0 0 0 .09-.422q0-.463-.322-.723-.322-.261-.858-.261H0zm.785-3.404h.7q.28 0 .431.14.155.138.155.384a.5.5 0 0 1-.082.296.5.5 0 0 1-.249.185 1.2 1.2 0 0 1-.433.064H.785zm0 1.62h.75q.231 0 .393.073a.5.5 0 0 1 .24.211.6.6 0 0 1 .082.325q0 .284-.205.434-.205.146-.671.146H.785zm3.474 1.784v-2.66h.038l.952 2.16h.515l.947-2.16h.038v2.66h.715V11.85h-.8l-1.14 2.596h-.026l-1.14-2.596h-.805v3.999zm3.918-3.999h1.6q.434 0 .732.179.302.176.46.477.159.302.159.677t-.162.677q-.158.299-.462.474a1.45 1.45 0 0 1-.733.173h-.803v1.342h-.79zm2.06 1.714a.8.8 0 0 0 .085-.381q0-.34-.185-.521-.185-.182-.512-.182h-.66v1.406h.66a.8.8 0 0 0 .375-.082.57.57 0 0 0 .237-.24"></path></svg>',
        "webp" => '<svg class="w-5 h-5 flex-shrink-0" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M8.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"></path><path d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2M3 2a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v8l-2.083-2.083a.5.5 0 0 0-.76.063L8 11 5.835 9.7a.5.5 0 0 0-.611.076L3 12z"></path></svg>',
        "avif" => '<svg class="w-5 h-5 flex-shrink-0" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M8.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"></path><path d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2M3 2a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v8l-2.083-2.083a.5.5 0 0 0-.76.063L8 11 5.835 9.7a.5.5 0 0 0-.611.076L3 12z"></path></svg>',
        "mp3" => '<svg class="w-5 h-5 flex-shrink-0" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2v-1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zm-4.911 9.67h-.443v-.609h.422a.7.7 0 0 0 .322-.073.56.56 0 0 0 .22-.2.5.5 0 0 0 .076-.284.49.49 0 0 0-.176-.392.65.65 0 0 0-.442-.15.7.7 0 0 0-.252.041.6.6 0 0 0-.193.112.5.5 0 0 0-.179.349H7.71q.009-.235.102-.437.094-.202.27-.352.176-.152.428-.237.255-.085.583-.088.418-.003.723.132.304.135.472.372a.9.9 0 0 1 .173.539.83.83 0 0 1-.12.478.96.96 0 0 1-.619.439v.041a1 1 0 0 1 .718.434.9.9 0 0 1 .144.521q.003.285-.117.507a1.1 1.1 0 0 1-.329.378q-.21.152-.486.234-.273.08-.583.08-.451 0-.77-.153a1.2 1.2 0 0 1-.487-.41 1.1 1.1 0 0 1-.178-.563h.726a.46.46 0 0 0 .106.258.7.7 0 0 0 .249.179 1 1 0 0 0 .357.067.9.9 0 0 0 .384-.076.6.6 0 0 0 .252-.217.56.56 0 0 0 .088-.319.56.56 0 0 0-.334-.522.8.8 0 0 0-.372-.079ZM.706 15.925v-2.66h.038l.952 2.16h.516l.946-2.16h.038v2.66h.715v-3.999h-.8l-1.14 2.596h-.026l-1.14-2.596H0v4zm5.458-3.999h-1.6v4h.792v-1.342h.803q.43 0 .732-.173.304-.177.463-.475a1.4 1.4 0 0 0 .161-.677q0-.374-.158-.677a1.2 1.2 0 0 0-.46-.477 1.4 1.4 0 0 0-.733-.179m.545 1.333a.8.8 0 0 1-.085.381.57.57 0 0 1-.237.24.8.8 0 0 1-.375.082h-.66v-1.406h.66q.328 0 .513.182.184.181.184.521"></path></svg>',
        "mp4" => '<svg class="w-5 h-5 flex-shrink-0" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2v-1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM.706 15.849v-2.66h.038l.952 2.16h.516l.946-2.16h.038v2.66h.715V11.85h-.8l-1.14 2.596h-.026L.805 11.85H0v3.999zm5.278-3.999h-1.6v3.999h.792v-1.342h.803q.43 0 .732-.173.304-.175.463-.474a1.4 1.4 0 0 0 .161-.677q0-.375-.158-.677a1.2 1.2 0 0 0-.46-.477 1.4 1.4 0 0 0-.733-.179m.545 1.333a.8.8 0 0 1-.085.38.57.57 0 0 1-.237.241.8.8 0 0 1-.375.082h-.66V12.48h.66q.329 0 .513.181.184.183.184.522m1.505-.032q.4-.65.791-1.301h1.14v2.62h.49v.638h-.49v.741h-.741v-.741H7.287v-.648q.353-.66.747-1.31Zm-.029 1.298v.02h1.219v-2.021h-.041q-.302.477-.607.984-.3.507-.571 1.017"></path></svg>',
        "mov" => '<svg class="w-5 h-5 flex-shrink-0" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2v-1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zm-6.914 9.166v.522q0 .384-.117.641a.86.86 0 0 1-.323.387.9.9 0 0 1-.468.126.9.9 0 0 1-.472-.126.87.87 0 0 1-.32-.386 1.55 1.55 0 0 1-.117-.642v-.522q0-.386.118-.641a.87.87 0 0 1 .319-.387.87.87 0 0 1 .472-.129q.263 0 .468.13a.86.86 0 0 1 .323.386q.117.255.117.641m.802.519v-.513q0-.565-.205-.972a1.46 1.46 0 0 0-.588-.63q-.381-.22-.917-.22-.534 0-.92.22a1.44 1.44 0 0 0-.59.627q-.204.406-.204.975v.513q0 .563.205.973.205.406.589.627.386.216.92.216.536 0 .917-.216.383-.22.588-.627.205-.41.205-.973m-7.182 1.74v-2.66h.038l.952 2.16h.516l.946-2.16h.038v2.66h.715v-3.999h-.8l-1.14 2.596h-.026l-1.14-2.596H0v4zm9.54 0h-.952l-1.34-3.999h.918l.896 3.138h.038l.888-3.138h.879z"></path></svg>',
        "wmv" => '<svg class="w-5 h-5 flex-shrink-0" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M6 6.883v4.234a.5.5 0 0 0 .757.429l3.528-2.117a.5.5 0 0 0 0-.858L6.757 6.454a.5.5 0 0 0-.757.43z"></path><path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"></path></svg>',
        "wma" => '<svg class="w-5 h-5 flex-shrink-0" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M6 6.883v4.234a.5.5 0 0 0 .757.429l3.528-2.117a.5.5 0 0 0 0-.858L6.757 6.454a.5.5 0 0 0-.757.43z"></path><path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"></path></svg>',
        "rmvb" => '<svg class="w-5 h-5 flex-shrink-0" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M6 6.883v4.234a.5.5 0 0 0 .757.429l3.528-2.117a.5.5 0 0 0 0-.858L6.757 6.454a.5.5 0 0 0-.757.43z"></path><path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"></path></svg>',
        "rm" => '<svg  class="w-5 h-5 flex-shrink-0" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M6 6.883v4.234a.5.5 0 0 0 .757.429l3.528-2.117a.5.5 0 0 0 0-.858L6.757 6.454a.5.5 0 0 0-.757.43z"></path><path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"></path></svg>',
        "avi" => '<svg class="w-5 h-5 flex-shrink-0" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M6 6.883v4.234a.5.5 0 0 0 .757.429l3.528-2.117a.5.5 0 0 0 0-.858L6.757 6.454a.5.5 0 0 0-.757.43z"></path><path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"></path></svg>',
        "flv" => '<svg class="w-5 h-5 flex-shrink-0" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M6 6.883v4.234a.5.5 0 0 0 .757.429l3.528-2.117a.5.5 0 0 0 0-.858L6.757 6.454a.5.5 0 0 0-.757.43z"></path><path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"></path></svg>',
        "ogg" => '<svg class="w-5 h-5 flex-shrink-0" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M6 6.883v4.234a.5.5 0 0 0 .757.429l3.528-2.117a.5.5 0 0 0 0-.858L6.757 6.454a.5.5 0 0 0-.757.43z"></path><path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"></path></svg>',
        "oga" => '<svg class="w-5 h-5 flex-shrink-0" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M6 6.883v4.234a.5.5 0 0 0 .757.429l3.528-2.117a.5.5 0 0 0 0-.858L6.757 6.454a.5.5 0 0 0-.757.43z"></path><path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"></path></svg>',
        "ogv" => '<svg class="w-5 h-5 flex-shrink-0" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M6 6.883v4.234a.5.5 0 0 0 .757.429l3.528-2.117a.5.5 0 0 0 0-.858L6.757 6.454a.5.5 0 0 0-.757.43z"></path><path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"></path></svg>',
        "txt" => '<svg class="w-5 h-5 flex-shrink-0" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2h-2v-1h2a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM1.928 15.849v-3.337h1.136v-.662H0v.662h1.134v3.337zm4.689-3.999h-.894L4.9 13.289h-.035l-.832-1.439h-.932l1.228 1.983-1.24 2.016h.862l.853-1.415h.035l.85 1.415h.907l-1.253-1.992zm1.93.662v3.337h-.794v-3.337H6.619v-.662h3.064v.662H8.546Z"></path></svg>',
        "doc" => '<svg class="w-5 h-5 flex-shrink-0" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2v-1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zm-7.839 9.166v.522q0 .384-.117.641a.86.86 0 0 1-.322.387.9.9 0 0 1-.469.126.9.9 0 0 1-.471-.126.87.87 0 0 1-.32-.386 1.55 1.55 0 0 1-.117-.642v-.522q0-.386.117-.641a.87.87 0 0 1 .32-.387.87.87 0 0 1 .471-.129q.264 0 .469.13a.86.86 0 0 1 .322.386q.117.255.117.641m.803.519v-.513q0-.565-.205-.972a1.46 1.46 0 0 0-.589-.63q-.381-.22-.917-.22-.533 0-.92.22a1.44 1.44 0 0 0-.589.627q-.204.406-.205.975v.513q0 .563.205.973.205.406.59.627.386.216.92.216.535 0 .916-.216.383-.22.59-.627.204-.41.204-.973M0 11.926v4h1.459q.603 0 .999-.238a1.45 1.45 0 0 0 .595-.689q.196-.45.196-1.084 0-.63-.196-1.075a1.43 1.43 0 0 0-.59-.68q-.395-.234-1.004-.234zm.791.645h.563q.371 0 .609.152a.9.9 0 0 1 .354.454q.118.302.118.753a2.3 2.3 0 0 1-.068.592 1.1 1.1 0 0 1-.196.422.8.8 0 0 1-.334.252 1.3 1.3 0 0 1-.483.082H.79V12.57Zm7.422.483a1.7 1.7 0 0 0-.103.633v.495q0 .369.103.627a.83.83 0 0 0 .298.393.85.85 0 0 0 .478.131.9.9 0 0 0 .401-.088.7.7 0 0 0 .273-.248.8.8 0 0 0 .117-.364h.765v.076a1.27 1.27 0 0 1-.226.674q-.205.29-.55.454a1.8 1.8 0 0 1-.786.164q-.54 0-.914-.216a1.4 1.4 0 0 1-.571-.627q-.194-.408-.194-.976v-.498q0-.568.197-.978.195-.411.571-.633.378-.223.911-.223.328 0 .607.097.28.093.489.272a1.33 1.33 0 0 1 .466.964v.073H9.78a.85.85 0 0 0-.12-.38.7.7 0 0 0-.273-.261.8.8 0 0 0-.398-.097.8.8 0 0 0-.475.138.87.87 0 0 0-.301.398"></path></svg>',
        "docx" => '<svg class="w-5 h-5 flex-shrink-0" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M14 4.5V11h-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zm-6.839 9.688v-.522a1.5 1.5 0 0 0-.117-.641.86.86 0 0 0-.322-.387.86.86 0 0 0-.469-.129.87.87 0 0 0-.471.13.87.87 0 0 0-.32.386 1.5 1.5 0 0 0-.117.641v.522q0 .384.117.641a.87.87 0 0 0 .32.387.9.9 0 0 0 .471.126.9.9 0 0 0 .469-.126.86.86 0 0 0 .322-.386 1.55 1.55 0 0 0 .117-.642m.803-.516v.513q0 .563-.205.973a1.47 1.47 0 0 1-.589.627q-.381.216-.917.216a1.86 1.86 0 0 1-.92-.216 1.46 1.46 0 0 1-.589-.627 2.15 2.15 0 0 1-.205-.973v-.513q0-.569.205-.975.205-.411.59-.627.386-.22.92-.22.535 0 .916.22.383.219.59.63.204.406.204.972M1 15.925v-3.999h1.459q.609 0 1.005.235.396.233.589.68.196.445.196 1.074 0 .634-.196 1.084-.197.451-.595.689-.396.237-.999.237zm1.354-3.354H1.79v2.707h.563q.277 0 .483-.082a.8.8 0 0 0 .334-.252q.132-.17.196-.422a2.3 2.3 0 0 0 .068-.592q0-.45-.118-.753a.9.9 0 0 0-.354-.454q-.237-.152-.61-.152Zm6.756 1.116q0-.373.103-.633a.87.87 0 0 1 .301-.398.8.8 0 0 1 .475-.138q.225 0 .398.097a.7.7 0 0 1 .273.26.85.85 0 0 1 .12.381h.765v-.073a1.33 1.33 0 0 0-.466-.964 1.4 1.4 0 0 0-.49-.272 1.8 1.8 0 0 0-.606-.097q-.534 0-.911.223-.375.222-.571.633-.197.41-.197.978v.498q0 .568.194.976.195.406.571.627.375.216.914.216.44 0 .785-.164t.551-.454a1.27 1.27 0 0 0 .226-.674v-.076h-.765a.8.8 0 0 1-.117.364.7.7 0 0 1-.273.248.9.9 0 0 1-.401.088.85.85 0 0 1-.478-.131.83.83 0 0 1-.298-.393 1.7 1.7 0 0 1-.103-.627zm5.092-1.76h.894l-1.275 2.006 1.254 1.992h-.908l-.85-1.415h-.035l-.852 1.415h-.862l1.24-2.015-1.228-1.984h.932l.832 1.439h.035z"></path></svg>',
        "xls" => '<svg class="w-5 h-5 flex-shrink-0" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM6.472 15.29a1.2 1.2 0 0 1-.111-.449h.765a.58.58 0 0 0 .254.384q.106.073.25.114.143.041.319.041.246 0 .413-.07a.56.56 0 0 0 .255-.193.5.5 0 0 0 .085-.29.39.39 0 0 0-.153-.326q-.152-.12-.462-.193l-.619-.143a1.7 1.7 0 0 1-.539-.214 1 1 0 0 1-.351-.367 1.1 1.1 0 0 1-.123-.524q0-.366.19-.639.19-.272.527-.422.338-.15.777-.149.457 0 .78.152.324.153.5.41.18.255.2.566h-.75a.56.56 0 0 0-.12-.258.6.6 0 0 0-.247-.181.9.9 0 0 0-.369-.068q-.325 0-.513.152a.47.47 0 0 0-.184.384q0 .18.143.3a1 1 0 0 0 .405.175l.62.143q.326.075.566.211a1 1 0 0 1 .375.358q.135.222.135.56 0 .37-.188.656a1.2 1.2 0 0 1-.539.439q-.351.158-.858.158-.381 0-.665-.09a1.4 1.4 0 0 1-.478-.252 1.1 1.1 0 0 1-.29-.375m-2.945-3.358h-.893L1.81 13.37h-.036l-.832-1.438h-.93l1.227 1.983L0 15.931h.861l.853-1.415h.035l.85 1.415h.908L2.253 13.94zm2.727 3.325H4.557v-3.325h-.79v4h2.487z"></path></svg>',
        "xlsx" => '<svg class="w-5 h-5 flex-shrink-0" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M14 4.5V11h-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM7.86 14.841a1.13 1.13 0 0 0 .401.823q.195.162.479.252.284.091.665.091.507 0 .858-.158.355-.158.54-.44a1.17 1.17 0 0 0 .187-.656q0-.336-.135-.56a1 1 0 0 0-.375-.357 2 2 0 0 0-.565-.21l-.621-.144a1 1 0 0 1-.405-.176.37.37 0 0 1-.143-.299q0-.234.184-.384.188-.152.513-.152.214 0 .37.068a.6.6 0 0 1 .245.181.56.56 0 0 1 .12.258h.75a1.1 1.1 0 0 0-.199-.566 1.2 1.2 0 0 0-.5-.41 1.8 1.8 0 0 0-.78-.152q-.44 0-.777.15-.336.149-.527.421-.19.273-.19.639 0 .302.123.524t.351.367q.229.143.54.213l.618.144q.31.073.462.193a.39.39 0 0 1 .153.326.5.5 0 0 1-.085.29.56.56 0 0 1-.255.193q-.168.07-.413.07-.176 0-.32-.04a.8.8 0 0 1-.249-.115.58.58 0 0 1-.255-.384zm-3.726-2.909h.893l-1.274 2.007 1.254 1.992h-.908l-.85-1.415h-.035l-.853 1.415H1.5l1.24-2.016-1.228-1.983h.931l.832 1.438h.036zm1.923 3.325h1.697v.674H5.266v-3.999h.791zm7.636-3.325h.893l-1.274 2.007 1.254 1.992h-.908l-.85-1.415h-.035l-.853 1.415h-.861l1.24-2.016-1.228-1.983h.931l.832 1.438h.036z"></path></svg>',
        "ppt" => '<svg class="w-5 h-5 flex-shrink-0" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM1.6 11.85H0v3.999h.791v-1.342h.803q.43 0 .732-.173.305-.175.463-.474a1.4 1.4 0 0 0 .161-.677q0-.375-.158-.677a1.2 1.2 0 0 0-.46-.477q-.3-.18-.732-.179m.545 1.333a.8.8 0 0 1-.085.38.57.57 0 0 1-.238.241.8.8 0 0 1-.375.082H.788V12.48h.66q.327 0 .512.181.185.183.185.522m2.817-1.333h-1.6v3.999h.791v-1.342h.803q.43 0 .732-.173.305-.175.463-.474.162-.302.161-.677 0-.375-.158-.677a1.2 1.2 0 0 0-.46-.477q-.3-.18-.732-.179m.545 1.333a.8.8 0 0 1-.085.38.57.57 0 0 1-.238.241.8.8 0 0 1-.375.082H4.15V12.48h.66q.327 0 .512.181.185.183.185.522m2.767-.67v3.336H7.48v-3.337H6.346v-.662h3.065v.662z"></path></svg>',
        "pptx" => '<svg class="w-5 h-5 flex-shrink-0" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M14 4.5V11h-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM1.5 11.85h1.6q.434 0 .732.179.302.175.46.477t.158.677-.16.677q-.159.299-.464.474a1.45 1.45 0 0 1-.732.173H2.29v1.342H1.5zm2.06 1.714a.8.8 0 0 0 .085-.381q0-.34-.185-.521-.185-.182-.513-.182h-.659v1.406h.66a.8.8 0 0 0 .374-.082.57.57 0 0 0 .238-.24m1.302-1.714h1.6q.434 0 .732.179.302.175.46.477t.158.677-.16.677q-.158.299-.464.474a1.45 1.45 0 0 1-.732.173h-.803v1.342h-.79zm2.06 1.714a.8.8 0 0 0 .085-.381q0-.34-.185-.521-.184-.182-.513-.182H5.65v1.406h.66a.8.8 0 0 0 .374-.082.57.57 0 0 0 .238-.24m2.852 2.285v-3.337h1.137v-.662H7.846v.662H8.98v3.337zm3.796-3.999h.893l-1.274 2.007 1.254 1.992h-.908l-.85-1.415h-.035l-.853 1.415h-.861l1.24-2.016-1.228-1.983h.931l.832 1.439h.035z"></path></svg>',
        "zip" => '<svg class="w-5 h-5 flex-shrink-0" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M6.5 7.5a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v.938l.4 1.599a1 1 0 0 1-.416 1.074l-.93.62a1 1 0 0 1-1.109 0l-.93-.62a1 1 0 0 1-.415-1.074l.4-1.599zm2 0h-1v.938a1 1 0 0 1-.03.243l-.4 1.598.93.62.93-.62-.4-1.598a1 1 0 0 1-.03-.243z"></path><path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2zm5.5-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H9v1H8v1h1v1H8v1h1v1H7.5V5h-1V4h1V3h-1V2h1z"></path></svg>',
        "rar" => '<svg class="w-5 h-5 flex-shrink-0" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M6.5 7.5a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v.938l.4 1.599a1 1 0 0 1-.416 1.074l-.93.62a1 1 0 0 1-1.109 0l-.93-.62a1 1 0 0 1-.415-1.074l.4-1.599zm2 0h-1v.938a1 1 0 0 1-.03.243l-.4 1.598.93.62.93-.62-.4-1.598a1 1 0 0 1-.03-.243z"></path><path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2zm5.5-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H9v1H8v1h1v1H8v1h1v1H7.5V5h-1V4h1V3h-1V2h1z"></path></svg>',
        "pdf" => '<svg class="w-5 h-5 flex-shrink-0" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"></path><path d="M4.603 14.087a.8.8 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102.198-.307.526-.568.897-.787a7.7 7.7 0 0 1 1.482-.645 20 20 0 0 0 1.062-2.227 7.3 7.3 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136.075-.354.274-.672.65-.823.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538.007.188-.012.396-.047.614-.084.51-.27 1.134-.52 1.794a11 11 0 0 0 .98 1.686 5.8 5.8 0 0 1 1.334.05c.364.066.734.195.96.465.12.144.193.32.2.518.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416.86.86 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.7 5.7 0 0 1-.911-.95 11.7 11.7 0 0 0-1.997.406 11.3 11.3 0 0 1-1.02 1.51c-.292.35-.609.656-.927.787a.8.8 0 0 1-.58.029m1.379-1.901q-.25.115-.459.238c-.328.194-.541.383-.647.547-.094.145-.096.25-.04.361q.016.032.026.044l.035-.012c.137-.056.355-.235.635-.572a8 8 0 0 0 .45-.606m1.64-1.33a13 13 0 0 1 1.01-.193 12 12 0 0 1-.51-.858 21 21 0 0 1-.5 1.05zm2.446.45q.226.245.435.41c.24.19.407.253.498.256a.1.1 0 0 0 .07-.015.3.3 0 0 0 .094-.125.44.44 0 0 0 .059-.2.1.1 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a4 4 0 0 0-.612-.053zM8.078 7.8a7 7 0 0 0 .2-.828q.046-.282.038-.465a.6.6 0 0 0-.032-.198.5.5 0 0 0-.145.04c-.087.035-.158.106-.196.283-.04.192-.03.469.046.822q.036.167.09.346z"></path></svg>',
    ];

    // 使用DOMDocument解析HTML
    $doc = new DOMDocument();
    libxml_use_internal_errors(true);
    $doc->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
    libxml_clear_errors();

    // 查找所有的<a>标签
    $links = $doc->getElementsByTagName('a');
    foreach ($links as $link) {
        $href = $link->getAttribute('href');
        $extension = pathinfo(parse_url($href, PHP_URL_PATH), PATHINFO_EXTENSION);
        $svg = array_key_exists($extension, $iconMap) ? $iconMap[$extension] : $iconMap['unknown'];

        // 创建新的HTML结构
        $newContent = $doc->createDocumentFragment();
        $htmlContent = <<<HTML
<div class="flex items-start my-2.5 hvr-forward bg-gray-100 dark:bg-zinc-800 cursor-pointer py-2 px-4 rounded-tl-lg rounded-tr-2xl rounded-br-2xl rounded-bl-2xl">
    <div class="flex-1 truncate">
        <div class="flex items-center gap-2 text-sm text-zinc-700 dark:text-white">
            $svg
            <div class="flex-grow pr-4 truncate">{$link->textContent}</div>
        </div>
        <span class="block text-xs font-normal truncate text-gray-500 dark:text-zinc-400 gap-2 pr-8">{$href}</span>
    </div>
</div>
HTML;
        $newContent->appendXML($htmlContent);
        $link->parentNode->replaceChild($newContent, $link);
    }

    // 返回修改后的HTML
    return $doc->saveHTML();
}
