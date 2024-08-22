<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
?>

<!-- inject:css -->

<div class="pt-10 mx-auto <?php $this->options->viewWidth() ?>">
  <article class="markdown-body mb-4" itemscope itemtype="http://schema.org/BlogPosting">
    <h1 class="post-title" itemprop="name headline">
      <a itemprop="url"
        href="<?php $this->permalink() ?>"><?php $this->title() ?></a>
    </h1>
    <div class="post-content" itemprop="articleBody">
      <?php $this->content(); ?>
    </div>
  </article>
  <?php $this->need('comments.php'); ?>
</div>

<!-- inject:js -->