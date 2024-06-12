<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>


<div class="mx-auto max-w-[560px] pb-4">
    <!-- 作者 -->
    <div class="pt-3 flex justify-between items-center">
        <img class="w-[32px] h-[32px] rounded-lg flex-shrink-0" src="<?php echo getGravatar($this->author->mail); ?>" alt="<?php $this->author(); ?>" />
        <div class="flex-grow pl-3">
            <p class="text-sm"><a href="<?php $this->author->permalink(); ?>" rel="author"><?php $this->author(); ?></a></p>
            <p class="text-xs text-gray-400">
                <time datetime="<?php $this->date('c'); ?>" itemprop="datePublished"><?php $this->date('F j, Y'); ?></time>
                <span> · <?php echo get_reading_time($this->content); ?></span>
            </p>
        </div>
        <ul class="flex-shrink-0 flex">
            <li>
                <a href="#comments-hr" data-tooltip-target="tooltip-comment" data-tooltip-placement="bottom" class="hidden sm:inline-flex items-center justify-center text-gray-500 w-10 h-10 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5 mr-1">
                    <svg class="w-[1.1rem] h-[1.1rem]" aria-hidden="true" class="w-4 h-4 text-gray-600 dark:text-white" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                        <path d="M144 208c-17.7 0-32 14.3-32 32s14.3 32 32 32 32-14.3 32-32-14.3-32-32-32zm112 0c-17.7 0-32 14.3-32 32s14.3 32 32 32 32-14.3 32-32-14.3-32-32-32zm112 0c-17.7 0-32 14.3-32 32s14.3 32 32 32 32-14.3 32-32-14.3-32-32-32zM256 32C114.6 32 0 125.1 0 240c0 47.6 19.9 91.2 52.9 126.3C38 405.7 7 439.1 6.5 439.5c-6.6 7-8.4 17.2-4.6 26S14.4 480 24 480c61.5 0 110-25.7 139.1-46.3C192 442.8 223.2 448 256 448c141.4 0 256-93.1 256-208S397.4 32 256 32zm0 368c-26.7 0-53.1-4.1-78.4-12.1l-22.7-7.2-19.5 13.8c-14.3 10.1-33.9 21.4-57.5 29 7.3-12.1 14.4-25.7 19.9-40.2l10.6-28.1-20.6-21.8C69.7 314.1 48 282.2 48 240c0-88.2 93.3-160 208-160s208 71.8 208 160-93.3 160-208 160z"></path>
                    </svg>
                </a>
                <div id="tooltip-comment" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                    查看评论
                </div>
            </li>
        </ul>
    </div>

    <!-- 标题 -->
    <h1 class="pt-12 text-black text-[24px] text-center"><?php $this->title() ?></h1>

    <!-- 文章 -->
    <?php if ($this->hidden || $this->titleshow) : ?>
        <!--lock post-->
        <form class="pt-12" action="<?php echo Typecho_Widget::widget('Widget_Security')->getTokenUrl($v['permalink']) ?>" method="post">
            <label for="password" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">请输入密码访问</label>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-3.5 h-3.5 text-gray-500 dark:text-gray-400" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                        <g fill="none">
                            <path d="M0 0h24v24H0V0z"></path>
                            <path d="M0 0h24v24H0V0z" opacity=".87"></path>
                        </g>
                        <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zM9 6c0-1.66 1.34-3 3-3s3 1.34 3 3v2H9V6zm9 14H6V10h12v10zm-6-3c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2z"></path>
                    </svg>
                </div>
                <input type="password" name="protectPassword" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="请输入密码" required type="password">
                <input type="hidden" name="protectCID" value="<?php $this->cid(); ?>" />
                <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">提交</button>
            </div>
        </form>
    <?php else : ?>
        <!-- unlock post content -->
        <div class="mt-3 mb-8" itemscope itemtype="http://schema.org/BlogPosting">

            <!-- 分割线 -->
            <div class="inline-flex items-center justify-center w-full">
                <hr class="w-64 h-1 my-8 bg-gray-200 border-0 rounded dark:bg-gray-700">
                <div class="absolute px-4 -translate-x-1/2 bg-white left-1/2 dark:bg-gray-900">
                    <svg class="w-4 h-4 text-gray-700 dark:text-gray-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 14">
                        <path d="M6 0H2a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h4v1a3 3 0 0 1-3 3H2a1 1 0 0 0 0 2h1a5.006 5.006 0 0 0 5-5V2a2 2 0 0 0-2-2Zm10 0h-4a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h4v1a3 3 0 0 1-3 3h-1a1 1 0 0 0 0 2h1a5.006 5.006 0 0 0 5-5V2a2 2 0 0 0-2-2Z" />
                    </svg>
                </div>
            </div>

            <!-- inject:css -->
            <link rel="stylesheet" href="<?php $this->options->themeUrl('assets/prism/atom-dark.css'); ?>" />
            <article class="markdown-body" itemprop="articleBody" id="markdown-content"><?php $this->content(); ?></article>
            <!-- inject:js -->

            <!-- 标签 -->
            <div class="pt-6">
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

        <div id="comments-hr" class="pt-[52px] mt-[-52px]">
            <hr class="w-48 h-1 mx-auto bg-gray-100 border-0 rounded md:my-10 dark:bg-gray-700">
        </div>

        <?php $this->need('comments.php'); ?>

    <?php endif; ?>

    <div class="inline-flex items-center justify-center w-full my-8">
        <hr class="w-64 h-px my-8 bg-gray-200 border-0 dark:bg-gray-700">
        <span class="absolute px-3 font-medium text-gray-900 -translate-x-1/2 bg-white left-1/2 dark:text-white dark:bg-gray-900">往昔笔砚</span>
    </div>

    <!-- recommend -->
    <?php
    $previousArticles = getPreviousArticles($this, 5);  // 获取前 5 篇文章
    if (!empty($previousArticles)) {
        foreach ($previousArticles as $article) {
    ?>
            <article class="posts-recommend mb-8" itemscope itemtype="http://schema.org/BlogPosting">
                <a class="block mb-8" itemprop="url" href="<?php echo htmlspecialchars($article['link']); ?>">
                    <h2 class="pb-3 font-bold text-black" itemprop="name headline">
                        <img data-title="<?php echo htmlspecialchars($article['title']); ?>" class="flex-shrink-0 w-[20px] bg-gray-100 p-1 h-[20px] inline-block rounded" />
                        <span class="align-middle"><?php echo htmlspecialchars($article['title']); ?></span>
                    </h2>
                    <div class="tracking-wider w-full post-content hvr-forward bg-neutral-100 cursor-pointer p-4 rounded-tl-lg rounded-tr-xl rounded-br-xl rounded-bl-xl" itemprop="articleBody">
                        <?php
                        // 显示文章内容的摘要，最多 140 字符
                        $content = strip_tags($article['content']); // 去除 HTML 标签
                        echo mb_strlen($content) > 140 ? mb_substr($content, 0, 140, 'UTF-8') . '...' : $content;
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