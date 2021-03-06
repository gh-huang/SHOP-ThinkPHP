<?php
//前台评论控制器
//命名空间
namespace Home\Controller;
use Think\Controller;

class CommentController extends Controller{
	//AJAX发表评论
	public function addComment() {
		if (IS_POST) {
			$model = new \Admin\Model\CommentModel();
			if ($model->create(I('post.'),1)) {
				if ($model->add()) {
					$this->success(array(
						'face' => session('face'),
						'username' => session('m_username'),
						'addtime' => date('Y-m-d H:i:s'),
						'content' => I('post.content'),
						'star' => I('post.star'),
						),'',TRUE);
					exit;
				} else {
					$this->error($model->getError(),'',TRUE);
				}
			} else {
				$this->error($model->getError(),'',TRUE);
			}
		}
	}

	//AJAX获取评论
	public function ajaxGetComment() {
		$goodsId = I('get.goodsId');
		$model = new \Admin\Model\CommentModel();
		$data = $model->search($goodsId,5);
		// dump($data);die();
		echo json_encode($data);
	}

	//AJAX回复
	public function reply() {
		if (IS_POST) {
			$model = D('Admin/CommentReply');
			if ($model->create(I('post.'),1)) {
				if ($model->add()) {
					$this->success(array(
						'face' => session('face'),
						'username' => session('m_username'),
						'addtime' => date('Y-m-d H:i:s'),
						'content' => I('post.content'),
						));
				}
			} else {
				$this->error($model->getError());
			}
		}
	}

}










