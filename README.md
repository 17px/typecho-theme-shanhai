# 开发环境

确保安装了docker环境，解压根目录的 `typecho.zip` 到 `test` 文件夹下

```sh
# cd /
docker compose -f ./docker-compose.dev.yml up -d
```

关于 `docker-compose.dev.yml` 的配置

```yml
environment:
	- TYPECHO_SITE_URL=https://localhost
ports:
	- "80:80"
```

如果需要自定义的宿主机映射的端口(typecho服务端口)，对于的 `webpack-dev-server 代理`也要修改

修改 `theme.proxy` 的值，和上面 `TYPECHO_SITE_URL` 要保持一致哦！

```json
// package.sjon
"theme": {
	"distPath": "test/typecho/usr/themes",
	"name": "typecho-theme-kun",
	"proxy": "http://localhost"
},
```

其他的两个属性 `theme.name` 就是开发的主题的名称，`theme.distPath` 是webpack构建静态资源的存放目录

# 工程化构建思路

> 详情参看 `scripts` 下的配置文件

1. 采用 `typecho1.21` 的包，解压后为`test/typecho` 文件夹，作为 `joyqi/typecho:nightly-php7.4-apache`的挂载目录
2. 使用 `chokidar` 和 `webpack` 对主题 `src/modules`进行开发阶段监听、构建。`js`、`css` 会注入到 `.php` 中，注入点是 `<!--inject:js-->`和`<!--inject:css-->`
3. 上一步中的全部静态资源会被 `webpack.output` 输出到 `test/typecho/usr/themes/{theme.name}/` 中
4. 利用 `webpack-dev-server` 的 `proxy` 和 `static`，实现浏览器自动刷新


# 主题名 参考

	1.	钦原 (Qinyuan)
引文：《山海经·南山经》：“南次三经之首曰钦原之山，其兽多有钦原，鸟似乌，文赤白，名曰钦原，食之宜子孙。”
	2.	烛龙 (Zhulong)
引文：《山海经·大荒北经》：“大荒之中，有山名曰不周，有神焉，名曰烛龙。”
	3.	蠪蛭 (Longzhi)
引文：《山海经·北山经》：“又东三百里，曰太原之山，其上多玉，其下多青雄黄，有蛇，名曰蠪蛭，食之使人淫。”
	4.	祝融 (Zhuhong)
引文：《山海经·海外南经》：“祝融降火于祝融之山，其火光明，祝融因此名。”
	5.	天狗 (Tiangou)
引文：《山海经·海外北经》：“北海有天狗，天狗所守其处名曰天门。”
	6.	青龙 (Qinglong)
引文：《山海经·西次三经》：“青龙，龙身鸟足，号曰应龙，食者寿。”
	7.	白泽 (Baize)
引文：《山海经·西山经》：“白泽出于海外，兽身人面，其声如婴儿，食之不老。”
	8.	九尾狐 (Jiuweihu)
引文：《山海经·南山经》：“青丘之山，有狐，其九尾。”
	9.	鲲 (Kun)
引文：《山海经·北山经》：“北冥有鱼，其名为鲲。”
	10.	毕方 (Bifang)
引文：《山海经·北山经》：“有鸟焉，其状如鹤，一足，赤文青质，名曰毕方。”