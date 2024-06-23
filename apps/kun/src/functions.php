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
        ],
        ['ShowFastBar', 'ShowCommentEmoji'],
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
        $result[$url] = ['items' => $items];
    }

    // 返回JSON对象
    return json_encode($result);
}
