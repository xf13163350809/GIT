<?php
return array(
        'web_path'=>realpath("./"),    //项目物理路径

        /* 数据库设置 */
        'DB'=>array(
            'DB_TYPE'               =>  'pdo',     // 数据库类型
            'DB_HOST'               =>  '127.0.0.1', // 服务器地址
            'DB_NAME'               =>  'juhui',      // 数据库名
            'DB_USER'               =>  'root',      // 用户名
            'DB_PWD'                =>  'root',          // 密码
            'DB_PORT'               =>  '',        // 端口
            'DB_PREFIX'             =>  'jh51_',    // 数据库表前缀
            'DB_charset'            =>  '',     //数据库编码(默认utf8)
            'DB_mode'               =>  '',
        ),

       /*缓存*/
        'cache'=>array(
            'cachePath'             =>'file',    //缓存存储路径
            'cacheTime'             =>'60',     //缓存时间(0为永久)秒
            'cacheFileType'         =>'.txt',     //缓存文件后缀
        ),

        /*异常处理*/
        'debug'=>array(
            'IGNORE_EXCEPTION'      =>'TRUE'    //是否显示错误信息（TRUE OR FALSE）
        ),

    );
?>