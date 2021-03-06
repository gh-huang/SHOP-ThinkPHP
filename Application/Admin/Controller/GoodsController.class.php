<?php
//后台商品控制器
//命名空间
namespace Admin\Controller;
// use Think\Controller;

class GoodsController extends BaseController{

	//显示和处理表单
	public function goodsAdd() {
		//判断用户是否提交了表单
		if (IS_POST) {
			// dump($_POST);die;
			$model = D('Goods');
			//2.create方法：a.接收数据并保存到模型中，b.根据模型中定义的规则验证表单
			/**
			 * 第一个参数:要接收的数据默认是$_POST
			 * 第二个参数:表单的类型，当前是添加还是修改的表单，1:添加2:修改
			 * $_POST:表单中原始的数据，I('post.'):过滤之后的$_POST的数据，过滤xss攻击
			 */
			if ($model->create(I('post.'),1)) {
				//插入到数据库中
				if ($model->add()) {
					//显示成功信息并等待1秒之后跳转
					$this->success('操作成功！',U('goodsList'));
					exit;
				}
			}
			//如果走到这说明上面失败了，在这里处理失败的请求
			//从模型中取出失败的原因
			$error = $model->getError();
			//由控制器显示错误信息，并在3秒跳回上一个页面
			$this->error($error);
		}
		//取出所有的品牌
		$brandModel = new \Admin\Model\BrandModel();
		$brandData = $brandModel->select();
		//取出所有的会员级别
		$mlModel = new \Admin\Model\MemberLevelModel();
		$mlData = $mlModel->select();
		//取出所有的分类做下拉框
		$catModel = new \Admin\Model\CategoryModel();
		$catData = $catModel->getTree();

		//设置页面信息
		$this->assign(array(
			'catData' => $catData,
			'mlData' => $mlData,
			'brandData' => $brandData,
			'_page_title' => '商品添加',
			'_page_btn_name' => '商品列表',
			'_page_btn_link' => U('goodsList'),
			));
		//显示表单
		$this->display();
	}

	//商品列表
	public function goodsList() {
		$model = D('goods');
		//返回数据和翻页
		$data = $model->search();
		// dump($data);
		$this->assign($data);
		//取出所有的分类做下拉框
		$catModel = new \Admin\Model\CategoryModel();
		$catData = $catModel->getTree();
		// 设置页面信息
		$this->assign(array(
			'catData' => $catData,
			'_page_title' => '商品列表',
			'_page_btn_name' => '商品添加',
			'_page_btn_link' => U('goodsAdd'),
			));
		$this->display();
	}

	//商品修改
	public function goodsEdit() {
		$id = I('get.id');	//要修改的商品ID
		$model = D('goods');
		if (IS_POST) {
			if ($model->create(I('post.'), 2)) {
				if (FALSE !== $model->save()) {		
					$this->success('操作成功 ！',U('goodsList'));
					exit;
				}
			}
			$error = $model->getErroe();
			$this->error($error);
		}
		//根据ID取出要修改的商品原信息
		$data = $model->find($id);
		$this->assign('data',$data);

		//取出所有的会员级别
		$mlModel = new \Admin\Model\MemberLevelModel();
		$mlData = $mlModel->select();

		//取出这件商品已经设置好的会员价格
		$mpModel = D('member_price');
		$mpData = $mpModel->where(array(
			'goods_id'=>array('eq',$id),
		))->select();
		//把取出来的二维数组转一维数组
		$_mpData = array();
		foreach ($mpData as $k => $v) {
			$_mpData[$v['level_id']] = $v['price'];
		}

		//取出相册中现有的相片
		$gpModle = D('goods_pic');
		$gpData = $gpModle->field('id,mid_pic')->where(array(
			'goods_id' => array('eq',$id),
		))->select();

		//取出所有的分类做下拉框
		$catModel = new \Admin\Model\CategoryModel();
		$catData = $catModel->getTree();

		//取出拓展分类ID
		$gcModel = D('goods_cat');
		$gcData = $gcModel->where(array(
			'goods_id' => array('eq',$id),
		))->select();

		//取出这件商品已经设置了的属性值
		// $gaModel = D('goods_attr');
		// $gaData = $gaModel->alias('a')
		// ->field('a.*,b.attr_name,b.attr_type,b.attr_option_values')
		// ->join('LEFT JOIN __ATTRIBUTE__ b ON a.attr_id=b.id')
		// ->where(array(
		// 	'a.goods_id' => array('eq', $id),
		// ))->select();
		
		//取出当前类型下所有的属性
		$attrModel = new \Admin\Model\AttributeModel();
		$attrData = $attrModel->alias('a')
		->field('a.id attr_id,a.attr_name,a.attr_type,a.attr_option_values,b.attr_value,b.id')
		->join('LEFT JOIN __GOODS_ATTR__ b ON  (a.id=b.attr_id AND b.goods_id='.$id.')')
		->where(array(
			'a.type_id' => array('eq',$data['type_id']),
		))->select();
		//设置页面信息
		$this->assign(array(
			'attrData' => $attrData,
			'gcData' => $gcData,
			'catData' => $catData,
			'mpData' => $_mpData,
			'mlData' => $mlData,
			'gpData' => $gpData,
			'_page_title' => '修改商品',
			'_page_btn_name' => '商品列表',
			'_page_btn_link' => U('goodsList'),
			));
		$this->display();
	}

