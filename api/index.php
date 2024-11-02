<?php
// 数据库配置
$servername = "sql.wsfdb.cn"; // 数据库服务器地址
$username = "mowang666123"; // 数据库用户名
$password = "mowang666"; // 数据库密码
$dbname = "mowang666123"; // 数据库名称

// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);

// 检查连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

// 获取 API 调用次数
$sql = "SELECT api_name, call_count, image_url, parameter_description, example, description FROM api_calls";
$result = $conn->query($sql);

// 关闭连接
// 这里不再关闭连接，以便后续使用
?>
```html
<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,minimum-scale=1,maximum-scale=1,initial-scale=1,user-scalable=no">
    <link rel="icon" href="/favicon.ico" type="image/x-icon" />
    <meta name="description" content="API">
    <title>新锐图片API</title>
    <link rel="stylesheet" href="https://lf26-cdn-tos.bytecdntp.com/cdn/twitter-bootstrap/3.4.1/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa; /* 设置背景颜色 */
        }
        .bgw {
            background-color: #ffffff; /* 设置内容区域背景颜色 */
            padding-top: 70px; /* 确保内容不被固定导航条覆盖 */
        }
        .alert {
            margin: 15px 0; /* 增加警告框的外边距 */
        }
    </style>
</head>
<body class="bg">
<div class="container bgw">
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="https://img.xrbk.cn">新锐图片API</a>
            </div>
        </div>
    </nav>
    <div class="alert alert-warning">本站所有数据采集均来自互联网，本站对您使用这些资源造成的任何后果不负任何责任，如有侵权请前往<a href="https://www.xrbk.cn">新锐博客</a>联系站长处理</div>
    <div class="alert alert-info">目前本站服务器资源有限，请自觉控制访问频率。</div>
    <hr>
    <h3>API接口</h3>
    <table class="table table-bordered bgw">
        <tbody>
            <tr>
                <th>API类型</th>
                <th>调用次数</th>
                <th>URL地址</th>
                <th>参数说明</th>
                <th>示例</th>
                <th>描述</th>
            </tr>
            <?php
            // 检查查询结果
            if ($result->num_rows > 0) {
                // 输出每行数据
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['api_name']) . "<span class='label label-success'>PC</span></td>";
                    echo "<td>" . htmlspecialchars($row['call_count']) . "次</td>";
                    echo "<td><a href='" . htmlspecialchars($row['image_url']) . "' target='_blank'>" . htmlspecialchars($row['image_url']) . "</a></td>";
                    echo "<td>" . htmlspecialchars($row['parameter_description']) . "</td>";
                    echo "<td><a href='" . htmlspecialchars($row['example']) . "' target='_blank'>" . htmlspecialchars($row['example']) . "</a></td>";
                    echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>没有找到 API 数据</td></tr>";
            }

            // 关闭连接
            $conn->close();
            ?>
        </tbody>
    </table>
    <hr>
    <h4>使用限制</h4>
    <pre>
为了合理使用服务器资源，防止恶意调用，制定了一些规定
对于滥用的行为将会被大范围添加进黑名单，不再予以提供服务
</pre>
    <hr>
    <h4>隐私声明</h4>
    <pre>
本项目会记录调用域名,调用ip,调用次数等数据，但仅供作者参考使用，不向第三方提供。
本页面只显示调用次数信息
    </pre>
</div>
<script src="https://lf26-cdn-tos.bytecdntp.com/cdn/jquery/3.6.0/jquery.min.js"></script>
<script src="https://lf26-cdn-tos.bytecdntp.com/cdn/twitter-bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>
</html>
