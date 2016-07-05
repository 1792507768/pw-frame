# PHP版COC框架

### 类似Laravel的路由
	Router::get('/news/{date}/{id}.shtml', function ($date, $id) {
	    return Router::generateRoute('index', 'news', [
	        'date' => $date,
	        'id' => $id
	    ]);
	});

### 类似Yii2的PDO链式操作

	$this->demoDao->where(['status' => 1])->orderBy('id desc')->limit(30)->all();

### 更多特性
> 
- IOC容器
- 采用命名空间
- 支持Composer
- 支持多项目多域名
- 支持数据库主从切换