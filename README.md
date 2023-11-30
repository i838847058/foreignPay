##### 项目环境
- ftadmin 版本1.4.0.20230711
- PHP >= 7.2 且 <= 7.4 (推荐PHP7.4版本)
- MySQL >= 5.6 且 <= 8.0 (需支持innodb引擎)
- Nginx
- thinkphp5.0.25

##### 生成接口文档
- php think api --force=1 --module=dyrun -o dyrun.html
- php think api --force=1 --module=api --controller=test/demo --controller=test/index

