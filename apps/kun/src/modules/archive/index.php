<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

<div class="mx-auto max-w-[560px]">
    <h3 class="text-center text-black text-opacity-80 mt-6 mb-12"><?php $this->archiveTitle([
                                                                'category' => _t('分类 %s 下的文章'),
                                                                'search'   => _t('包含关键字 %s 的文章'),
                                                                'tag'      => _t('标签 %s 下的文章'),
                                                                'author'   => _t('%s 发布的文章')
                                                            ], '', ''); ?></h3>
    <?php if ($this->have()) : ?>
        <?php while ($this->next()) : ?>
            <article itemscope itemtype="http://schema.org/BlogPosting">
                <a itemprop="url" href="<?php $this->permalink() ?>">
                    <h2 class="pb-3 font-bold flex items-center" itemprop="name headline">
                        <img class="inline-block w-[22px] h-[22px] rounded mr-2" src="<?php echo getFirstImageSrc($this->content) ?>" />
                        <span><?php $this->title() ?>
                </a>
                </h2>
                <div class="post-content hvr-forward bg-gray-100 cursor-pointer p-4 rounded-tl-lg rounded-tr-xl rounded-br-xl rounded-bl-xl" itemprop="articleBody">
                    <?php echo mb_strlen($this->content) > 200 ? mb_substr(strip_tags($this->content), 0, 200, 'UTF-8') . '...' : strip_tags($this->content); ?>
                </div>
                </span>
            </article>
        <?php endwhile; ?>
    <?php else : ?>
        <article class="post">
            <h2 class="post-title"><?php _e('没有找到内容'); ?></h2>
        </article>
    <?php endif; ?>

    <?php $this->pageNav('&laquo; 前一页', '后一页 &raquo;'); ?>
</div><!-- end #main -->

<!-- inject:js -->