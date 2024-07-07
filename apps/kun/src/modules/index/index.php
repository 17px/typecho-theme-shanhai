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

<main class="pt-10 px-4 mx-auto <?php $this->options->viewWidth() ?>">

  <!-- 今日诗词 -->
  <?php if ($this->options->mottoSelect == 'shici') : ?>
    <script src="https://sdk.jinrishici.com/v2/browser/jinrishici.js" charset="utf-8"></script>

    <div class="leading-6 w-full pb-20 text-center">
      <h2 id="shici-title" class="text-3xl text-opacity-80 dark:text-zinc-200"></h2>
      <p id="shici-content" class="text-start py-2 text-lg text-opacity-80 dark:text-zinc-400 max-h-52"></p>
      <span id="shici-meta" class="rounded text-white p-1 bg-red-600 mr-4 text-sm"></span>
    </div>

    <script type="text/javascript">
      jinrishici.load(function(result) {
        // 自己的处理逻辑
        const shici_title = document.querySelector("#shici-title")
        const content = document.querySelector("#shici-content")
        const meta = document.querySelector("#shici-meta")
        if (content && result.status === 'success' && meta) {
          const full = result.data['origin']['content'].join('')
          content.textContent = full.length > 175 ? result.data['content'] : full
          const {
            dynasty = '',
              author = '',
              title = ''
          } = result.data['origin']
          shici_title.textContent = title
          meta.textContent = `${dynasty} · ${author}`
        }
      });
    </script>
  <?php endif; ?>

  <div class="posts-in-category">
    <?php while ($this->next()) : ?>
      <article class="mb-8" itemscope itemtype="http://schema.org/BlogPosting">
        <a class="block mb-8 hvr-forward" itemprop="url" href="<?php $this->permalink() ?>">
          <h2 class="pb-3 font-bold dark:text-zinc-200" itemprop="name headline">
            <span><?php echo analyzePostContent($this->content) ?></span>
            <span class="align-middle"><?php $this->title() ?></span>
          </h2>
          <div class="tracking-wider w-full post-content bg-gray-100 dark:bg-zinc-800 cursor-pointer p-4 rounded-tl-lg rounded-tr-2xl rounded-br-2xl rounded-bl-2xl" itemprop="articleBody">
            <p class="break-all text-sm text-zinc-700 leading-6 dark:text-zinc-400"><?php $this->excerpt(120, '...') ?></p>
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