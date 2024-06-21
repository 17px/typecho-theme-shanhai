<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

<div id="post-container" class="pt-20 px-5 mx-auto <?php $this->options->viewWidth() ?> pb-4">

    <!-- 作者 -->
    <div class="pb-3 text-center animate-fade-in-up">
        <div class="text-center">
            <p class="text-xs text-zinc-400">
                「<a href="<?php $this->author->permalink(); ?>" rel="author"><?php $this->author(); ?></a>」
                <time class="mr-2" datetime="<?php $this->date('c'); ?>" itemprop="datePublished"><?php $this->date("F j, Y, g:i a"); ?></time>
            </p>
        </div>
    </div>

    <!-- 标题 -->
    <h1 class="text-black dark:text-zinc-100 text-2xl text-center animate-fade-in-up"><?php $this->title() ?></h1>

    <!-- 文章 -->
    <?php if ($this->hidden || $this->titleshow) : ?>
        <!--lock post-->
        <form class="pt-12" action="<?php echo Typecho_Widget::widget('Widget_Security')->getTokenUrl($v['permalink']) ?>" method="post">
            <label for="password" class="mb-2 text-sm font-medium text-zinc-900 sr-only dark:text-white">请输入密码访问</label>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-3.5 h-3.5 text-zinc-500 dark:text-zinc-400" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                        <g fill="none">
                            <path d="M0 0h24v24H0V0z"></path>
                            <path d="M0 0h24v24H0V0z" opacity=".87"></path>
                        </g>
                        <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zM9 6c0-1.66 1.34-3 3-3s3 1.34 3 3v2H9V6zm9 14H6V10h12v10zm-6-3c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2z"></path>
                    </svg>
                </div>
                <input type="password" name="protectPassword" class="block w-full p-4 ps-10 text-sm text-zinc-900 border border-zinc-300 rounded-lg bg-zinc-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="请输入密码" required type="password">
                <input type="hidden" name="protectCID" value="<?php $this->cid(); ?>" />
                <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">提交</button>
            </div>
        </form>
    <?php else : ?>
        <!-- unlock post content -->
        <div class="mb-8 pt-10" itemscope itemtype="http://schema.org/BlogPosting">

            <link rel="stylesheet" href="<?php $this->options->themeUrl('assets/markdown/' . $this->options->markdownTheme . '.css'); ?>" />
            <link rel="stylesheet" href="<?php $this->options->themeUrl('assets/prism/' . $this->options->prismTheme . '.css'); ?>" />
            <!-- inject:css -->
            <article class="markdown-body bg-white dark:bg-zinc-900 animate-fade-in-up" itemprop="articleBody" id="markdown-content"><?php $this->content(); ?></article>

            <!-- 标签 -->
            <div class="pt-6 flex flex-wrap gap-2">
                <?php
                $tags = $this->tags;
                if ($tags) {
                    foreach ($tags as $tag) {
                        echo '<a class="text-xs bg-zinc-100 rounded-full px-2 py-0.5" href="' . $tag['permalink'] . '">' . '#' . $tag['name'] . '</a>';
                    }
                }
                ?>
            </div>
        </div>

        <?php $this->need('comments.php'); ?>

    <?php endif; ?>

    <?php if (in_array('ShowFastBar', $this->options->moreConfig)) : ?>
        <ul id="fast-bar" class="fixed bottom-2 z-[1994] border bg-white/90 backdrop-blur-sm hidden rounded-full left-1/2 -translate-x-1/2 justify-center dark:bg-zinc-800/90 dark:border-zinc-700">
            <li>
                <a href="<?php echo getAdjacentArticle($this, 'prev')['url'] ?>" data-tooltip-target="prev-post" data-tooltip-placement="bottom" class=" inline-flex items-center justify-center text-zinc-500 w-10 h-10 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-700 focus:outline-none focus:ring-4 focus:ring-zinc-200 dark:focus:ring-zinc-700 rounded-full text-sm p-2.5">
                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                        <path fill="none" d="M0 0h24v24H0z"></path>
                        <path d="m9 19 1.41-1.41L5.83 13H22v-2H5.83l4.59-4.59L9 5l-7 7 7 7z"></path>
                    </svg>
                </a>
                <div id="prev-post" role="tooltip" class="whitespace-nowrap  absolute z-10 invisible inline-block px-2 py-2 text-sm font-medium text-zinc-900 bg-white border border-zinc-200  rounded-lg shadow-sm opacity-0 tooltip">
                    <span class="mr-2">上一篇</span>
                    <kbd class="px-2 py-1 text-sm text-zinc-800 bg-zinc-100 border border-zinc-200 rounded"><?php echo getPlatformKey() ?></kbd>
                    <kbd class="px-2 py-1 text-sm text-zinc-800 bg-zinc-100 border border-zinc-200 rounded">←</kbd>
                    <p class="pt-2 text-xs text-zinc-500"><?php echo getAdjacentArticle($this, 'prev')['title'] ?></p>
                </div>
            </li>
            <li>
                <button data-dropdown-toggle="toc-dropdown" data-tooltip-target="tooltip-toc" data-tooltip-placement="bottom" class=" inline-flex items-center justify-center text-zinc-500 w-10 h-10 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-700 focus:outline-none focus:ring-4 focus:ring-zinc-200 dark:focus:ring-zinc-700 rounded-full text-sm p-2.5">
                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                        <path fill="none" d="M0 0h24v24H0V0z"></path>
                        <path d="M18 17h2v.5h-1v1h1v.5h-2v1h3v-4h-3v1zm1-9h1V4h-2v1h1v3zm-1 3h1.8L18 13.1v.9h3v-1h-1.8l1.8-2.1V10h-3v1zM2 5h14v2H2V5zm0 12h14v2H2v-2zm0-6h14v2H2v-2z"></path>
                    </svg>
                </button>
                <div id="tooltip-toc" role="tooltip" class="whitespace-nowrap absolute z-10 invisible inline-block px-2 py-2 text-sm font-medium text-zinc-900 bg-white border border-zinc-200 rounded-lg shadow-sm opacity-0 tooltip">
                    <span class="mr-2">显示目录</span>
                    <kbd class="px-2 py-1 text-sm  text-zinc-800 bg-zinc-100 border border-zinc-200 rounded">]</kbd>
                </div>
                <!-- 目录 -->
                <div id="toc-dropdown" class="z-10 hidden bg-white/95 backdrop-blur-sm rounded-lg border w-52 dark:bg-zinc-800/95 dark:border-zinc-700"></div>
            </li>
            <li>
                <a href="#comments-hr" data-tooltip-target="tooltip-comment" data-tooltip-placement="bottom" class=" inline-flex items-center justify-center text-zinc-500 w-10 h-10 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-700 focus:outline-none focus:ring-4 focus:ring-zinc-200 dark:focus:ring-zinc-700 rounded-full text-sm p-2.5">
                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                        <path fill="none" d="M0 0h24v24H0V0z"></path>
                        <path d="M21.99 4c0-1.1-.89-2-1.99-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h14l4 4-.01-18zM20 4v13.17L18.83 16H4V4h16zM6 12h12v2H6zm0-3h12v2H6zm0-3h12v2H6z"></path>
                    </svg>
                </a>
                <div id="tooltip-comment" role="tooltip" class="whitespace-nowrap absolute z-10 invisible inline-block px-2 py-2 text-sm font-medium text-zinc-900 bg-white border border-zinc-200  rounded-lg shadow-sm opacity-0 tooltip">
                    <span class="mr-2">看评论</span>
                    <kbd class="px-2 py-1 text-sm text-zinc-800 bg-zinc-100 border border-zinc-200 rounded"><?php echo getPlatformKey() ?></kbd>
                    <kbd class="px-2 py-1 text-sm text-zinc-800 bg-zinc-100 border border-zinc-200 rounded">P</kbd>
                </div>
            </li>
            <li>
                <a href="<?php echo getAdjacentArticle($this, 'next')['url'] ?>" data-tooltip-target="next-post" data-tooltip-placement="bottom" class=" inline-flex items-center justify-center text-zinc-500 w-10 h-10 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-700 focus:outline-none focus:ring-4 focus:ring-zinc-200 dark:focus:ring-zinc-700 rounded-full text-sm p-2.5">
                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                        <path fill="none" d="M0 0h24v24H0z"></path>
                        <path d="m15 5-1.41 1.41L18.17 11H2v2h16.17l-4.59 4.59L15 19l7-7-7-7z"></path>
                    </svg>
                </a>
                <div id="next-post" role="tooltip" class="whitespace-nowrap absolute z-10 invisible inline-block px-2 py-2 text-sm font-medium text-zinc-900 bg-white border border-zinc-200  rounded-lg shadow-sm opacity-0 tooltip">
                    <span class="mr-2">下一篇</span>
                    <kbd class="px-2 py-1 text-sm text-zinc-800 bg-zinc-100 border border-zinc-200 rounded"><?php echo getPlatformKey() ?></kbd>
                    <kbd class="px-2 py-1 text-sm text-zinc-800 bg-zinc-100 border border-zinc-200 rounded">→</kbd>
                    <p class="pt-2 text-xs text-zinc-500"><?php echo getAdjacentArticle($this, 'next')['title'] ?></p>
                </div>
            </li>
        </ul>
    <?php endif; ?>

    <!-- inject:js -->

</div>