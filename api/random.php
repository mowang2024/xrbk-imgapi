<?php
// 设置默认的内容类型为 JSON，指定字符集为 UTF-8
header('Content-Type: application/json; charset=utf-8');

// 数据库配置
$host = 'sql.wsfdb.cn'; // 数据库主机
$dbname = 'mowang666123'; // 数据库名
$username = 'mowang666123'; // 数据库用户名
$password = 'mowang666'; // 数据库密码

try {
    // 创建数据库连接
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['code' => 500, 'msg' => '数据库连接失败: ' . $e->getMessage()], JSON_UNESCAPED_UNICODE);
    exit;
}

// 定义文件夹路径
$animeDir = 'anime/';
$sceneryDir = 'scenery/';

// 获取请求参数
$param = isset($_GET['anime']) ? 'anime' : (isset($_GET['scenery']) ? 'scenery' : '');

// 根据参数选择文件夹并更新数据库调用计数
if ($param === 'anime') {
    $dir = $animeDir;
    // 更新数据库中的调用计数
    $stmt = $pdo->prepare("UPDATE api_calls SET call_count = call_count + 1 WHERE id = 1"); // 假设 anime 的计数在第一行
    $stmt->execute();
} elseif ($param === 'scenery') {
    $dir = $sceneryDir;
    // 更新数据库中的调用计数
    $stmt = $pdo->prepare("UPDATE api_calls SET call_count = call_count + 1 WHERE id = 2"); // 假设 scenery 的计数在第二行
    $stmt->execute();
} else {
    http_response_code(400);
    echo json_encode(['code'=> 400,'msg' => '无效的参数'], JSON_UNESCAPED_UNICODE);
    exit;
}

// 获取文件夹中的所有图片文件
$files = glob($dir . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);

// 检查是否有文件
if (empty($files)) {
    http_response_code(404);
    echo json_encode(['code'=> 404, 'msg'=> "没有找到图片"], JSON_UNESCAPED_UNICODE);
    exit;
}

// 随机选择一张图片
$image = $files[array_rand($files)];

// 获取域名
$domain = $_SERVER['HTTP_HOST'];

// 构建完整的图片 URL
$imageUrl = 'http://' . $domain . '/' . $image;

// 检查请求参数后面是否有 =json
$isJson = (isset($_GET['anime']) && $_GET['anime'] === 'json') || (isset($_GET['scenery']) && $_GET['scenery'] === 'json');

// 如果请求的是 JSON 格式，返回图片路径
if ($isJson) {
    echo json_encode(['code' => 200, 'message' => '获取成功', 'imgurl' => $imageUrl], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
} else {
    // 否则直接显示图片
    header('Content-Type: image/jpeg'); // 根据文件类型设置合适的 Content-Type
    readfile($image);
}
