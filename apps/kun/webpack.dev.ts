import MiniCssExtractPlugin from "mini-css-extract-plugin";
import { CleanWebpackPlugin } from "clean-webpack-plugin";
const ExtraWatchWebpackPlugin = require("extra-watch-webpack-plugin");
import PhpInjectPlugin from "./scripts/PhpInjectPlugin";
import { Configuration } from "webpack";
import "webpack-dev-server";
import path from "path";
import fs from "fs";
import { theme } from "./package.json";

const getModules = (folderPath: string) => {
  try {
    const filesAndDirs = fs.readdirSync(folderPath, { withFileTypes: true });
    const dirs = filesAndDirs
      .filter((dir) => dir.isDirectory())
      .map((dir) => dir.name);
    return dirs;
  } catch (error) {
    console.error("Error reading directory:", error);
    return [];
  }
};

const generateEntries = (templateNames: string[]) => {
  return Object.fromEntries(
    templateNames.map((name) => [
      name,
      path.resolve(__dirname, `src/modules/${name}/index.ts`),
    ])
  );
};

const modules = getModules(path.resolve(__dirname, "src/modules"));

const outputPath = path.join(
  __dirname,
  "../../",
  "test/typecho/usr/themes",
  theme.name
);

export default {
  mode: "development",
  entry: generateEntries(modules),
  output: {
    path: outputPath,
    filename: "[contenthash:8].js",
  },
  devServer: {
    port: 8080,
    proxy: { "/": "http://localhost" },
    devMiddleware: { writeToDisk: true },
    static: { directory: outputPath },
    hot: false /** 关闭热替换 */,
    open: true,
  },
  resolve: {
    alias: {
      "@": path.resolve(__dirname, "src"),
    },
    extensions: [".ts", ".js"],
  },
  module: {
    rules: [
      {
        test: /\.ts?$/,
        use: "ts-loader",
        exclude: /node_modules/,
      },
      {
        test: /\.(woff|woff2)$/,
        type: "asset/resource",
        generator: {
          filename: "font/[name][ext]",
        },
      },
      {
        test: /\.css$/,
        use: [MiniCssExtractPlugin.loader, "css-loader"],
      },
      {
        test: /\.less$/,
        use: [MiniCssExtractPlugin.loader, "css-loader", "less-loader"],
      },
    ],
  },
  plugins: [
    new ExtraWatchWebpackPlugin({
      files: ["src/**/*.php"],
    }),
    new CleanWebpackPlugin(),
    new MiniCssExtractPlugin({
      filename: "[contenthash:8].css",
    }),
    ...modules.map((name) => {
      return new PhpInjectPlugin({
        template: path.resolve(__dirname, `src/modules/${name}/index.php`),
        filename: path.resolve(__dirname, `${outputPath}/${name}.php`),
      });
    }),
  ],
} as Configuration;
