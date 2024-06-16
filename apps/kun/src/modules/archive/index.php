<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

<div class="pt-20 mx-auto <?php $this->options->viewWidth() ?>">
    <h3 class="text-black dark:text-zinc-200 text-opacity-80 pb-2"><?php $this->archiveTitle([
                                                                        'category' => _t('分类 「%s」 下的文章'),
                                                                        'search'   => _t('包含关键字 「%s」 的文章'),
                                                                        'tag'      => _t('标签 「%s」 下的文章'),
                                                                        'author'   => _t('「%s」 发布的文章')
                                                                    ], '', ''); ?></h3>

    <p class="break-all pb-12 text-sm text-gray-500"><?php echo $this->getDescription(); ?></p>

    <?php if ($this->have()) : ?>
        <?php while ($this->next()) : ?>
            <article class="posts-in-category mb-8" itemscope itemtype="http://schema.org/BlogPosting">
                <a class="block mb-8 hvr-shrink" itemprop="url" href="<?php $this->permalink() ?>">
                    <h2 class="pb-3 font-bold text-black dark:text-zinc-200" itemprop="name headline">
                        <img data-title="<?php $this->title() ?>" class="flex-shrink-0 w-[20px] bg-gray-100 p-1 h-[20px] inline-block rounded" />
                        <span class="align-middle"><?php $this->title() ?></span>
                    </h2>
                    <div class="tracking-wider w-full post-content bg-gray-100 dark:bg-zinc-800 cursor-pointer p-4 rounded-tl-lg rounded-tr-2xl rounded-br-2xl rounded-bl-2xl" itemprop="articleBody">
                        <p class="text-sm text-zinc-700 dark:text-zinc-400"><?php echo mb_strlen($this->content) > 140 ? mb_substr(strip_tags($this->content), 0, 140, 'UTF-8') . '...' : strip_tags($this->content); ?></p>
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
    <?php else : ?>
        <article class="my-12">
            <h2 class="text-center"><?php _e('没有找到内容'); ?></h2>
        </article>
    <?php endif; ?>

    <?php $this->pageNav('&laquo; 前一页', '后一页 &raquo;'); ?>
</div>

<?php $this->need('footer.php'); ?>

<!-- inject:js -->