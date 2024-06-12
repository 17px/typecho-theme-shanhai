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

  <h3 class="text-center font-semibold text-black text-[30px] text-opacity-80 mt-6"><?php echo $this->author(); ?></h3>
  <div class="inline-flex items-center justify-center w-full">
    <hr class="w-64 h-1 my-8 bg-gray-200 border-0 rounded dark:bg-gray-700">
    <div class="absolute px-4 -translate-x-1/2 bg-white left-1/2 dark:bg-gray-900">
      <a href="mailto:<?php echo $this->author('mail'); ?>" data-tooltip-placement="top" data-tooltip-target="tooltip-mail" class="hidden sm:inline-flex items-center justify-center text-gray-500 w-10 h-10 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5 mr-1">
        <svg class="w-[1.1rem] h-[1.1rem] text-zinc-800" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
          <path fill="none" d="M0 0h24v24H0z"></path>
          <path d="M22 8.98V18c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2l.01-12c0-1.1.89-2 1.99-2h10.1c-.06.32-.1.66-.1 1s.04.68.1 1H4l8 5 3.67-2.29c.47.43 1.02.76 1.63.98L12 13 4 8v10h16V9.9c.74-.15 1.42-.48 2-.92zM16 5c0 1.66 1.34 3 3 3s3-1.34 3-3-1.34-3-3-3-3 1.34-3 3z"></path>
        </svg>
      </a>
    </div>
  </div>
  <h3 class="text-center text-black text-opacity-80"><?php echo $this->getDescription(); ?></h3>

  <div class="posts-in-category mt-12">
    <?php while ($this->next()) : ?>
      <article class="mb-8" itemscope itemtype="http://schema.org/BlogPosting">
        <a class="block mb-8" itemprop="url" href="<?php $this->permalink() ?>">
          <h2 class="pb-3 font-bold text-black" itemprop="name headline">
            <img data-title="<?php $this->title() ?>" class="flex-shrink-0 w-[20px] bg-gray-100 p-1 h-[20px] inline-block rounded" />
            <span class="align-middle"><?php $this->title() ?></span>
          </h2>
          <div class="tracking-wider w-full post-content hvr-forward bg-gray-100 cursor-pointer p-4 rounded-tl-lg rounded-tr-xl rounded-br-xl rounded-bl-xl" itemprop="articleBody">
            <?php echo mb_strlen($this->content) > 140 ? mb_substr(strip_tags($this->content), 0, 140, 'UTF-8') . '...' : strip_tags($this->content); ?>
          </div>
        </a>
      </article>
    <?php endwhile; ?>

    <?php $this->pageNav('&laquo; 前一页', '后一页 &raquo;'); ?>
  </div>
</main>

<?php $this->need('footer.php'); ?>

<!-- inject:js -->