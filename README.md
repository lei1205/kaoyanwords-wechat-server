# 用微信公众号背考研单词

考研的时候编的一个抽背单词的微信公众号程序。公众号已经注销不用了。当时好像用的是`mariaDB`部署的, `localhost.sql`文件就是我整理的考研词汇的备份。

**功能简介：**
1. 在公众号回复`6`，即可开启背单词模式
2. 程序会随机在数据库里挑一个单词出来。单词下面有两个链接（`认识`/`不认识`）。
3. 如果点击了`认识`，程序会在数据库里再挑一个单词出来。
4. 如果点击了`不认识`，程序会展示单词的意思和例句。而且会再附上一个链接（`下一个单词`）
5. 就可以一直刷着背了……

此外，`words`文件夹这一部分是用来导入新单词到服务器的界面。

**一些参考资料：**
1. PHP教程：https://www.runoob.com/php/php-tutorial.html
2. PHP如何把数据存到数据库中：https://www.php.cn/php-ask-433742.html
3. PHP开发微信公众号一：配置和部署服务器及Token认证：https://zhuanlan.zhihu.com/p/28259840
4. Ubuntu安装PhpMyAdmin管理MySQL数据库：https://www.cnblogs.com/xpwi/p/9821371.html
5. Parameter must be an array or an object that implements Countable： https://devanswers.co/problem-php-7-2-phpmyadmin-warning-in-librariessql-count/
