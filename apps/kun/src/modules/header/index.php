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
            <button data-modal-target="search-modal" data-modal-toggle="search-modal" data-tooltip-target="tooltip-search" data-tooltip-style="light" class="flex items-center justify-between w-full py-2 px-3 font-medium text-zinc-900 border-b border-zinc-100 md:w-auto hover:bg-zinc-50 md:hover:bg-transparent md:border-0 md:hover:text-blue-600 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-zinc-700 dark:hover:text-blue-500 md:dark:hover:bg-transparent dark:border-zinc-700">
              <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1.25em" width="1.25em" xmlns="http://www.w3.org/2000/svg">
                <path fill="none" d="M0 0h24v24H0V0z"></path>
                <path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path>
              </svg>
            </button>
            <div id="tooltip-search" role="tooltip" class="absolute z-10 invisible inline-block px-2 py-2 text-sm font-medium text-zinc-900 bg-white border border-zinc-200  rounded-lg shadow-sm opacity-0 tooltip">
              <span class="mr-1">快捷查询</span>
              <kbd class="px-2 py-1 text-sm  text-zinc-800 bg-zinc-100 border border-zinc-200 rounded"><?php echo getPlatformKey() ?></kbd>
              <kbd class="px-2 py-1 text-sm  text-zinc-800 bg-zinc-100 border border-zinc-200 rounded">K</kbd>
            </div>
          </li>
          <li>
            <a href="/" data-tooltip-target="tooltip-index" data-tooltip-style="light" class="flex items-center justify-between w-full py-2 px-3 font-medium text-zinc-900 border-b border-zinc-100 md:w-auto hover:bg-zinc-50 md:hover:bg-transparent md:border-0 md:hover:text-blue-600 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-zinc-700 dark:hover:text-blue-500 md:dark:hover:bg-transparent dark:border-zinc-700">
              首页
            </a>
            <div id="tooltip-index" role="tooltip" class="absolute z-10 invisible inline-block px-2 py-2 text-sm font-medium text-zinc-900 bg-white border border-zinc-200  rounded-lg shadow-sm opacity-0 tooltip">
              <span class="mr-1">回到首页</span>
              <kbd class="px-2 py-1 text-sm  text-zinc-800 bg-zinc-100 border border-zinc-200 rounded"><?php echo getPlatformKey() ?></kbd>
              <kbd class="px-2 py-1 text-sm  text-zinc-800 bg-zinc-100 border border-zinc-200 rounded">/</kbd>
            </div>
          </li>
          <li>
            <button data-tooltip-target="tooltip-category" data-tooltip-style="light" data-collapse-toggle="mega-menu-full-dropdown" class="flex items-center justify-between w-full py-2 px-3 font-medium text-zinc-900 border-b border-zinc-100 md:w-auto hover:bg-zinc-50 md:hover:bg-transparent md:border-0 md:hover:text-blue-600 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-zinc-700 dark:hover:text-blue-500 md:dark:hover:bg-transparent dark:border-zinc-700">笔耕<svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
              </svg>
            </button>
            <div id="tooltip-category" role="tooltip" class="absolute z-10 invisible inline-block px-2 py-2 text-sm font-medium text-zinc-900 bg-white border border-zinc-200  rounded-lg shadow-sm opacity-0 tooltip">
              <span class="mr-1">显示/隐藏 分类</span>
              <kbd class="px-2 py-1 text-sm  text-zinc-800 bg-zinc-100 border border-zinc-200 rounded">[</kbd>
            </div>
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
                <?php if ($pages->length > 0) : ?>
                  <?php while ($pages->next()) : ?>
                    <li>
                      <a class=" block px-4 py-2 hover:bg-zinc-100 dark:hover:bg-zinc-600 dark:hover:text-white <?php if ($this->is('page', $pages->slug)) : ?>current<?php endif; ?>" href="<?php $pages->permalink(); ?>" title="<?php $pages->title(); ?>"><?php $pages->title(); ?></a>
                    </li>
                  <?php endwhile; ?>
                <?php endif; ?>
                <li>
                  <?php if ($this->user->hasLogin()) : ?>
                    <div class="py-2">
                      <a class="block px-4 py-2 text-sm text-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-600 dark:text-zinc-200 dark:hover:text-white" href="<?php $this->options->logoutUrl(); ?>" title="Logout"><?php _e('退出'); ?></a>
                    </div>
                  <?php endif; ?>
                </li>
              </ul>
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

  <!-- 搜索框弹出层 -->
  <div id="search-modal" tabindex="-1" class="hidden bg-white dark:bg-black backdrop-blur-sm overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
      <!-- 标签跑马 -->
      <div class="scroll-container mb-4 py-4 relative w-full overflow-hidden">
        <div class="bg-gradient-to-r from-white to-transparent dark:from-black w-1/4 h-full absolute top-0 left-0 z-10"></div>
        <div class="bg-gradient-to-l from-white to-transparent dark:from-black w-1/4 h-full absolute top-0 right-0 z-10"></div>
        <?php
        $tags = getAllTags();
        $totalTags = count($tags);
        $index = 0;

        while ($index < $totalTags) :
          $numTags = rand(4,6);
          $rowTags = array_slice($tags, $index, $numTags);
          if (empty($rowTags)) {
            break;
          }
        ?>
          <div class="scroll-row leading-10 py-2">
            <?php foreach ($rowTags as $tag) : ?>
              <a href="<?php echo $tag['link']; ?>" class="mr-8 border border-zinc-200/[.5] text-zinc-400 hover:text-zinc-600 dark:text-zinc-600 dark:hover:text-zinc-400 dark:border-zinc-600/[.5] hvr-grow inline-flex justify-between items-center py-1 px-2 text-sm rounded-xl">
                <span><?php echo $tag['name']; ?></span>
              </a>
            <?php endforeach; ?>
          </div>
        <?php
          $index += $numTags;
        endwhile;
        ?>
      </div>
      <div class="relative bg-white rounded-lg shadow dark:bg-zinc-700">
        <form class="max-w-md mx-auto" method="post" action="<?php $this->options->siteUrl(); ?>" role="search">
          <label for="default-search" class="mb-2 text-sm font-medium text-zinc-900 sr-only dark:text-white"><?php _e('搜索关键字'); ?></label>
          <div class="relative">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
              <svg class="w-4 h-4 text-zinc-500 dark:text-zinc-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
              </svg>
            </div>
            <input id="s" name="s" autocomplete="off" type="search" class="block w-full p-4 ps-10 text-sm text-zinc-900 border border-zinc-300 rounded-lg bg-zinc-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-800 dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="<?php _e('输入关键字搜索'); ?>" required />
            <button type="submit" class="hidden text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"><?php _e('搜索'); ?></button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- inject:js -->