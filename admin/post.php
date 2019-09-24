<?php 
include_once "../includes/init.php";
include_once "./common.php";

$id = isset($_GET['id']) ? $_GET['id'] : 0;

//每页数量
$limit = 5;

//总数量
$res = $db -> select("count(*) as len") -> from("post") -> where("userid = {$id}") -> find();
$count = $res['len'];

//设置当前页和每页限制数
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

if(!$res) {
    die("SQL语句执行错误");
}

//设置偏移值￥
$offset = ($currentPage-1) * $limit;

//分页
$page = page($currentPage, $count, $limit, 5, 'yellow');

$username = $db -> select("username") -> from("user") -> where("id = {$id}") -> find();

$data = $db -> select("post.*,user.username") -> from("post") -> join("user", "user.id = post.userid") -> where("post.userid = {$id}") -> limit($offset, $limit) -> all();

foreach ($data as $key => $value) {
  $thumbups = $db -> select("username") -> from("user") -> where("id in (" . $value['thumbup'] . ")") -> all();

  if($data[$key]['thumbup'] != '0') {
    $data[$key]['thumbup'] = '';
  }
  foreach ($thumbups as $key2 => $item) {
    $data[$key]['thumbup'] =  $data[$key]['thumbup'] . $item['username'] . "、";
  }

  $data[$key]['thumbup'] = rtrim($data[$key]['thumbup'], "、");
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include_once "./meta.php"; ?>
  </head>
  <body> 
    <?php include_once "header.php"; ?>
    <?php include_once "menu.php"; ?>
    <div class="content">
        <div class="header">
            <h1 class="page-title"><?php echo $username['username']; ?>帖子</h1>
        </div>
        <ul class="breadcrumb">
            <li><a href="index.php">首页</a> <span class="divider">/</span></li>
            <li><a href="userlist.php">用户列表</a> <span class="divider">/</span></li>
            <li class="active"><?php echo $username['username']; ?>帖子</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                <div class="btn-toolbar">
                </div>
                <div class="well">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>帖子内容</th>
                          <th>创建时间</th>
                          <th>内容</th>
                          <th>点赞</th>
                          <th>浏览次数</th>
                          <th>操作</th>
                          <th style="width: 26px;"></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($data as $key => $item) { ?>
                        <tr>
                          <td><?php echo $item['content']; ?></td>
                          <td><?php echo date("Y-m-d", $item['create_time']); ?></td>
                          <td><?php echo $item['content']; ?></td>
                          <?php if($item['thumbup'] == '0') { ?>
                            <td>暂无点赞</td>
                          <?php }else { ?>
                            <td><?php echo $item['thumbup']; ?></td>
                          <?php } ?>
                          <td><?php echo $item['count']; ?></td>
                          <td>
                              <a href="comment.php?id=<?php echo $item['id']; ?>">查看评论</a>
                          </td>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                </div>
                <div class="pagination">
                    <ul>
                        <?php echo $page; ?>
                    </ul>
                </div>
                
                <footer>
                    <hr>
                    <p>&copy; 2017 <a href="#" target="_blank">copyright</a></p>
                </footer> 
            </div>
        </div>
    </div>
    
    <?php include_once "footer.php"; ?>
    
  </body>
</html>