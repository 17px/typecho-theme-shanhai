<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
?>

<!-- inject:css -->

<link rel="stylesheet" href="<?php $this->options->themeUrl('assets/markdown/' . $this->options->markdownTheme . '.css'); ?>" />
<link rel="stylesheet" href="<?php $this->options->themeUrl('assets/prism/' . $this->options->prismTheme . '.css'); ?>" />
<?php if (in_array('UseKatex', $this->options->moreConfig)) : ?>
  <link rel="stylesheet" href="<?php $this->options->themeUrl('assets/katex/katex.min.css'); ?>" />
<?php endif; ?>

<div class="pt-10 mx-auto <?php $this->options->viewWidth() ?>">
  <article id="markdown-content" class="markdown-body mb-4" itemscope itemtype="http://schema.org/BlogPosting">
    <?php $this->content(); ?>
  </article>
  <?php $this->need('comments.php'); ?>
</div>

<?php if (in_array('UseKatex', $this->options->moreConfig)) : ?>
  <script defer src="<?php $this->options->themeUrl('assets/katex/katex.min.js'); ?>"></script>
  <script defer src="<?php $this->options->themeUrl('assets/katex/auto.render.min.js'); ?>" onload="renderMathInElement(document.querySelector('.markdown-body'))"></script>
<?php endif; ?>

<!-- inject:js -->