<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<!DOCTYPE HTML>
<html class="dark">

<head>
  <meta charset="<?php $this->options->charset(); ?>">
  <meta name="renderer" content="webkit">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title><?php $this->archiveTitle([
            'category' => _t('分类 %s 下的文章'),
            'search'   => _t('包含关键字 %s 的文章'),
            'tag'      => _t('标签 %s 下的文章'),
            'author'   => _t('%s 发布的文章')
          ], '', ' - '); ?><?php $this->options->title(); ?></title>

  <!-- inject:css -->
  <!-- 通过自有函数输出HTML头部信息 -->
  <?php $this->header(); ?>
</head>

<body class="bg-white dark:bg-gray-900 text-black dark:text-white transition-colors duration-300">



  <header class="flex pl-8 pr-8 leading-loose">
    <div class="w-1/2 md:w-auto">
      <span><?php $this->options->title() ?></span>
    </div>
    <div class="w-1/2 md:flex-1 hidden md:block text-center">
      <nav id="nav-menu" class="clearfix" role="navigation">
        <a class="text-base ml-1.5 mr-1.5 hvr-underline-from-center <?php if ($this->is('index')) : ?>current<?php endif; ?>" href="<?php $this->options->siteUrl(); ?>"><?php _e('首页'); ?></a>
        <?php \Widget\Contents\Page\Rows::alloc()->to($pages); ?>
        <?php while ($pages->next()) : ?>
          <a class="text-base ml-1.5 mr-1.5 hvr-underline-from-center <?php if ($this->is('page', $pages->slug)) : ?>current<?php endif; ?>" href="<?php $pages->permalink(); ?>" title="<?php $pages->title(); ?>"><?php $pages->title(); ?></a>
        <?php endwhile; ?>
      </nav>
    </div>
    <div class="w-1/2 md:w-auto">
      <a data-tooltip-target="tooltip_sign" data-tooltip-placement="left" target="_blank" class="text-base ml-1.5 mr-1.5" href="/admin">登录</a>
      <div id="tooltip_sign" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
        秘密之地
        <div class="tooltip-arrow" data-popper-arrow></div>
      </div>
    </div>
  </header>

  <button id="darkModeToggle"></button>

  <!-- inject:js -->