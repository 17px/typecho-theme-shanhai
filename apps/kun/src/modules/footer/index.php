<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

<footer class="mx-auto pt-20 pb-2 <?php $this->options->viewWidth() ?>" role="contentinfo">
    <div class="w-full mx-auto max-w-screen-xl px-4 flex justify-between items-center">
        <div class="flex items-center text-xs text-zinc-700 dark:text-zinc-400">© <?php echo date('Y'); ?>
            <a href="<?php $this->options->siteUrl(); ?>" class="pl-2"><?php $this->options->title(); ?></a>
        </div>
        <ul class="flex flex-wrap gap-2 items-center">
            <li>
                <a href="mailto:<?php echo $this->author('mail'); ?>" class="hidden sm:inline-flex items-center justify-center w-10 h-10 text-zinc-700 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-700 focus:outline-none focus:ring-4 focus:ring-zinc-200 dark:focus:ring-zinc-700 rounded-lg text-sm">
                    <svg class="w-[1rem] h-[1rem]" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                        <path fill="none" d="M0 0h24v24H0z"></path>
                        <path d="M22 8.98V18c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2l.01-12c0-1.1.89-2 1.99-2h10.1c-.06.32-.1.66-.1 1s.04.68.1 1H4l8 5 3.67-2.29c.47.43 1.02.76 1.63.98L12 13 4 8v10h16V9.9c.74-.15 1.42-.48 2-.92zM16 5c0 1.66 1.34 3 3 3s3-1.34 3-3-1.34-3-3-3-3 1.34-3 3z"></path>
                    </svg>
                </a>
            </li>
            <?php if ($this->options->icp && in_array('ShowICP', $this->options->moreConfig)) : ?>
                <li>
                    <a href="https://beian.miit.gov.cn" target="_blank" class="flex items-center text-xs text-zinc-700 dark:text-zinc-400"><?php $this->options->icp() ?></a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</footer>

<?php $this->footer(); ?>
</body>

</html>

<!-- inject:js -->