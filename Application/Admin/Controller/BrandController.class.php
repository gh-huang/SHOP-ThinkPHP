<?php
//后台品牌控制器
//命名空间
namespace Admin\Controller;
use Think\Controller;

class BrandController extends Controller{

	//品牌添加
	public function brandAdd() {
		//判读用户是否提交了表单
		if (IS_POST) {
			$model = new \Admin\Model\BrandModel();
			// $model = D('Brand');
			//create方法接收post过来的数据
			if ($model->create(I('post.'), 1)) {
				if ($model->add()) {
					//添加成功跳转到品牌列表
					$this->success('添加品牌成功！！',U('brandList'));
					exit;
				}
			} else {
				//获取错误信息
				$error = $model->getError();
				//输出错误信息
				$this->error($error);
			}
		} else {
			$this->assign(array(
				'_page_title' => '添加品牌',
				'_page_btn_name' => '品牌列表',
				'_page_btn_link' => U('brandList'),
				));
			$this->display();
		}
	}

	//品牌列表
	public function brandList() {
		echo "这里是品牌列表";
	}
}