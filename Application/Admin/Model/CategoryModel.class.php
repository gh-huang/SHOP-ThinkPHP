<?php
//商品分类模型类
//命名空间
namespace Admin\Model;
use Think\Model;

class CategoryModel extends Model {
	protected $insertFields = array('cat_name','parent_id');
	protected $updateFields = array('id','cat_name','parent_id');
	protected $_validate = array(
		array('cat_name','require','分类名称不能为空!',1,'regex',3),
	);
	//找一个分类所有子分类的ID
	public function getChildren($catId) {
		//取出所有的分类
		$data = $this->select();
		//递归从所有的分类中挑出子分类的ID
		return $this->_getChildren($data, $catId, TRUE);
	}

	private function _getChildren($data, $catId, $isClear = FALSE) {
		static $_ret = array();		//保存找到的子分类的ID
		if ($isClear) {
			$_ret = array();
		} else {
			//循环所有的分类找子分类
			foreach ($data as $k => $v) {
				if ($v['parent_id'] == $catId) {
					$_ret[] = $v['id'];
					//再找这个$v的子分类
					$this->_getChildren($data,$v['id']);
				}
			}
			return $_ret;
		}
	}

	public function getTree() {
		$data = $this->select();
		return $this->_getTree($data);
	}

	private function _getTree($data, $parent_id=0, $level=0) {
		static $_ret = array();
		foreach ($data as $k => $v) {
			if ($v['parent_id'] == $parent_id) {
				$v['level'] = $level;	//用来标记这个分类是第几级的
				$_ret[] = $v;
				//找子类
				$this->_getTree($data,$v['id'],$level+1);
			}
		}
		return $_ret;
	}


}















