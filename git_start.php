<?php
/**
1. 在文件内右键选择git.bash
2.打开工具后,输入git init 创建.init文件
3.git config --global 'sk' 创建用户名
4.git config --global  '604906375@qq.com'  创建邮箱
5.可以通过git config --list 查看是否设置成功
6.git add添加文件   git add . 添加所有文件
7.git commit -m '描述' 	,添加文件
8.git status 查看文件状态
9.git rm 文件名 , 删除文件,也必须提交git commit
10.修改文件后的文件也是git add    git commit

**************上传到远程仓库******************
克隆文件后,编辑vim .git文件下的config文件
里面的url路径换成如 url = https://github123457:wlf123457@github.com/github123457/sk.git    其中github123457是用户名   :后的是密码加上@符号
git push 
1. git clone url,url是github的项目地址 克隆github的代码
2.git add 文件
3.git commit -m '描述'
4.git push

















*/