import MiniCssExtractPlugin from "mini-css-extract-plugin";
import { Configuration } from "webpack";
import { getModules } from "./util";
import "webpack-dev-server";
import path from "path";

export const rootPath = process.cwd();
export const modules = getModules(path.resolve(rootPath, "src/modules"));

const generateEntries = (templateNames: string[]) => {
  return Object.fromEntries(
    templateNames.map((name) => [
      name,
      path.resolve(rootPath, `src/modules/${name}/index.ts`),
    ])
  );
};

export default {
  entry: generateEntries(modules),
  resolve: {
    alias: { "@": path.resolve(rootPath, "src") },
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
        use: [
          MiniCssExtractPlugin.loader,
          "css-loader",
          "postcss-loader",
          "less-loader",
        ],
      },
    ],
  },
} as Configuration;
