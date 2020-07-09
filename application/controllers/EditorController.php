<?php

namespace application\controllers;

use application\core\Controller;
use application\lib\Pagination;
use application\models\Main;

class EditorController extends Controller {

	public function __construct($route) {
		parent::__construct($route);
		$this->view->layout = 'editor';
	}
	public function checkAction(){

	}
	public function addAction() {
		$mainModel = new Main;
		$vars = [
			'tags' => $mainModel->tagsList(),
		];
		if (!empty($_POST)) {
			if (!$this->model->postValidate($_POST, 'add')) {
				$this->view->message('error', $this->model->error);
			}
			$id = $this->model->postAdd($_POST);
			if (!$id) {
				$this->view->message('error', 'Ошибка обработки запроса');
			}else {
				$filePath  = $_FILES['img']['tmp_name'];
				$image = getimagesize($filePath);
				$extension = image_type_to_extension($image[2]);
				$format = str_replace('jpeg', 'jpg', $extension);
				if (!move_uploaded_file($filePath, "C:\\xampp\\htdocs\\blogg\\public\\materials\\" . $id . $format)) {
				    $this->view->message('error', 'Произошла ошибка при добавление фона');
				}
				$this->view->message('success', 'Пост добавлен');
				$this->view->location('blogg/post/'.$id);
			}
		}else {
		$this->view->render('Добавить пост',$vars);
	}
	}

	public function editAction() {
		if (!$this->model->isPostExists($this->route['id'])) {
			$this->view->errorCode(404);
		}
		if (!$this->model->isPostYours($_SESSION['user_id'], $this->route['id'])) {
			$this->view->errorCode(403);
		}
		if (!empty($_POST)) {
			if (!$this->model->postValidate($_POST, 'edit')) {
				$this->view->message('error', $this->model->error);
			}
			if (!$this->model->postEdit($_POST)) {
				$this->view->message('error', 'Ошибка обработки запроса');
			}
			if(file_exists($_FILES['img']['tmp_name']) || is_uploaded_file($_FILES['img']['tmp_name'])) {
				$filePath  = $_FILES['img']['tmp_name'];
				$image = getimagesize($filePath);
				$extension = image_type_to_extension($image[2]);
				$format = str_replace('jpeg', 'jpg', $extension);
				if (!move_uploaded_file($filePath, "C:\\xampp\\htdocs\\blogg\\public\\materials\\" . $_POST['id'] . $format)) {
				    $this->view->message('error', 'Произошла ошибка при добавление фона');
				}
			}
			$this->view->message('success', 'Пост изменен!');
		}
		$vars = [
			'data' => $this->model->postDataById($this->route['id'])[0],
		];
		$this->view->render('Редактировать пост', $vars);
	}

	public function deleteAction() {
		if (!$this->model->isPostExists($this->route['id'])) {
			$this->view->errorCode(404);
		}
		$this->model->postDelete($this->route['id']);
		$this->view->redirect('blogg/admin/posts');
	}

	public function postsAction() {
		$newMax = false;
		$editor = $_SESSION['user_id'];
		$_SESSION['admin_tag'] = isset($_SESSION['admin_tag']) ? $_SESSION['admin_tag'] : null;
		$_SESSION['records_number'] = isset($_SESSION['records_number']) ? $_SESSION['records_number'] : 5;
		$tag = $_SESSION['admin_tag'];
		$max = $_SESSION['records_number'];
		if(!empty($_POST)) {
			$_SESSION['records_number'] = intval($_POST['records_number']);
			$_SESSION['admin_tag'] = $_POST['tag'];
			$tag = $_POST['tag'];
			$max = intval($_POST['records_number']);
			$newMax = true;
		}
		$pagination = new Pagination($this->route, $this->model->postsCount($editor, $tag), $max);
		$vars = [
			'pagination' => $pagination->get(),
			'tags' => $this->model->tagsList(),
			'list' => $this->model->postData($editor, $this->route, $tag, $max),
		];
		if($newMax) $this->view->redirect('blogg/editor/posts');
		$this->view->render('Посты', $vars);
	}


}
