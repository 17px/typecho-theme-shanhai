<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

<footer class="mx-auto max-w-[560px] dark:bg-gray-800" role="contentinfo">
    <div class="w-full mx-auto max-w-screen-xl p-2 md:flex md:items-center md:justify-between">
        <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© <?php echo date('Y'); ?> <a href="<?php $this->options->siteUrl(); ?>" class="hover:underline"><?php $this->options->title(); ?></a> 保留所有权利
        </span>
        <?php if ($this->options->moreConfig && in_array('ShowThemeAuthor', $this->options->moreConfig)) : ?>
            <ul class="flex flex-wrap items-center mt-3 text-xs font-medium text-gray-500 dark:text-gray-400 sm:mt-0">
                <li>
                    <a href="https://maxshader.com" class="hover:underline">Theme By 陈不渡</a>
                </li>
            </ul>
        <?php endif; ?>

    </div>
</footer>

<?php $this->footer(); ?>
</body>

</html>

<!-- inject:js -->