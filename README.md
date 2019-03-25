# symfony-examples
symfony 3 and sonata admin examples

## 安装
#### [symfony 3.4 安装 ]
```
wget https://get.symfony.com/cli/installer -O - | bash
sudo mv /home/jims/.symfony/bin/symfony /usr/local/bin/symfony
symfony new --full --version=3.4 sonata_update
```

#### [sonta admin  安装 ]
```
composer require sonata-project/admin-bundle
composer require sonata-project/doctrine-orm-admin-bundle
```

## 初始化
#### [User Enity 生成]
bin/console make:user

关于Entity的 createdAt 及 updatedAt 的自动化个人处理方式是使用 doctrine Lifecycle Callbacks
Entity 使用 ues App\Doctrine\CreateAndUpdateAction ; 来使用


#### [配置数据库, 创建数据库]
编辑 .env
DATABASE_URL=mysql://user:pass@127.0.0.1:3306/sonata_update

```
bin/console doctrine:database:create
Created database `sonata_update` for connection named default
```

#### 更新数据表
```
bin/console doctrine:schema:update --dump-sql
bin/console doctrine:schema:update --dump-sql --force
```

#### [User Admin 生成]
```
bin/console make:sonata:admin 
The fully qualified model class:
> App\Entity\User
....
```

#### [去除google 字体]
在AdminLTE.min.css 中会引用 google 字体, 利用sonata_admin 配置项中asset 中css列表, 
重新引用修改过的AdminLTE.min.css(注释google 字体)

#### [马赛克模式]
个人觉得没用
```
# config/packages/sonata_admin.yaml
sonata_admin:
    # for hide mosaic view button on all screen using `false`
    show_mosaic_button: true
```
#### [List View]
list 视图里 url type 似乎不能用
