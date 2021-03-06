<?php
//会员级别控制器
//命名空间
namespace Admin\Controller;
// use Think\Controller;
class MemberLevelController extends BaseController{
	//增加会员级别
	public function memberLevelAdd() {
		//两个逻辑，显示和添加
		if (IS_POST) {
			$model = new \Admin\Model\MemberLevelModel();
			if ($model->create(I('post.'),1)) {
				if ($model->add()) {
					$this->success('添加会员级别成功',U('memberLevelList'));
					exit;
				} else {
					$error = $model->getError();
					$this->error($error);
				}
			}			
		} else {
			$this->assign(array(
				'_page_title' => '会员级别列表添加',
				'_page_btn_name' => '会员列表',
				'_page_btn_link' => U('memberLevelList')
				));
			$this->display();
		}
	}
	//显示会员列表
	public function memberLevelList() {
		$model = new \Admin\Model\MemberLevelModel();
		$data = $model->select();
		$this->assign('data',$data);
		$this->assign(array(
			'_page_title' => '会员级别列表',
			'_page_btn_name' => '添加会员级别',
			'_page_btn_link' => U('memberLevelAdd'),
			));
		$this->display();
	}

	//修改会员列表
	public function memberLevelEdit() {
		$id = I('get.id');
		$model = new \Admin\Model\MemberLevelModel();
		if (IS_POST) {
			if ($model->create(I('post.'),2)) {
				if (FALSE !== $model->save()) {
					$this->success('修改会员级别成功!',U('memberLevelList'));
					exit;
				} else{
					$error = $model->getError();
					$this->error($error);
				}	
			}		
		} else {
			$data = $model->find($id);
			$this->assign('data',$data);
			$this->assign(array(
				'_page_title' => '修改会员列表',
				'_page_btn_name' => '会员级别列表',
				'_page_btn_link' => U('memberLevelList'),
				));
			$this->display();
		}
	}

	//删除会员列表
	public function delete() {
		$model = new \Admin\Model\MemberLevelModel();
		if (FALSE !== $model->delete(I('get.id'))) {
			$this->success('删除会员级别成功!!',U('memberLevelList'));
			exit;
		} else {
			$error = $model->getError();
			$this->error($error);
		}
	}
}





