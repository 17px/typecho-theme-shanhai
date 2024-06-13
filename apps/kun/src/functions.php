<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

function themeConfig($form)
{
    $logoUrl = new \Typecho\Widget\Helper\Form\Element\Text(
        'logoUrl',
        null,
        null,
        _t('站点 LOGO 地址'),
        _t('在这里填入一个图片 URL 地址, 以在网站标题前加上一个 LOGO')
    );

    $hero = new \Typecho\Widget\Helper\Form\Element\Text(
        'hero',
        null,
        "无与伦比的追求冰冷地敲打着我的灵魂",
        _t('hero'),
        _t('介绍/座右铭')
    );

    $fontCDN = new \Typecho\Widget\Helper\Form\Element\Text(
        'fontCDN',
        null,
        "https://chinese-fonts-cdn.deno.dev/chinesefonts3/packages/lxgwwenkai/dist/LXGWWenKai-Bold/result.css",
        _t('字体cdn'),
        _t('可以在这里找到喜欢的字体：https://chinese-font.netlify.app/cdn/')
    );

    $fontName = new \Typecho\Widget\Helper\Form\Element\Text(
        'fontName',
        null,
        "LXGW WenKai",
        _t('字体名称'),
        _t('font-family需要用到，推荐：LXGW WenKai，LXGW WenKai Light，Source Han Serif CN VF，Source Han Serif CN for Display')
    );

    $viewWidth = new \Typecho\Widget\Helper\Form\Element\Select(
        'viewWidth',
        array(
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

    $form->addInput($logoUrl);
    $form->addInput($hero);
    $form->addInput($fontCDN);
    $form->addInput($fontName);
    $form->addInput($viewWidth);
    $form->addInput($prismTheme);
    $form->addInput($markdownTheme);
    $form->addInput($mottoSelect);


    $moreConfig = new \Typecho\Widget\Helper\Form\Element\Checkbox(
        'moreConfig',
        [
            'ShowThemeAuthor' => _t('显示主题作者')
        ],
        ['ShowThemeAuthor'],
        _t('主题基本的配置')
    );

    $form->addInput($moreConfig->multiMode());
}

/**
 * 获取文章图片(第一张)
 */
function getFirstImageSrc($content)
{
    preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $matches);
    return isset($matches[1][0]) ? $matches[1][0] : 'data:image/svg+xml;base64,PHN2ZyBzdHJva2U9ImN1cnJlbnRDb2xvciIgZmlsbD0ibm9uZSIgc3Ryb2tlLXdpZHRoPSIyIiB2aWV3Qm94PSIwIDAgMjQgMjQiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIgaGVpZ2h0PSIxZW0iIHdpZHRoPSIxZW0iIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHBhdGggZD0iTTIgM2g2YTQgNCAwIDAgMSA0IDR2MTRhMyAzIDAgMCAwLTMtM0gyeiI+PC9wYXRoPjxwYXRoIGQ9Ik0yMiAzaC02YTQgNCAwIDAgMC00IDR2MTRhMyAzIDAgMCAxIDMtM2g3eiI+PC9wYXRoPjwvc3ZnPg==';
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

// 辅助函数来获取父评论的作者名
function getParentCommentAuthor($parentId)
{
    $db = Typecho_Db::get();
    $query = $db->select('author')->from('table.comments')->where('coid = ?', $parentId);
    $result = $db->fetchRow($query);
    return $result ? $result['author'] : '';
}

/**
 * 获取前 n 篇内容的详细信息
 *
 * @access public
 * @param Widget_Abstract_Contents $context 当前内容上下文
 * @param int $num 数量
 * @return array 返回包含上 n 篇文章的数组，数组中的每个元素包含链接、标题和内容
 */
function getPreviousArticles($context, $num = 1)
{
    $db = Typecho_Db::get();
    $contents = $db->fetchAll($context->select()
        ->from('table.contents')
        ->where('table.contents.created < ?', $context->created)
        ->where('table.contents.status = ?', 'publish')
        ->where('table.contents.type = ?', $context->type)
        ->where("table.contents.password IS NULL OR table.contents.password = ''")
        ->order('table.contents.created', Typecho_Db::SORT_DESC)
        ->limit($num));

    $articles = [];
    foreach ($contents as $content) {
        $filteredContent = $context->filter($content);
        $articles[] = [
            'title' => $filteredContent['title'],
            'link' => $filteredContent['permalink'],
            'content' => $filteredContent['text']
        ];
    }

    return $articles;
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
        return 'cmd';
    } else {
        return 'ctrl';
    }
}
