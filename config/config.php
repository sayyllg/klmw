<?php
        //是否是开发环境
        define( "DEVELOP_ENV", true );

        // files
        define( "FILE_EXTENSIONS", 'png,gif,jpg,jpeg,xls,xlsx,txt,doc,docx' );
        define( "FILE_MIN_SIZE", 1 );   // 1 KB
        define( "FILE_MAX_SIZE", 10240 );       // 10*1024 K

        // 根目录
        define( "EHR_PATH", dirname(dirname(__FILE__)) );


        //url
        define( "URL", 'http://127.0.0.1:8082' );
        // define( "URL", 'http://www.sayyllg.com' );

