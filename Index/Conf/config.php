<?php
return array(
	//'配置项'=>'配置值'
            'SHOW_PAGE_TRACE' =>false,
            'LOAD_EXT_CONFIG' => 'db',
            'LOAD_EXT_FILE'=>'function',
            'DB_TYPE'=>'mysql',
            'DB_HOST'=>'localhost',
            'DB_USER'=>'root',
            'DB_NAME'=>'shop',
            'DB_PWD'=>'111111',
            'DB_PORT'=>'3306',
            'DB_PREFIX'=>'hd_',
            'TOKEN_ON'=>false,
            'APP_AUTOLOAD_PATH' => '@.TagLib',
            'TAGLIB_BUILD_IN' => 'Cx,List',
            'TMPL_ACTION_SUCCESS' => './Public/Template/msg.html',
	'TMPL_ACTION_ERROR' => './Public/Template/msg.html',
            "PAGE_VAR" => "page",
            "PAGE_ROW" => 10,
            "ARC_ROW" => 10,
            "PAGE_STYLE" => 2,
            
);
?>