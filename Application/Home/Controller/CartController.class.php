<?php
//前台购物车控制器
//命名空间
namespace Home\Controller;
use Think\Controller;

class CartController extends Controller {
	public function add() {
		if (IS_POST) {
			// dump($_POST);
			// dump(session('m_id'));
			$cartModel = new \Home\Model\CartModel();
			if ($cartModel->create(I('post.'),1)) {
				// $test = $cartModel->add();
				// dump($test);die;
				if ($cartModel->add()) {
					$this->success('添加成功!',U('cartList'));
					exit;
				} else {
					$this->error('添加失败,原因:'.$cartModel->getError());
				}
			} else {
				$this->error('添加失败，原因：'.$cartModel->getError());
			}
		}
	}

	//购物车列表页
	public function cartList() {
		header('Content-Type:text/html;charset=utf-8');
		$cartModel = new \Home\Model\CartModel();
		$data = $cartModel->cartList();
		// dump($data);die;
		//设置页面信息
		$this->assign(array(
			'data' => $data,
			'_page_title' => '购物车列表',
			'_page_keywords' => '购物车列表',
			'_page_description' => '购物车列表',
			));
		$this->display();
	}

	//ajax获取购物车
	public function ajaxCartList() {
		$cartModel = new \Home\Model\CartModel();
		$data = $cartModel->cartList();
		echo json_encode($data);
	}

}








