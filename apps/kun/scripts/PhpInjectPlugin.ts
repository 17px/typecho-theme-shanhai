import { promises as fs } from "fs";
import path from "path";
import { Compiler, Compilation } from "webpack";

interface PhpInjectPluginOptions {
  template: string;
  filename: string;
}

class PhpInjectPlugin {
  private template: string;
  private filename: string;
  private templateName: string;

  constructor(options: PhpInjectPluginOptions) {
    this.template = options.template;
    this.filename = options.filename;
    this.templateName = path.basename(this.template, ".php"); // 获取 template 的名称（不带后缀）
  }

  private async handleTemplate(
    assets: string[],
    compiler: Compiler,
    compilation: Compilation
  ): Promise<string> {
    const templateName = path.basename(path.dirname(this.template));
    const entryAssets = compilation.entrypoints.get(templateName)!.getFiles();
    const jsAsset = entryAssets.find((asset) => asset.endsWith(".js"));
    const cssAssets = entryAssets.filter((asset) => asset.endsWith(".css"));

    const templateParams: { [key: string]: string } = {
      "<!-- inject:css -->": cssAssets
        .map((css) => this.cssTemplate(path.basename(css)))
        .join("\n"),
      "<!-- inject:js -->": jsAsset
        ? this.jsTemplate(path.basename(jsAsset))
        : "",
    };

    const data = await fs.readFile(this.template, "utf8");

    return Object.keys(templateParams).reduce((updatedData, key) => {
      const regex = new RegExp(
        key.replace(/[.*+\-?^${}()|[\]\\]/g, "\\$&"),
        "g"
      );
      return updatedData.replace(regex, templateParams[key]);
    }, data);
  }

  private cssTemplate(cssFileName: string): string {
    return `<link rel="stylesheet" href="<?php $this->options->themeUrl('${cssFileName}'); ?>"></link>`;
  }

  private jsTemplate(jsFileName: string): string {
    return `<script src="<?php $this->options->themeUrl('${jsFileName}'); ?>" ></script>`;
  }

  apply(compiler: Compiler): void {
    compiler.hooks.emit.tapPromise(
      "PhpInjectPlugin",
      async (compilation: Compilation) => {
        const assets = Object.keys(compilation.assets);
        const result = await this.handleTemplate(assets, compiler, compilation);

        await fs.mkdir(path.dirname(this.filename), { recursive: true });
        await fs.writeFile(this.filename, result, "utf8");
      }
    );
  }
}

export default PhpInjectPlugin;
