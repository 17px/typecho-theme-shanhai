import CssMinimizerPlugin from "css-minimizer-webpack-plugin";
import common, { modules, rootPath } from "./webpack.common";
import MiniCssExtractPlugin from "mini-css-extract-plugin";
import { theme, version } from "../package.json";
import TerserPlugin from "terser-webpack-plugin";
import PhpInjectPlugin from "./PhpInjectPlugin";
const { merge } = require("webpack-merge");
import { Configuration } from "webpack";
import "webpack-dev-server";
import path from "path";

const { name } = theme;

// 生产阶段 webpack 构建静态资源的目录
const outputPath = path.resolve(`./build/${name}@${version}`);

export default merge(common, {
  mode: "production",
  output: {
    path: outputPath,
    filename: `[contenthash:8]_v${version}.js`,
  },
  optimization: {
    minimize: true,
    minimizer: [
      new CssMinimizerPlugin(),
      new TerserPlugin({
        parallel: true, // 开启多线程压缩
        terserOptions: { compress: { pure_funcs: ["console.log"] } },
      }),
    ],
    splitChunks: {
      cacheGroups: {
        vendors: {
          test: /node_modules/, // 只匹配node_modules里面的模块
          name: "vendors", // 提取文件命名为vendors,js后缀和chunkhash会自动加
          minChunks: 1, // 只要使用一次就提取出来
          chunks: "initial", // 只提取初始化就能获取到的模块,不管异步的
          minSize: 0, // 提取代码体积大于0就提取出来
          priority: 1, // 提取优先级为1
        },
      },
    },
  },
  performance: {
    hints: false,
    maxAssetSize: 4000000, // 整数类型（以字节为单位）
    maxEntrypointSize: 5000000, // 整数类型（以字节为单位）
  },
  plugins: [
    new MiniCssExtractPlugin({
      filename: `[contenthash:8]_v${version}.css`, // 抽离css的输出目录和名称
    }),
    ...modules.map((name) => {
      return new PhpInjectPlugin({
        template: path.resolve(rootPath, `src/modules/${name}/index.php`),
        filename: path.resolve(rootPath, `${outputPath}/${name}.php`),
      });
    }),
  ],
}) as Configuration;
