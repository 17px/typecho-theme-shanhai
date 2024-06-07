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

  <header>
    <?php if ($this->options->logoUrl) : ?>
      <a id="logo" href="<?php $this->options->siteUrl(); ?>">
        <img src="<?php $this->options->logoUrl() ?>" alt="<?php $this->options->title() ?>" />
      </a>
    <?php else : ?>
      <a id="logo" href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title() ?></a>
      <p class="description"><?php $this->options->description() ?></p>
    <?php endif; ?>
  </header>

  <button id="darkModeToggle">Toggle Dark Mode</button>
  <div class="flex justify-center items-center min-h-screen">
    <button class="bg-primary text-white font-bold py-2 px-4 rounded hover:bg-primary-dark dark:bg-primary-dark dark:hover:bg-primary">
      Click Me
    </button>
  </div>
  <!-- inject:js -->