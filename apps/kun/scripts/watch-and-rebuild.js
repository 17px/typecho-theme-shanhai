const chokidar = require('chokidar');
const { spawn } = require('child_process');
const path = require('path');
const { theme } = require('../package.json')

const startWebpack = () => {
  const process = spawn('npx', ['webpack', 'serve', '--config', 'scripts/webpack.dev.ts'], {
    stdio: 'inherit'
  });

  process.on('close', (code) => {
    if (code !== 0) {
      console.log(`webpack serve process exited with code ${code}`);
    }
  });

  return process;
};

const restartWebpack = () => {
  if (webpackProcess) {
    console.log('Changes detected, restarting webpack serve...');
    webpackProcess.kill('SIGINT'); // 停止当前的 Webpack 进程

    webpackProcess.on('exit', () => {
      webpackProcess = startWebpack(); // 重新启动一个新的 Webpack 开发服务器
      console.log('Webpack serve restarted...');
    });
  }
};

const targetDir = 'src/modules'
/**
 * 监听模块目录
 */
const modulesDir = path.join(__dirname, targetDir);

const watcher = chokidar.watch(modulesDir, { ignoreInitial: true });

let webpackProcess = startWebpack();

console.log(`[${theme.name} 开发目录] : ${targetDir}`);

// 监听添加或删除事件
watcher.on('addDir', () => restartWebpack())
  .on('unlinkDir', () => restartWebpack());

