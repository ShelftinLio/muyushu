<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>检索结果</title>
    <style>
        body {
            width: 100%;
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            background-image: url("imgs/bg1.png"); /* 保留背景图片 */
            background-size: cover;
            padding-top: 120px;
            font-family: Arial, sans-serif;
        }

        #title {
            font-size: 36px;
            color: #333; /* 深色标题 */
            margin-bottom: 20px;
        }
        
          #title1 {
            font-size: 24px;
            color: #333; /* 深色标题 */
            margin-bottom: 12px;
        }

        table {
            width: 80%; /* 表格宽度 */
            border-collapse: collapse; /* 合并边框 */
            border: 1px solid rgba(255, 255, 255, 0.4); /* 半透明边框 */
            background-color: rgba(255, 255, 255, 0.6); /* 更高的透明度 */
            border-radius: 10px; /* 添加圆角 */
            overflow: hidden; /* 让圆角生效 */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* 轻微阴影，增强扁平化效果 */
        }

        th, td {
            padding: 12px; /* 单元格间距 */
            text-align: left;
        }

        th {
            font-size: 16px; /* 标题行字体大小 */
            background-color: rgba(186, 104, 200, 0.8); /* 使用淡紫色调半透明背景 */
            color: #ffffff; /* 标题文字颜色 */
        }

        td {
            font-size: 14px;
            color: #333; /* 表格内容颜色 */
        }

        tr:nth-child(odd) {
            background-color: rgba(255, 255, 255, 0.65); /* 奇数行背景颜色，透明度增加 */
        }

        tr:nth-child(even) {
            background-color: rgba(240, 240, 240, 0.65); /* 偶数行背景颜色，透明度增加 */
        }

        .hl {
            color: #e63946; /* 扁平化的亮色强调 */
            font-weight: bold;
        }
    </style>
</head>



<body>
    <img src="imgs/logo1.png" height="100">
    <h1 id="title">《廣州大典·曲類》</h1>
    <h1 id="title1">收木魚書、南音與龍舟歌檢索系統</h1>
<?php
    header("Content-Type:text/html;charset=utf-8;");   // 设置编码格式
    $searchword = $_GET["searchword"];  // 获取检索词

    echo "<h3>您检索的词是 <span style='color: red;'>$searchword</span></h3>";  // 输出检索词的提示语
    $conn = mysqli_connect("127.0.0.1","root","");   // 如果你设置了密码,在第三个参数填入密码
    
    // tang_poem是数据库名
    $condb = mysqli_select_db($conn, "muyushu") or die("无法连接服务器");  // 选择数据库
    mysqli_query($conn, "set names'utf8'");  // 设置字符集

    // 检索使用的SQL语句
    $sql = "SELECT * FROM `guangzhoudadian` where `书目` LIKE '%$searchword%' or `分类` LIKE '%$searchword%'";  // 检索诗文中包含检索词的诗文

    $query = mysqli_query($conn, $sql);  // 执行SQL语句

    echo "<table border='1'><thead>";  // 输出表格
    echo "<tr><th>序號</th><th>書目</th><th>版本</th><th>來源</th><th>完整度</th><th>建議選本</th><th>分類</th><th>頁碼（筒子頁）</th><th>說明</th></tr>";  // 输出表头

    $num = 0;  // 记录检索到的结果数
    while($row = mysqli_fetch_array($query)){
        // 需要输出的字段
        $col1 = $row["序号"];  // 标题
        $col2 = $row["书目"];  // 作者
        $col3 = $row["版本"];   // 诗文
	 $col4 = $row["来源"];  
	 $col5 = $row["完整度"];
	 $col6 = $row["建议选本"];  
	 $col7 = $row["分类"]; 
	 $col8 = $row["页码（筒子页）"]; 
	 $col9 = $row["说明"]; 
	 
        $col2 = str_replace($searchword, "<span class='hl'>$searchword</span>", $col2);  // 将检索词标红
	 $col7 = str_replace($searchword, "<span class='hl'>$searchword</span>", $col7);  
        echo "<tr><td>$col1</td><td>$col2</td><td>$col3</td><td>$col4</td><td>$col5</td><td>$col6</td><td>$col7</td><td>$col8</td><td>$col9</td></tr>";  // 输出表格内容
        $num += 1;  // 检索到的结果数加1
    }

    echo "</table>";  // 结束表格

    echo "<h3>共检索到 $num 条结果</h3>";   // 输出检索到的结果数
?>
<h3>作者：徐洪歸</h3>
</body>

</html>
