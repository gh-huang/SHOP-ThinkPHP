<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - 商品列表 </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Public/Admin/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/Admin/Styles/main.css" rel="stylesheet" type="text/css" />
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


<style type="text/css">
    #ul_pic_list li{margin: 5px;list-style-type: none;}
    #old_pic_list li{float: left;width: 150px;margin: 5px;list-style-type: none;}
</style>

<div class="tab-div">
    <div id="tabbar-div">
        <p>
            <span class="tab-front" id="general-tab">通用信息</span>
            <span class="tab-back">商品描述</span>
            <span class="tab-back">会员价格</span>
            <span class="tab-back">商品属性</span>
            <span class="tab-back">商品相册</span>
        </p>
    </div>
    <div id="tabbody-div">
        <form enctype="multipart/form-data" action="/index.php/Admin/Goods/goodsEdit/id/35.html" method="post">
        <input type="hidden" name="id" value="<?php echo $data['id']; ?>" />
            <!-- 基本信息 -->
            <table width="90%" id="general-table" align="center" class="tab_table">
                <tr>
                    <td class="label">主分类:</td>
                    <td>
                        <select name="cat_id">
                            <option value="">选择分类</option>
                            <?php foreach ($catData as $k => $v): if($v[id] == $data['cat_id']) $select = 'selected="selected"'; else $select = ''; ?> 
                            <option <?php echo $select; ?> value="<?php echo $v['id']; ?>"><?php echo str_repeat('-',8*$v['level']) . $v['cat_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <span class="require-field">*</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">拓展分类:<input type="button" id="btn_add_cat" value="添加一个" onclick="$('#cat_list').append($('#cat_list').find('li').eq(0).clone());" /></td>
                    <td>
                        <ul id="cat_list">
                        <!-- 如果有原分类就循环输出，否则默认输出一个下拉框 -->
                            <?php if($gcData): ?>
                                <?php foreach ($gcData as $k1 => $v1): ?>
                                <li>
                                    <select name="ext_cat_id[]">
                                        <option value="">选择分类</option>
                                        <?php foreach ($catData as $k => $v): if($v['id'] == $v1['cat_id']) $select = 'selected="selected"'; else $select = ''; ?>
                                        <option <?php echo $select; ?> value="<?php echo $v['id']; ?>"><?php echo str_repeat('-', 8*$v['level']) . $v['cat_name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </li>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <li>
                                    <select name="ext_cat_id[]">
                                        <option value="">选择分类</option>
                                        <?php foreach ($catData as $k => $v): ?>
                                        <option <?php echo $select; ?> value="<?php echo $v['id']; ?>"><?php echo str_repeat('-', 8*$v['level']) . $v['cat_name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td class="label">所在品牌：</td>
                    <td>
                        <?php buildSelect('brand','brand_id','id','brand_name',$data['brand_id']); ?>
                    </td>
                </tr>
                <tr>
                    <td class="label">商品名称：</td>
                    <td><input type="text" name="goods_name" size="60" value="<?php echo $data['goods_name']; ?>" />
                    <span class="require-field">*</span></td>
                </tr>
                <tr>
                    <td class="label">LOGO:</td>
                    <td>
                    <img src="<?php showImage($v['mid_logo']); ?>" />
                    <input type="file" name="logo" size="60" />
                    </td>
                </tr>
                <tr>
                    <td class="label">本店售价：</td>
                    <td>
                        <input type="text" name="shop_price" value="<?php echo $data['shop_price']; ?>" size="20"/>
                        <span class="require-field">*</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">市场售价：</td>
                    <td>
                        <input type="text" name="market_price" value="<?php echo $data['market_price']; ?>" size="20" />
                        <span class="require-field">*</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">是否上架：</td>
                    <td>
                        <input type="radio" name="is_on_sale" value="是" <?php if($data['is_on_sale'] == '是') echo "checked='checked'"; ?> /> 是
                        <input type="radio" name="is_on_sale" value="否" <?php if($data['is_on_sale'] == '否') echo "checked='checked'"; ?> /> 否
                    </td>
                </tr>
            </table>
            <!-- 商品描述 -->
            <table style="display: none" width="90%" class="tab_table" align="center">
                <tr>
                    <td class="label">商品简单描述：</td>
                    <td>
                        <textarea id="goods_desc" name="goods_desc"><?php echo $data['goods_desc']; ?></textarea>
                    </td>
                </tr>                
            </table>
            <!-- 会员价格 -->
            <table style="display: none" width="90%" class="tab_table" align="center">
                <tr>
                    <td class="label">会员价格：</td>
                    <td>
                        <?php foreach ($mlData as $k => $v): ?>
                            <?php echo $v['level_name']; ?>：¥<input value="<?php echo $mpData[$v['id']]; ?>" type="text" name="member_price[<?php echo $v['id']; ?>]" size="8" />元<br />
                        <?php endforeach; ?>
                    </td>
                </tr>                
            </table>
            <!-- 商品属性 -->
            <table style="display: none" width="90%" class="tab_table" align="center">
                <tr>
                    <td>
                        商品类型：<?php buildSelect('Type', 'type_id', 'id', 'type_name',$data['type_id']); ?>
                    </td>
                </tr>
                <tr>
                    <td><ul id="attr_list">
                    <?php
 $attrId = array(); foreach ($attrData as $k => $v): if(in_array($v['attr_id'], $attrId)) $opt = '-'; else { $opt = '+'; $attrId[] = $v['attr_id']; } ?>
                        <li>
                            <?php if($v['attr_type'] == '可选'): ?>
                                <a onclick="addNewAttr(this)" href="#">[<?php echo $opt; ?>]</a>
                            <?php endif; ?>
                            <?php echo $v['attr_name']; ?>:
                            <?php if($v['attr_option_values']): $attr = explode(',', $v['attr_option_values']); ?>
                                <select>
                                    <option value="">请选择</option>
                                    <?php foreach ($attr as $k1 => $v1): if($v1 == $v['attr_value']) $select = 'selected="selected"'; else $select = ''; ?>
                                        <option <?php echo $select; ?> value="<?php echo $v1; ?>"><?php echo $v1; ?></option>
                                    <?php endforeach; ?>    
                                </select>
                            <?php else: ?>
                                <input type="text" name="" value="<?php echo $v['attr_value']; ?>" />
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                    </ul></td>
                </tr>
            </table>
            <!-- 商品相册 -->
            <table style="display: none" width="90%" class="tab_table" align="center">
                <tr>
                    <td>
                        <input id="btn_add_pic" type="button" value="添加一张" />
                        <hr />
                        <ul id="ul_pic_list"></ul>
                        <hr />
                        <ul id="old_pic_list">
                            <?php foreach($gpData as $k => $v): ?>
                                <li>
                                <input pic_id="<?php echo $v['id']; ?>" class="btn_del_pic" type="button" value="删除" /><br />
                                <?php showImage($v['mid_pic'], 150); ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </td>
                </tr>
            </table>
            <div class="button-div">
                <input type="submit" value=" 确定 " class="button"/>
                <input type="reset" value=" 重置 " class="button" />
            </div>
        </form>
    </div>
</div>
</html>

<!--导入在线编辑器 -->
<link href="/Public/umeditor1_2_2-utf8-php/themes/default/css/umeditor.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="/Public/umeditor1_2_2-utf8-php/third-party/jquery.min.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/umeditor1_2_2-utf8-php/umeditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/umeditor1_2_2-utf8-php/umeditor.min.js"></script>
<script type="text/javascript" src="/Public/umeditor1_2_2-utf8-php/lang/zh-cn/zh-cn.js"></script>
<script>
UM.getEditor('goods_desc', {
    initialFrameWidth:"90%",
    initialFrameHeight:350
});
</script>
<script>
//切换的代码
$("#tabbar-div p span").click(function(){
    //点击的第几个按钮
    var i = $(this).index();
    //先隐藏所有的table
    $(".tab_table").hide();
    //显示第i个table
    $(".tab_table").eq(i).show();
    //先取消原按钮的选中状态
    $(".tab-front").removeClass("tab-front").addClass("tab-back");
    //设置当前按钮选中
    $(this).removeClass("tab-back").addClass("tab-front");
});
</script>

<script>
    //添加一张
    $("#btn_add_pic").click(function(){
        var file = '<li><input type="file" name="pic[]" /></li>';
        $("#ul_pic_list").append(file);
    })
</script>

<script type="text/javascript">
    //删除图片
    $(".btn_del_pic").click(function(){
        if (confirm('确定要删除吗？')) {
            //先选中删除按钮所在的li标签
            var li = $(this).parent();
            //从这个按钮上获取pic_id属性
            var pid = $(this).attr("pic_id");
            $.ajax({
                type : "GET",
                url : "<?php echo U('ajaxDelPic','',FALSE); ?>/picid/"+pid,
                success : function(data){
                    //把图片从页面中删除掉
                    li.remove();
                }
            });
        }
    })
</script>

<script type="text/javascript">
    //选择类型获取属性的AJAX
    $("select[name=type_id]").change(function(){
        //获取当前选中的类型的ID
        var typeId = $(this).val();
        //如果选择了一个类型就执行AJAX取属性
        if (typeId > 0) {
            //根据类型ID执行AJAX取出这个类型下的属性，并获取返回的JSON数据
            $.ajax({
                type : "GET",
                url : "<?php echo U('ajaxGetAttr', '', FALSE); ?>/type_id/"+typeId,
                dataType : "json",
                success : function(data){
                    //把服务器返回的属性循环拼成一个LI字符串，并显示在页面中
                    var li = "";
                    //循环每个属性
                    $(data).each(function(k,v){
                        li += '<li>';
                        //如果这个属性类型时可选的就有一个＋
                        if (v.attr_type == '可选') {
                            li += '<a onclick="addNewAttr(this);" href="#">[+]</a>';
                        }
                        //属性名称
                        li += v.attr_name + ' : ';
                        //如果属性有可选值就做下拉框，否则做文本框
                        if (v.attr_option_values == "") {
                            li += '<input type="text" name="attr_value['+v.id+'][]" />';
                        } else {
                            li += '<select name="attr_value['+v.id+'][]"><option value="">请选择...</option>';
                            //把可选值根据,转化成数组
                            var _attr = v.attr_option_values.split(',');
                            //循环每个值制作option
                            for(var i=0; i<_attr.length; i++){
                                li += '<option value="'+_attr[i]+'">';
                                li += _attr[i];
                                li += '</option>';
                            }
                            li += '</select>';
                        }
                        li += '</li>'
                    });
                    //把拼好的LI放到页面中
                    $("#attr_list").html(li);
                }
            });
        } else {
            $("#attr_list").html("");   //如果选的是情选择，就直接清空
        }
    });

function addNewAttr(a) {
    //$(a) -->把a转换成jquery中的对象，然后才能调用jquery中的方法
    //先获取所在的li
    var li = $(a).parent();
    if ($(a).text() == '[+]') {
        var newLi = li.clone();
        //+变-
        newLi.find("a").text('[-]');
        //新的放在li后面
        li.after(newLi);
    } 
    else
        li.remove();
    
}
</script>











</body>
</html>