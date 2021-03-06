<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - <?php echo $_page_title; ?> </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Public/Admin/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/Admin/Styles/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/Public/umeditor1_2_2-utf8-php/third-party/jquery.min.js"></script>
</head>
<body>
<h1>
    <?php if($_page_btn_name): ?>
    <span class="action-span"><a href="<?php echo $_page_btn_link; ?>"><?php echo $_page_btn_name; ?></a></span>
    <?php endif; ?>
    <span class="action-span1"><a href="#">管理中心</a></span>
    <span id="search_id" class="action-span1"> - <?php echo $_page_title; ?> </span>
    <div style="clear: both"></div>
</h1>
<!-- 内容-->
<!-- 引入布局文件 -->

<!-- 商品列表 -->
<form method="post" action="/index.php/Admin/Privilege/privilegeAdd.html" name="main_form">
    <div class="main-div">
        <table cellpadding="3" cellspacing="1">
            <tr>
                <td class="label">上级权限:</td>
                <td>
                    <select name="parent_id">
                        <option value="0">顶级权限</option>
                        <?php foreach($priData as $k => $v): ?>
                            <option value="<?php echo $v['id']; ?>"><?php echo str_repeat('-', 8*$v['level']) . $v['pri_name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="label">权限名称:</td>
                <td>
                    <input type="text" name="pri_name" />
                </td>
            </tr>
            <tr>
                <td class="label">模块名称:</td>
                <td>
                    <input type="text" name="module_name" />
                </td>
            </tr>
            <tr>
                <td class="label">控制器名称:</td>
                <td>
                    <input type="text" name="controller_name" />
                </td>
            </tr>
            <tr>
                <td class="label">方法名称:</td>
                <td>
                    <input type="text" name="action_name" />
                </td>
            </tr>
            <tr>
                <td colspan="99" align="center">
                    <input type="submit" class="button" value="确定" />
                    <input type="reset" class="button" value="重置" />
                </td>
            </tr>
        </table>
    </div>
</form>
<!-- 引入行高亮显示 -->
<script type="text/javascript" src="/Public/datetimepicker/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="/Public/Admin/Js/tron.js"></script>
</body>
</html>

</body>
</html>