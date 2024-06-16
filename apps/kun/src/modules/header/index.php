<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<!DOCTYPE HTML>
<html class="<?php $this->options->themeMode(); ?>">

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

  <!-- 全局字体 -->
  <?php if ($this->options->fontFamily != 'base') : ?>
    <link rel="stylesheet" href="<?php echo getFontCdn($this->options->fontFamily) ?>" />
    <style>
      /* 全局设置字体，排除 .markdown-body 下的 code 和 span */
      *:not(.markdown-body pre code):not(.markdown-body span) {
        font-family: <?php $this->options->fontFamily() ?>, sans-serif;
      }
    </style>
  <?php endif; ?>

  <!-- 通过自有函数输出HTML头部信息 -->
  <?php $this->header(); ?>
</head>

<body class="bg-white  text-zinc-700 text-base dark:text-white dark:bg-zinc-900 transition-colors duration-300">
  <nav class="frosted sticky top-0 z-50 w-full">
    <div class="flex flex-wrap p-3 justify-center items-center mx-auto max-w-screen-xl">
      <button data-collapse-toggle="mega-menu-full" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-zinc-500 rounded-lg md:hidden hover:bg-zinc-100 focus:outline-none focus:ring-2 focus:ring-zinc-200 dark:text-zinc-400 dark:hover:bg-zinc-700 dark:focus:ring-zinc-600" aria-controls="mega-menu-full" aria-expanded="false">
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15" />
        </svg>
      </button>
      <!-- 页面 -->
      <div id="mega-menu-full" class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1">
        <ul class="flex items-center flex-col mt-4 font-medium md:flex-row md:mt-0 md:space-x-8 rtl:space-x-reverse">
          <li>
            <button class="flex items-center justify-between w-full py-2 px-3 font-medium text-zinc-900 border-b border-zinc-100 md:w-auto hover:bg-zinc-50 md:hover:bg-transparent md:border-0 md:hover:text-blue-600 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-zinc-700 dark:hover:text-blue-500 md:dark:hover:bg-transparent dark:border-zinc-700">
              <a href="/">首页</a>
            </button>
          </li>
          <li>
            <button data-collapse-toggle="mega-menu-full-dropdown" class="flex items-center justify-between w-full py-2 px-3 font-medium text-zinc-900 border-b border-zinc-100 md:w-auto hover:bg-zinc-50 md:hover:bg-transparent md:border-0 md:hover:text-blue-600 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-zinc-700 dark:hover:text-blue-500 md:dark:hover:bg-transparent dark:border-zinc-700">笔耕<svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
              </svg>
            </button>
          </li>
          <li>
            <button id="dropdownMenuIconButton" data-dropdown-toggle="dropdownDots" class="inline-flex items-center p-2 text-sm font-medium text-center text-zinc-900 rounded-lg hover:bg-zinc-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-zinc-50 dark:bg-zinc-800 dark:hover:bg-zinc-900 dark:focus:ring-zinc-600" type="button">
              <svg class="w-[.8rem] h-[.8rem]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                <path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
              </svg>
            </button>

            <div id="dropdownDots" class="z-10 hidden bg-white divide-y divide-zinc-100 rounded-lg shadow w-44 dark:bg-zinc-700 dark:divide-zinc-600">
              <ul class="py-2 text-sm text-zinc-700 dark:text-zinc-200" aria-labelledby="dropdownMenuIconButton">
                <?php \Widget\Contents\Page\Rows::alloc()->to($pages); ?>
                <?php while ($pages->next()) : ?>
                  <li>
                    <a class=" block px-4 py-2 hover:bg-zinc-100 dark:hover:bg-zinc-600 dark:hover:text-white <?php if ($this->is('page', $pages->slug)) : ?>current<?php endif; ?>" href="<?php $pages->permalink(); ?>" title="<?php $pages->title(); ?>"><?php $pages->title(); ?></a>
                  </li>
                <?php endwhile; ?>
              </ul>
              <?php if ($this->user->hasLogin()) : ?>
                <div class="py-2">
                  <a class="block px-4 py-2 text-sm text-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-600 dark:text-zinc-200 dark:hover:text-white" href="<?php $this->options->logoutUrl(); ?>" title="Logout"><?php _e('退出'); ?></a>
                </div>
              <?php endif; ?>
            </div>
          </li>
        </ul>
      </div>
    </div>
    <!-- 文章分类 -->
    <div id="mega-menu-full-dropdown" class="mt-1 bg-white hidden border-zinc-100 shadow-sm border-y dark:bg-zinc-900 dark:border-zinc-800">
      <div class="grid max-w-screen-xl px-4 py-5 mx-auto text-zinc-900 dark:text-white sm:grid-cols-2 md:grid-cols-3 md:px-6">
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
              <a href="<?php echo $categories->permalink; ?>" class="truncate block p-3 rounded-lg hover:bg-zinc-50 dark:hover:bg-zinc-800">
                <div class="font-semibold flex items-center">
                  <span><?php echo $categories->name; ?></span>
                  <span class="ml-2 bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 rounded-full dark:bg-blue-900 dark:text-blue-300"><?php echo $categories->count; ?></span>
                </div>
                <span class="text-sm text-zinc-500 dark:text-zinc-400"><?php echo $categories->description; ?></span>
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