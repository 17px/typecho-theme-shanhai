const ExtraWatchWebpackPlugin = require("extra-watch-webpack-plugin");
import common, { modules, rootPath } from "./webpack.common";
import MiniCssExtractPlugin from "mini-css-extract-plugin";
import { CleanWebpackPlugin } from "clean-webpack-plugin";
const CopyWebpackPlugin = require('copy-webpack-plugin');
import PhpInjectPlugin from "./PhpInjectPlugin";
const { merge } = require("webpack-merge");
import { Configuration } from "webpack";
import { theme } from "../package.json";
import "webpack-dev-server";
import path from "path";

const { typechoThemeFolder, name, proxy } = theme;

// 开发阶段 webpack 构建静态资源的目录
const outputPath = path.join(rootPath, "../../", typechoThemeFolder, name);

export default merge(common, {
  mode: "development",
  output: {
    path: outputPath,
    filename: `[contenthash:8].js`,
  },
  devServer: {
    port: 8080,
    proxy: { "/": proxy ?? "http://localhost" },
    devMiddleware: { writeToDisk: true },
    /**
     * 监听 typecho主题目录，如果发生改变，刷新浏览器
     */
    static: { directory: outputPath },
    hot: true /** 关闭热替换 */,
  },
  plugins: [
    /**
     * 监听额外的文件变动
     */
    new ExtraWatchWebpackPlugin({ files: ["src/**/*.php"] }),
    new CleanWebpackPlugin(),
    new CopyWebpackPlugin({
      patterns: [
        { from: path.resolve(`${rootPath}/src/assets`), to: path.resolve(`${outputPath}/assets`) },
        { from: path.resolve(`${rootPath}/src/functions.php`), to: path.resolve(`${outputPath}`) },
        { from: path.resolve(`${rootPath}/src/screenshot.png`), to: path.resolve(`${outputPath}`) }
      ]
    }),
    new MiniCssExtractPlugin({ filename: `[contenthash:8].css` }),
    ...modules.map((name) => {
      return new PhpInjectPlugin({
        template: path.resolve(rootPath, `src/modules/${name}/index.php`),
        filename: path.resolve(rootPath, `${outputPath}/${name}.php`),
      });
    }),
  ],
}) as Configuration;
