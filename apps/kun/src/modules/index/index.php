<?php

/**
 * typecho-theme-kun for Typecho
 *
 * @package Typecho Shanhai Theme
 * @author Typecho Fan
 * @version 1.0
 * @link http://maxshader.com
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
?>

<!-- inject:css -->

<main class="mx-auto max-w-[560px]">

    <section class="flex justify-center m-3">
        <div class="kun-box">
            <img src="<?php $this->options->themeUrl('assets/img/kun_avatar.png'); ?>">
            <div class="eye left"></div>
            <div class="eye right"></div>
        </div>
    </section>

    <h3 class="text-center text-black text-opacity-80 mt-6"><?php echo $this->getDescription(); ?></h3>

    <div class="category mt-6 mb-3">
        <ul>
            <!-- PHP 动态生成分类 -->
            <?php $this->widget('Widget_Metas_Category_List')->to($categories); ?>
            <?php while ($categories->next()) : ?>
                <!-- 一级分类 -->
                <?php if ($categories->levels === 0) : ?>
                    <li>
                        <a href="<?php echo $categories->permalink; ?>" class="hvr-underline-from-center py-2 px-3 md:p-0 dark:text-white hover:bg-gray-50 md:hover:bg-transparent dark:hover:bg-gray-700">
                            <?php echo $categories->name; ?>
                        </a>
                    </li>
                <?php endif; ?>
            <?php endwhile; ?>
        </ul>
    </div>

    <div class="posts-in-category">
        <?php while ($this->next()) : ?>
            <article class="mb-8" itemscope itemtype="http://schema.org/BlogPosting">
                <a class="block mb-8" itemprop="url" href="<?php $this->permalink() ?>">
                    <h2 class="flex pb-3 font-bold items-center" itemprop="name headline">
                        <img class="flex-shrink-0 w-[18px] h-[18px] inline-block rounded mr-2" src="<?php echo getFirstImageSrc($this->content) ?>" />
                        <span><?php $this->title() ?></span>
                    </h2>
                    <div class="w-full post-content hvr-forward bg-gray-100 cursor-pointer p-4 rounded-tl-lg rounded-tr-xl rounded-br-xl rounded-bl-xl" itemprop="articleBody">
                        <?php echo mb_strlen($this->content) > 200 ? mb_substr(strip_tags($this->content), 0, 200, 'UTF-8') . '...' : strip_tags($this->content); ?>
                    </div>
                </a>
            </article>
        <?php endwhile; ?>

        <?php $this->pageNav('&laquo; 前一页', '后一页 &raquo;'); ?>
    </div>

</main>

<!-- inject:js -->