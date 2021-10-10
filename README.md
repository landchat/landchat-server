# LandChat Server

Server for LandChat NG App

See: [landchat/landchat-ng-app](https://github.com/landchat/landchat-ng-app.git)

## 注意

请确保Server与App版本对应。

landchat-server 1.0.0对应landchat-ng-app 0.3.0-dev3与1.0.4之间的所有版本。

## URL重写配置

请配置URL rewrite，使得landchat-ng-app可以正常访问后端。以下是nginx配置示例，可供参考：

```conf
location /api {
    rewrite /v1/(.*) /api/v1/$1.php;
}
```

Apache请自行配置。配置后确保不加.php也可以访问API文件。
