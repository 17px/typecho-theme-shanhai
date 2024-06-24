<?php

/**
 * RSS 2.0 订阅模板
 *
 * @package custom
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
?>


<div class="pt-20 mx-auto <?php $this->options->viewWidth() ?>">
    <div class="row">
        <ul>
            <?php
            foreach ($this->fields as $name => $value) {
                echo "<li>" . htmlspecialchars($name) . ": " . htmlspecialchars($value) . "</li>";
            }
            ?>
        </ul>
    </div>
</div>

<script>
    <?php

    // 示例用法
    $rssUrls = ["http://localhost/feed", "https://demo.ghost.io/author/lewis/rss/"];
    // $rssUrls = array_filter(array_map('trim', preg_split('/\r?\n/', $this->content)));
    $jsonResult = fetchRssFeeds($rssUrls);

    ?>

    console.log(<?php echo $jsonResult ?>)
</script>

<!-- inject:js -->