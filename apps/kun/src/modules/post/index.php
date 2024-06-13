<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

<!-- pt-[52px] mt-[-52px] -->
<div id="post-container" class="pt-20 mx-auto <?php $this->options->viewWidth() ?> pb-4">
    <!-- 标题 -->
    <h1 class="text-black text-2xl"><?php $this->title() ?></h1>

    <!-- 作者 -->
    <div class="pt-3 flex justify-between items-center">
        <img class="w-[32px] h-[32px] rounded-lg flex-shrink-0" src="<?php echo getGravatar($this->author->mail); ?>" alt="<?php $this->author(); ?>" />
        <div class="flex-grow pl-3">
            <p class="text-sm"><a href="<?php $this->author->permalink(); ?>" rel="author"><?php $this->author(); ?></a></p>
            <p class="text-xs text-gray-400">
                <time class="mr-2" datetime="<?php $this->date('c'); ?>" itemprop="datePublished"><?php $this->date('F j, Y'); ?></time>
                <span>阅读 <?php get_post_view($this) ?></span>
            </p>
        </div>
        <ul class="flex-shrink-0 flex">
            <li>
                <button id="toggle-toc" data-tooltip-target="tooltip-toc" data-tooltip-placement="bottom" class="hidden sm:inline-flex items-center justify-center text-gray-500 w-10 h-10 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5 mr-1 invisible">
                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 448 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                        <path d="M448 64c0 17.7-14.3 32-32 32H192c-17.7 0-32-14.3-32-32s14.3-32 32-32H416c17.7 0 32 14.3 32 32zm0 256c0 17.7-14.3 32-32 32H192c-17.7 0-32-14.3-32-32s14.3-32 32-32H416c17.7 0 32 14.3 32 32zM0 192c0-17.7 14.3-32 32-32H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32zM448 448c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H416c17.7 0 32 14.3 32 32z"></path>
                    </svg>
                </button>
                <div id="tooltip-toc" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                    <span class="mr-2">显示目录</span>
                    <kbd class="px-2 py-1 text-xs font-semibold text-white bg-black border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-100 dark:border-gray-500">]</kbd>
                </div>
            </li>
            <li>
                <a href="#comments-hr" data-tooltip-target="tooltip-comment" data-tooltip-placement="bottom" class="hidden sm:inline-flex items-center justify-center text-gray-500 w-10 h-10 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5">
                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                        <path d="M168.2 384.9c-15-5.4-31.7-3.1-44.6 6.4c-8.2 6-22.3 14.8-39.4 22.7c5.6-14.7 9.9-31.3 11.3-49.4c1-12.9-3.3-25.7-11.8-35.5C60.4 302.8 48 272 48 240c0-79.5 83.3-160 208-160s208 80.5 208 160s-83.3 160-208 160c-31.6 0-61.3-5.5-87.8-15.1zM26.3 423.8c-1.6 2.7-3.3 5.4-5.1 8.1l-.3 .5c-1.6 2.3-3.2 4.6-4.8 6.9c-3.5 4.7-7.3 9.3-11.3 13.5c-4.6 4.6-5.9 11.4-3.4 17.4c2.5 6 8.3 9.9 14.8 9.9c5.1 0 10.2-.3 15.3-.8l.7-.1c4.4-.5 8.8-1.1 13.2-1.9c.8-.1 1.6-.3 2.4-.5c17.8-3.5 34.9-9.5 50.1-16.1c22.9-10 42.4-21.9 54.3-30.6c31.8 11.5 67 17.9 104.1 17.9c141.4 0 256-93.1 256-208S397.4 32 256 32S0 125.1 0 240c0 45.1 17.7 86.8 47.7 120.9c-1.9 24.5-11.4 46.3-21.4 62.9zM144 272a32 32 0 1 0 0-64 32 32 0 1 0 0 64zm144-32a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zm80 32a32 32 0 1 0 0-64 32 32 0 1 0 0 64z"></path>
                    </svg>
                </a>
                <div id="tooltip-comment" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                    <span class="mr-2">看评论</span>
                    <kbd class="px-2 py-1 text-xs font-semibold text-white bg-black border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-100 dark:border-gray-500"><?php echo getPlatformKey() ?></kbd> + <kbd class="px-2 py-1 text-xs font-semibold text-white bg-black border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-100 dark:border-gray-500">k</kbd>
                </div>
            </li>
        </ul>
    </div>

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
        <div class="mb-8" itemscope itemtype="http://schema.org/BlogPosting">

            <!-- 分割线 -->
            <div class="inline-flex items-center justify-center w-full">
                <hr class="w-64 h-1 my-8 bg-gray-200 border-0 rounded dark:bg-gray-700">
                <div class="absolute px-4 -translate-x-1/2 bg-white left-1/2 dark:bg-gray-900">
                    <svg class="w-4 h-4 text-gray-700 dark:text-gray-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 14">
                        <path d="M6 0H2a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h4v1a3 3 0 0 1-3 3H2a1 1 0 0 0 0 2h1a5.006 5.006 0 0 0 5-5V2a2 2 0 0 0-2-2Zm10 0h-4a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h4v1a3 3 0 0 1-3 3h-1a1 1 0 0 0 0 2h1a5.006 5.006 0 0 0 5-5V2a2 2 0 0 0-2-2Z" />
                    </svg>
                </div>
            </div>

            <link rel="stylesheet" href="<?php $this->options->themeUrl('assets/markdown/' . $this->options->markdownTheme . '.css'); ?>" />
            <link rel="stylesheet" href="<?php $this->options->themeUrl('assets/prism/' . $this->options->prismTheme . '.css'); ?>" />
            <!-- inject:css -->
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