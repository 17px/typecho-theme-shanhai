<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>


<main class="grid min-h-full place-items-center bg-white px-6 py-24 sm:py-32 lg:px-8">
  <div class="text-center">
    <p class="text-base font-semibold text-indigo-600">404</p>
    <h1 class="mt-4 mb-6 text-3xl font-bold tracking-tight text-gray-900 sm:text-5xl"><?php _e('难以觅迹'); ?></h1>
    <div class="mt-10 mb-4 flex items-center justify-center gap-x-6">
      <a class="text-sm font-semibold text-gray-900"><?php _e('你想查看的页面已被转移或删除了, 要不要搜索看看 '); ?><span aria-hidden="true"></span></a>
    </div>

    <form class="max-w-md mx-auto" method="post" action="<?php $this->options->siteUrl(); ?>" role="search">
      <label for="s" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">搜索关键字</label>
      <div class="relative">
        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
          <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
          </svg>
        </div>
        <input type="search" id="s" name="s" placeholder="<?php _e('输入关键字搜索'); ?>" required class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
        <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"><?php _e('搜索'); ?></button>
      </div>
    </form>
  </div>
</main>

</div>