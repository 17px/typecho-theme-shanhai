<?php

/**
 * 留言
 *
 * @package custom
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
?>

<!-- inject:css -->

<div class="pt-20 mx-auto <?php $this->options->viewWidth() ?>">
    <article class="markdown-body"><?php $this->content() ?></article>
    <div id="comments-hr" class="pt-[52px] mt-[-52px]">
        <hr class="w-48 h-1 mx-auto bg-zinc-100 border-0 rounded md:my-10 dark:bg-zinc-700">
    </div>

    <?php $this->need('comments.php'); ?>
</div>


<!-- inject:js -->