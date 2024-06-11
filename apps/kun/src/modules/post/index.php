<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

<div class="mx-auto max-w-[560px] pb-4">
    <!-- 标题 -->
    <h1 class="pt-12 text-center">
        「<?php $this->category(','); ?>」
        <span class="text-gray-500 dark:text-gray-400"><?php $this->title() ?></span>
    </h1>

    <!-- meta -->
    <div class="mt-3 mb-8" itemscope itemtype="http://schema.org/BlogPosting">
        <div class="pt-3 mb-12 flex justify-between items-center border-t">
            <img class="w-[32px] h-[32px] rounded-lg flex-shrink-0" src="<?php echo getGravatar($this->author->mail); ?>" alt="<?php $this->author(); ?>" />
            <div class="flex-grow pl-3">
                <p class="text-sm"><a href="<?php $this->author->permalink(); ?>" rel="author"><?php $this->author(); ?></a></p>
                <p class="text-xs text-gray-400">
                    <time datetime="<?php $this->date('c'); ?>" itemprop="datePublished"><?php $this->date('F j, Y'); ?></time>
                    <span> · <?php echo get_reading_time($this->content); ?></span>
                </p>
            </div>
            <div class="flex-shrink-0">
                <a href="#comments" data-tooltip-target="tooltip-no-arrow" class="cursor-pointer">
                    <svg class="w-4 h-4 text-gray-600 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 18">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5h9M5 9h5m8-8H2a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h4l3.5 4 3.5-4h5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1Z"></path>
                    </svg>
                </a>
                <div id="tooltip-no-arrow" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                    查看评论
                </div>
            </div>
        </div>

        <!-- inject:css -->
        <link rel="stylesheet" href="<?php $this->options->themeUrl('assets/prism/atom-dark.css'); ?>" />
        <article class="markdown-body" itemprop="articleBody" id="markdown-content"><?php $this->content(); ?></article>
        <!-- inject:js -->

        <!-- 标签 -->
        <div itemprop="flex mt-6" class="tags">
            <?php
            $tags = $this->tags;
            if ($tags) {
                foreach ($tags as $tag) {
                    echo '<a class="hvr-underline-from-center mr-3 py-2 px-3 md:p-0 dark:text-white hover:bg-gray-50 md:hover:bg-transparent dark:hover:bg-gray-700" href="' . $tag['permalink'] . '">' . '#' . $tag['name'] . '</a>';
                }
            }
            ?>
        </div>
    </div>

    <hr class="w-48 h-1 mx-auto my-4 bg-gray-100 border-0 rounded md:my-10 dark:bg-gray-700">

    <?php $this->need('comments.php'); ?>

    <div class="inline-flex items-center justify-center w-full">
        <hr class="w-64 h-px my-8 bg-gray-200 border-0 dark:bg-gray-700">
        <span class="absolute px-3 font-medium text-gray-900 -translate-x-1/2 bg-white left-1/2 dark:text-white dark:bg-gray-900">更早些的文章</span>
    </div>

    <?php
    $previousArticles = getPreviousArticles($this, 5);  // 获取前 5 篇文章
    if (!empty($previousArticles)) {
        foreach ($previousArticles as $article) {
    ?>
            <article class="mb-8" itemscope itemtype="http://schema.org/BlogPosting">
                <a class="block mb-8" itemprop="url" href="<?php echo htmlspecialchars($article['link']); ?>">
                    <h2 class="flex pb-3 font-bold align-center" itemprop="name headline">
                        <img class="flex-shrink-0 w-[22px] h-[22px] inline-block rounded mr-2" src="<?php echo getFirstImageSrc($article['content']); ?>" />
                        <span class="flex-grow"><?php echo htmlspecialchars($article['title']); ?></span>
                    </h2>
                    <div class="w-full post-content hvr-forward bg-gray-100 cursor-pointer p-4 rounded-tl-lg rounded-tr-xl rounded-br-xl rounded-bl-xl" itemprop="articleBody">
                        <?php
                        // 显示文章内容的摘要，最多 200 字符
                        $content = strip_tags($article['content']); // 去除 HTML 标签
                        echo mb_strlen($content) > 200 ? mb_substr($content, 0, 200, 'UTF-8') . '...' : $content;
                        ?>
                    </div>
                </a>
            </article>
    <?php
        }
    } else {
        echo '<p class="text-center text-gray-400">没有更早的文章了...</p>';
    }
    ?>
</div>