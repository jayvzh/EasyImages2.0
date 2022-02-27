<?php
// 扩展检测
$expand = array('fileinfo', 'iconv', 'gd', 'mbstring', 'openssl',);
foreach ($expand as $val) {
    if (!extension_loaded($val)) {
        echo '
        <script>
        new $.zui.Messager("扩展:' . $val . '- 未安装,可能导致图片上传失败! 请尽快修复。",{
			type: "black", // 定义颜色主题
			icon: "exclamation-sign" // 定义消息图标
        }).show();
        </script>
    ';
    }
}
// 检测是否更改默认域名
if (strstr('localhost|127.0.0.1', $_SERVER['HTTP_HOST'])) {
    echo '
    <script>
    new $.zui.Messager("请修改默认域名,可能会导致网站访问异常! ",{
        type: "black" // 定义颜色主题 
    }).show();
    </script>
    ';
}
// 检测是否修改默认密码
if ($config['password'] === 'e6e061838856bf47e1de730719fb2609') {
    echo '
    <script>
    new $.zui.Messager("请修改默认密码,否则会有泄露风险! ",{
        type: "warning", // 定义颜色主题 
        time:7000
    }).show();
    </script>
    ';
}
// 检测监黄接口是否可以访问
if ($configp['checkImg'] !== 0) {

    if ($config['checkImg'] == 1) {

        if (!@IP_URL_Ping('api.moderatecontent.com', 80, 1)) {
            echo '
            <script>
                new $.zui.Messager("moderatecontent 鉴黄接口无法ping通! ",{
                    type: "warning" // 定义颜色主题 
                }).show();
            </script>
            ';
        }
    }

    if ($config['checkImg'] == 2) {

        $ip = parse_url($config['nsfwjs_url'])['host'];
        $port = parse_url($config['nsfwjs_url'])['port'];

        if (filter_var($ip, FILTER_VALIDATE_IP)) {
            if (!@IP_URL_Ping($ip, $port, 1)) {
                echo '
                <script>
                    new $.zui.Messager("' . $ip . $port . ' 鉴黄接口无法ping通! ",{
                        type: "warning" // 定义颜色主题 
                    }).show();
                </script>
                ';
            }
        } else {
            if (!@IP_URL_Ping($ip, 80, 1)) {
                echo '
                <script>
                    new $.zui.Messager("' . $ip . ' 鉴黄接口无法ping通! ",{
                        type: "warning" // 定义颜色主题 
                    }).show();
                </script>
                ';
            }
        }
    }
}

// 检测是否存在.user.ini
if (file_exists(APP_ROOT . '/.user.ini')) {
    echo '
    <script>
        new $.zui.Messager("请关闭防跨目录读写或删除.user.ini文件 ",{
            type: "danger", // 定义颜色主题 
            time:10000
        }).show();
    </script>
    ';
}