	//商品删除
	public function delete(){
		$model = D('goods');
		if (FALSE !== $model->delete(I('get.id'))) {
			$this->success('删除成功!',U('goodsList'));
		} else {
			$this->error('删除失败!原因:'.$model->getError());
		}
	}

	//处理AJAX删除图片的请求
	public function ajaxDelPic() {
		$picId = I('get.picid');
		//根据ID从硬盘上数据删除中删除图片
		$gpModle = D('goods_pic');
		$pic = $gpModle->field('pic,sm_pic,mid_pic,big_pic')->find($picId);
		//从硬盘删除图片
		deleteImage($pic);
		//从数据库中删除记录
		$gpModle->delete($picId);
	}

	//处理获取属性的AJAX请求
	public function ajaxGetAttr() {
		$typeId = I('get.type_id');
		$attrModel = new \Admin\Model\AttributeModel();
		$attrData = $attrModel->where(array(
			'type_id' => array('eq', $typeId),
		))->select();
		echo json_encode($attrData);
		// dump($attrData);
		// die;
	}

	//处理ajax删除属性
	public function ajaxDelAttr() {
		$goodsId = addslashes(I('get.goods_id'));
		$gaid = addslashes(I('get.gaid'));
		$gaModel = D('goods_attr');
		$gaModel->delete($gaid);
		//删除相关库存量数据
		// $gnModel = D('goods_number');
		// $gnModel->where(array(
		// 	'goods_id' => array('EXP', "=$goodsId or AND FIND_IN_SET($gaid, attr_list)"),
		// ))->delete();
	}

	//商品库存量
	public function goods_number() {
		header('Content-Type:text/html;charset=utf8');
		//接收商品ID
		$id = I('get.id');
		$gnModel = D('goods_number');
		//处理表单
		if (IS_POST) {
			// dump($_POST);
			$gaid = I('post.goods_attr_id');
			$gn = I('post.goods_number');
			//先计算商品属性ID和库存量的比例
			$gaidCount = count($gaid);
			$gnCount = count($gn);
			$rate = $gaidCount/$gnCount;
			// dump($rate);
			// die;
			// 循环库存量
			$_i = 0;	//取第几个商品属性ID
			foreach ($gn as $k => $v) {
				$_goodsAttrId = array();	//把下面取出来的ID放这里
				//后来从商品属性ID数组中取出$rate个，循环一次取一个
				for ($i=0; $i < $rate; $i++) { 
					$_goodsAttrId[] = $gaid[$_i];
					$_i++;
				}
				//先升序排列
				sort($_goodsAttrId,SORT_NUMERIC);	//以数字的形势排序
				//把取出来的商品属性ID转化成字符串
				$_goodsAttrId = (string)implode(',', $_goodsAttrId);
				// dump($_goodsAttrId);die;
				$gnModel->add(array(
					'goods_id' => $id,
					'goods_attr_id' => $_goodsAttrId,
					'goods_number' => $v,
				));
			}
			$this->success('设置成功!',U('goods_number?id='.I('get.id')));
			exit;
		}

		//根据商品ID取出这件商品所有可选属性的值
		$gaModel = D('goods_attr');
		$gaData = $gaModel->alias('a')
		->field('a.*,b.attr_name')
		->join('LEFT JOIN __ATTRIBUTE__ b ON a.attr_id=b.id')
		->where(array(
			'a.goods_id' => array('eq', $id),
			'b.attr_type' => array('eq', '可选'),
		))->select();
		//处理这个二维数组：转化成三维：把属性相同的放到一起
		$_gaData = array();
		foreach ($gaData as $k => $v) {
			$_gaData[$v['attr_name']][] = $v;
		}
		// dump($_gaData);
		
		//先取出这件商品已经设置过的库存量
		$gnData = $gnModel->where(array(
			'goods_id' => $id,
		))->select();
		// dump($gnData);die;
		$this->assign(array(
			'gnData' => $gnData,
			'gaData' => $_gaData,
			'_page_title' => '库存量',
			'_page_btn_name' => '返回列表',
			'_page_btn_link' => U('goodsList'),
		));
		//显示表单
		$this->display();
	}
}








