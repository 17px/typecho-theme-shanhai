<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

<?php function threadedComments($comments, $options)
{ ?>
  <li id="<?php $comments->theId(); ?>">
    <div class="mb-8" id="<?php $comments->theId(); ?>">
      <div class="pb-3 comment-author flex items-center">
        <section class="text-sm text-blue-800 dark:text-blue-300"><?php $comments->author(); ?>
          <?php if ($comments->authorId == $comments->ownerId) : ?>
            <span class="bg-blue-100 text-blue-800 text-xs font-medium p-1 rounded dark:bg-blue-900 dark:text-blue-300">作者</span>
          <?php endif; ?>
          <?php $author = getCommentDetails($comments->parent); ?>
          <?php if (!empty($author)) : ?>
            <span class="text-xs px-2 text-zinc-400">回复了</span>
            <span data-reply-id="comment-<?php echo $comments->parent ?>" class="cursor-pointer reply-user text-blue-800 dark:text-blue-300"><?php echo $author; ?></span>
          <?php endif; ?>
        </section>
      </div>
      <div class="p-4 py-3 tracking-wider w-full bg-gray-100 dark:bg-zinc-800 rounded-tl-lg rounded-tr-2xl rounded-br-2xl rounded-bl-2xl">
        <?php if ($comments->status === "waiting") : ?>
          <em class="waiting">评论审核中...</em>
        <?php elseif ($comments->status === "approved") : ?>
          <article id="comment-content"><?php $comments->content(); ?></article>
          <div class="pt-3 text-xs text-zinc-500 flex items-center justify-between">
            <time class="mr-3" datetime="2024-06-11T09:20:00+00:00" itemprop="datePublished"><?php $comments->date('F j, Y H:i'); ?></time>
            <div>
              <span class="inline-flex items-center"><?php $comments->reply(); ?></span>
            </div>
          </div>
        <?php else : ?>
          <em class="waiting">垃圾评论 or 被删除</em>
        <?php endif; ?>
      </div>
    </div>
    <?php if ($comments->children) { ?>
      <div class="comment-children">
        <?php $comments->threadedComments($options); ?>
      </div>
    <?php } ?>
  </li>
<?php } ?>


<!-- inject:css -->
<div id="comments" class="pb-20">

  <div id="comments-hr"  >
    <hr class="w-48 m-10 h-1 mx-auto bg-zinc-100 border-0 rounded dark:bg-zinc-700">
  </div>



  <?php $this->comments()->to($comments); ?>
  <?php if ($comments->have()) : ?>
    <h3 class="text-center mb-4"><?php $this->commentsNum(_t('暂无评论'), _t('仅有一条评论'), _t('已有 %d 条评论')); ?></h3>

    <?php $comments->listComments(); ?>

    <?php
    $comments->pageNav(
      '<svg class="w-3.5 h-3.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5H1m0 0 4 4M1 5l4-4"/></svg>',
      '<svg class="w-3.5 h-3.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/></svg>',
      1,
      '...',
      array(
        'wrapTag' => 'ul',
        'wrapClass' => 'pagination',
        'itemTag' => 'li',
        'textTag' => 'a',
        'currentClass' => 'active',
        'prevClass' => 'prev',
        'nextClass' => 'next'
      )
    );
    ?>

  <?php endif; ?>

  <?php if ($this->allow('comment')) : ?>
    <div id="<?php $this->respondId(); ?>" class="pt-8">
      <div class="cancel-comment-reply">
        <?php $comments->cancelReply('<button type="button" class="py-1.5 px-3 me-2 mb-2 text-sm font-medium text-zinc-900 focus:outline-none bg-white rounded-lg border border-zinc-200 hover:bg-zinc-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-zinc-100 dark:focus:ring-zinc-700 dark:bg-zinc-800 dark:text-zinc-400 dark:border-zinc-600 dark:hover:text-white dark:hover:bg-zinc-700">取消回复</button>'); ?>
      </div>
      <form method="post" action="<?php $this->commentUrl() ?>" id="comment-form" role="form">
        <?php if (!$this->user->hasLogin()) : ?>
          <div class="flex align-center gap-3 pb-3">
            <div class="flex-1">
              <input for="author" autocomplete="off" type="text" name="author" value="<?php $this->remember('author'); ?>" required placeholder="<?php _e('称呼'); ?>" class="border border-zinc-300 text-zinc-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 bg-transparent dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
            </div>
            <div class="flex-1">
              <input id="mail" autocomplete="off" value="<?php $this->remember('mail'); ?>" <?php if ($this->options->commentsRequireMail) : ?> required<?php endif; ?> placeholder="<?php _e('邮箱'); ?>" type="email" name="mail" class="bg-transparent border border-zinc-300 text-zinc-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
            </div>
            <div class="flex-1">
              <input type="url" id="url" name="url" autocomplete="off" placeholder="<?php _e('http://'); ?>" value="<?php $this->remember('url'); ?>" <?php if ($this->options->commentsRequireURL) : ?> required<?php endif; ?> class="bg-transparent border border-zinc-300 text-zinc-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
            </div>
          </div>
        <?php endif; ?>
        <div class="w-full mb-4 border border-zinc-200 rounded-lg bg-zinc-50 dark:bg-zinc-700 dark:border-zinc-600">
          <div class="px-4 py-2 bg-white rounded-t-lg dark:bg-zinc-800">
            <textarea placeholder="发表你的观点..." rows="8" cols="50" name="text" id="comment-textarea" class="w-full px-0 text-sm text-zinc-900 bg-white border-0 dark:bg-zinc-800 focus:ring-0 dark:text-white dark:placeholder-zinc-400" required><?php $this->remember('text'); ?></textarea>
          </div>
          <div class="flex items-center justify-between px-3 py-2 border-t dark:border-zinc-600">
            <button type="submit" class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-900 hover:bg-blue-800">
              <?php _e('提交评论'); ?>
            </button>
            <div class="flex ps-0 space-x-1 rtl:space-x-reverse sm:ps-2">
              <!-- emoji表情 -->
              <?php if (in_array('ShowCommentEmoji', $this->options->moreConfig)) : ?>
                <button data-popover-target="popover-click" data-popover-trigger="click" type="button" class="inline-flex justify-center items-center p-2 text-zinc-500 rounded cursor-pointer hover:text-zinc-900 hover:bg-zinc-100 dark:text-zinc-400 dark:hover:text-white dark:hover:bg-zinc-600">
                  <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                    <path fill="none" d="M0 0h24v24H0z"></path>
                    <circle cx="15.5" cy="9.5" r="1.5"></circle>
                    <circle cx="8.5" cy="9.5" r="1.5"></circle>
                    <path d="M12 18c2.28 0 4.22-1.66 5-4H7c.78 2.34 2.72 4 5 4z"></path>
                    <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z"></path>
                  </svg>
                </button>
                <div data-popover id="popover-click" role="tooltip" class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white shadow-sm opacity-0 dark:text-gray-400 dark:bg-gray-800">
                  <div id="emoji" class="flex"></div>
                </div>
              <?php endif; ?>
              <?php if ($this->user->hasLogin()) : ?>
                <p>
                  <?php _e('用户: '); ?><a href="<?php $this->options->profileUrl(); ?>"><?php $this->user->screenName(); ?></a>
                  <a class="inline-block px-3 py-2 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" href="<?php $this->options->logoutUrl(); ?>" title="Logout"><?php _e('退出'); ?></a>
                </p>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </form>
    </div>
  <?php else : ?>
    <h3 class="text-center"><?php _e('评论已关闭'); ?></h3>
  <?php endif; ?>
</div>

<!-- inject:js -->