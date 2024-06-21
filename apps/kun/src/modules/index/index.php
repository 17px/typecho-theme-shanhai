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

<main class="pt-20 px-4 mx-auto <?php $this->options->viewWidth() ?>">

  <!-- 今日诗词 -->
  <?php if ($this->options->mottoSelect == 'shici') : ?>
    <script src="https://sdk.jinrishici.com/v2/browser/jinrishici.js" charset="utf-8"></script>

    <h3 class="text-center font-semibold text-[30px] text-opacity-80">
      <span id="one-sentence"></span>
    </h3>
    <h3 class="text-center text-gray-800 dark:text-zinc-200 text-opacity-80 pt-3">
      <span id="one-sentence-meta"></span>
    </h3>

    <script type="text/javascript">
      jinrishici.load(function(result) {
        // 自己的处理逻辑
        const dom = document.querySelector("#one-sentence")
        const meta = document.querySelector("#one-sentence-meta")
        if (dom && result.status === 'success' && meta) {
          dom.innerHTML = result.data['content']
          const {
            dynasty = '',
              author = '',
              title = ''
          } = result.data['origin']
          meta.innerHTML = `${dynasty} · ${author} · 「${title}」`
        }
      });
    </script>
  <?php endif; ?>

  <!-- 描述 -->
  <?php if ($this->options->mottoSelect == 'description') : ?>
    <h3 class="text-center font-semibold text-black dark:text-zinc-200 text-2xl text-opacity-80 mt-6"><?php echo $this->author(); ?></h3>
    <div class="inline-flex items-center justify-center w-full">
      <hr class="w-64 h-1 my-8 bg-gray-200 border-0 rounded dark:bg-gray-700">
      <div class="absolute px-2 -translate-x-1/2 bg-white left-1/2 dark:bg-gray-900">
        <a href="mailto:<?php echo $this->author('mail'); ?>" class="hidden sm:inline-flex items-center justify-center text-gray-500 w-10 h-10 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm">
          <svg class="w-[1.1rem] h-[1.1rem] text-zinc-800" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
            <path fill="none" d="M0 0h24v24H0z"></path>
            <path d="M22 8.98V18c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2l.01-12c0-1.1.89-2 1.99-2h10.1c-.06.32-.1.66-.1 1s.04.68.1 1H4l8 5 3.67-2.29c.47.43 1.02.76 1.63.98L12 13 4 8v10h16V9.9c.74-.15 1.42-.48 2-.92zM16 5c0 1.66 1.34 3 3 3s3-1.34 3-3-1.34-3-3-3-3 1.34-3 3z"></path>
          </svg>
        </a>
      </div>
    </div>
    <h3 class="text-center font-semibold text-black text-sm text-opacity-80"><?php $this->options->description() ?></h3>
  <?php endif; ?>


  <div class="posts-in-category pt-20">
    <?php while ($this->next()) : ?>
      <article class="mb-8" itemscope itemtype="http://schema.org/BlogPosting">
        <a class="block mb-8 hvr-shrink" itemprop="url" href="<?php $this->permalink() ?>">
          <h2 class="pb-3 font-bold" itemprop="name headline">
            <span><?php echo analyzePostContent($this->content) ?></span>
            <span class="align-middle"><?php $this->title() ?></span>
          </h2>
          <div class="tracking-wider w-full post-content bg-gray-100 dark:bg-zinc-800 cursor-pointer p-4 rounded-tl-lg rounded-tr-2xl rounded-br-2xl rounded-bl-2xl" itemprop="articleBody">
            <p class="break-all text-sm text-zinc-700 dark:text-zinc-400"><?php $this->excerpt(80, '...') ?></p>
            <div class="pt-3 text-xs text-zinc-500 flex items-center justify-between">
              <time class="mr-3" datetime="<?php $this->date('c'); ?>" itemprop="datePublished"><?php $this->date('F j, Y'); ?></time>
              <div>
                <span class="inline-flex items-center">
                  阅读 <?php get_post_view($this) ?>
                </span>
                <span class="mr-3 inline-flex items-center">
                  评论 <?php $this->commentsNum('%d'); ?>
                </span>
              </div>
            </div>
          </div>
        </a>
      </article>
    <?php endwhile; ?>

    <?php
    $this->pageNav(
      '<svg class="w-3.5 h-3.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5H1m0 0 4 4M1 5l4-4"/></svg>',
      '<svg class="w-3.5 h-3.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/></svg>',
      1,
      '...',
      array(
        'wrapTag' => 'ul',
        'wrapClass' => 'pagination',
        'itemTag' => 'li',
        'textTag' => 'a',
        'currentClass' => 'active',
        'prevClass' => 'prev',
        'nextClass' => 'next'
      )
    );
    ?>
  </div>
</main>

<?php $this->need('footer.php'); ?>




<!-- inject:js -->