import { Compiler, Compilation } from "webpack";
import { promises as fs } from "fs";
import path from "path";

interface PhpInjectPluginOptions {
  template: string;
  filename: string;
  cssInjectPoint?: string;
  jsInjectPoint?: string;
}

class PhpInjectPlugin {
  template: string;
  filename: string;
  cssInjectPoint?: string;
  jsInjectPoint?: string;

  constructor(options: PhpInjectPluginOptions) {
    this.template = options.template;
    this.filename = options.filename;
    this.cssInjectPoint = options?.cssInjectPoint ?? "<!-- inject:css -->";
    this.jsInjectPoint = options?.jsInjectPoint ?? "<!-- inject:js -->";
    console.log('PhpInjectPlugin触发构建')
  }

  async handleTemplate(
    assets: string[],
    compiler: Compiler,
    compilation: Compilation
  ): Promise<string> {
    const cssFiles = assets.filter((file) => file.endsWith(".css"));
    const jsFiles = assets.filter((file) => file.endsWith(".js"));

    let data = await fs.readFile(this.template, "utf8");

    // css注入模板
    const cssTemplate = (cssName: string) =>
      `<link rel="stylesheet" href="<?php $this->options->themeUrl('${cssName}'); ?>"></link>`;

    // js注入模板
    const jsTemplate = (jsName: string) =>
      `<script src="<?php $this->options->themeUrl('${jsName}'); ?>" ></script>`;

    // 注入 CSS 和 JS 到 PHP 文件
    const headInject = cssFiles
      .map((css) => cssTemplate(path.basename(css)))
      .join("\n");
    const bodyInject = jsFiles
      .map((js) => jsTemplate(path.basename(js)))
      .join("\n");

    data = data.replace(this.cssInjectPoint!, headInject);
    data = data.replace(this.jsInjectPoint!, bodyInject);

    return data;
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
