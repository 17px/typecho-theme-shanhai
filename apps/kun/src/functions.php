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

    $blogName = new \Typecho\Widget\Helper\Form\Element\Text(
        'blogName',
        null,
        "iKun",
        _t('blogName'),
        _t('左上角博客名称')
    );

    $userName = new \Typecho\Widget\Helper\Form\Element\Text(
        'userName',
        null,
        "练习时长1坤年",
        _t('userName'),
        _t('博主名称')
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

    $prismTheme = new \Typecho\Widget\Helper\Form\Element\Text(
        'prismTheme',
        null,
        "atom-dark",
        _t('prism代码高亮主题'),
        _t('目前支持的有：1,2,3,4')
    );



    $form->addInput($logoUrl);
    $form->addInput($blogName);
    $form->addInput($userName);
    $form->addInput($hero);
    $form->addInput($fontCDN);
    $form->addInput($fontName);
    $form->addInput($prismTheme);


    $sidebarBlock = new \Typecho\Widget\Helper\Form\Element\Checkbox(
        'sidebarBlock',
        [
            'ShowRecentPosts'    => _t('显示最新文章'),
            'ShowRecentComments' => _t('显示最近回复'),
            'ShowCategory'       => _t('显示分类'),
            'ShowArchive'        => _t('显示归档'),
            'ShowOther'          => _t('显示其它杂项')
        ],
        ['ShowRecentPosts', 'ShowRecentComments', 'ShowCategory', 'ShowArchive', 'ShowOther'],
        _t('侧边栏显示')
    );

    $form->addInput($sidebarBlock->multiMode());
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