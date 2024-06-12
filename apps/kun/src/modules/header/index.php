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
  <link rel="stylesheet" href="<?php $this->options->fontCDN() ?>" />
  <style>
    /* 全局设置字体，排除 .markdown-body 下的 code 和 span */
    *:not(.markdown-body code):not(.markdown-body span) {
      font-family: <?php $this->options->fontName() ?>, sans-serif;
    }
  </style>
  <!-- 通过自有函数输出HTML头部信息 -->
  <?php $this->header(); ?>
</head>

<body class="bg-white dark:bg-gray-900 text-zinc-700 text-base dark:text-white transition-colors duration-300">
  <nav class="frosted sticky py-2 top-0 z-50 w-full">
    <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl">
      <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
        <section class="flex justify-center">
          <div class="kun-box">
            <img src="<?php $this->options->themeUrl('assets/img/kun_avatar.png'); ?>">
            <div class="eye left"></div>
            <div class="eye right"></div>
          </div>
        </section>
      </a>
      <button data-collapse-toggle="mega-menu-full" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="mega-menu-full" aria-expanded="false">
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15" />
        </svg>
      </button>
      <!-- 页面 -->
      <div id="mega-menu-full" class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1">
        <ul class="flex flex-col mt-4 font-medium md:flex-row md:mt-0 md:space-x-8 rtl:space-x-reverse">
          <li>
            <button id="mega-menu-full-dropdown-button" data-collapse-toggle="mega-menu-full-dropdown" class="flex items-center justify-between w-full py-2 px-3 font-medium text-gray-900 border-b border-gray-100 md:w-auto hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-blue-600 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-blue-500 md:dark:hover:bg-transparent dark:border-gray-700">文章分类<svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
              </svg></button>
          </li>
          <?php \Widget\Contents\Page\Rows::alloc()->to($pages); ?>
          <?php while ($pages->next()) : ?>
            <li>
              <a class="block py-2 px-3 md:p-0 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700 <?php if ($this->is('page', $pages->slug)) : ?>current<?php endif; ?>" href="<?php $pages->permalink(); ?>" title="<?php $pages->title(); ?>"><?php $pages->title(); ?></a>
            </li>
          <?php endwhile; ?>
        </ul>
      </div>
    </div>
    <!-- 文章分类 -->
    <div id="mega-menu-full-dropdown" class="mt-1 bg-white hidden border-gray-200 shadow-sm border-y dark:bg-gray-800 dark:border-gray-600">
      <div class="grid max-w-screen-xl px-4 py-5 mx-auto text-gray-900 dark:text-white sm:grid-cols-2 md:grid-cols-3 md:px-6">
        <?php
        $this->widget('Widget_Metas_Category_List')->to($categories);
        $count = 0; // 初始化计数器
        $open = false; // 用于跟踪<ul>标签是否已打开

        while ($categories->next()) :
          if ($categories->levels === 0) :
            if ($count % 3 === 0) : // 每三个项开始一个新的<ul>
              if ($open) :
                echo '</ul>'; // 如果已经打开了一个<ul>，则先关闭它
              endif;
              echo '<ul>'; // 开启新的<ul>
              $open = true; // 标记<ul>已经打开
            endif;
            $count++; // 增加计数器
        ?>
            <li>
              <a href="<?php echo $categories->permalink; ?>" class="truncate block p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                <div class="font-semibold flex items-center">
                  <span><?php echo $categories->name; ?></span>
                  <span class="ml-2 bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 rounded-full dark:bg-blue-900 dark:text-blue-300"><?php echo $categories->count; ?></span>
                </div>
                <span class="text-sm text-gray-500 dark:text-gray-400"><?php echo $categories->description; ?></span>
              </a>
            </li>
        <?php
          endif;
        endwhile;

        if ($open) :
          echo '</ul>'; // 确保最后一个<ul>被关闭
        endif;
        ?>
      </div>
    </div>
  </nav>

  <!-- inject:js -->