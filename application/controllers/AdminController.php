<?php

namespace application\controllers;

use application\core\Controller;
use application\lib\Pagination;
use application\models\Main;

class AdminController extends Controller {

	public function __construct($route) {
		parent::__construct($route);
		$this->view->layout = 'admin';
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

	public function logoutAction() {
		unset($_SESSION['admin']);
		$this->view->redirect('blogg/admin/login');
	}

	public function postsAction() {
		$newMax = false;
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
		$pagination = new Pagination($this->route, $this->model->postsCount($tag), $max);
		$vars = [
			'pagination' => $pagination->get(),
			'tags' => $this->model->tagsList(),
			'list' => $this->model->postData($this->route, $tag, $max),
		];
		if($newMax) $this->view->redirect('blogg/admin/posts');
		$this->view->render('Посты', $vars);
	}
	public function usersAction() {
		$newMax = false;
		$_SESSION['user_role'] = isset($_SESSION['user_role']) ? $_SESSION['user_role'] : null;
		$_SESSION['records_number'] = isset($_SESSION['records_number']) ? $_SESSION['records_number'] : 5;
		$role = $_SESSION['user_role'];
		$max = $_SESSION['records_number'];
		if(!empty($_POST)) {
			$_SESSION['records_number'] = intval($_POST['records_number']);
			$_SESSION['user_role'] = $_POST['role'];
			$role = $_POST['role'];
			$max = intval($_POST['records_number']);
			$newMax = true;
		}
		$pagination = new Pagination($this->route, $this->model->usersCount($role), $max);
		$vars = [
			'pagination' => $pagination->get(),
			'roles' => $this->model->rolesList(),
			'users' => $this->model->usersList($this->route, $role, $max),
		];
		if($newMax) $this->view->redirect('blogg/admin/users');
		$this->view->render('Пользователи', $vars);
	}
	public function userAction() {
		if(!empty($_POST)){
			if($_POST['user_role']==2) {
				$this->model->userToEditor($_POST['user_id']);
			}elseif($_POST['user_role']==3){
				$this->model->editorToUser($_POST['user_id']);
			}
		}
		$vars = [
			'user' => $this->model->userInfo($this->route)[0],
		];
		$this->view->render("Пользователь", $vars);
	}
	public function removeAction() {
		$this->model->removeUser($this->route['id']);
		$this->view->redirect('blogg/admin/users');
	}
	public function messagesAction(){
		$vars = [
			'messages' => $this->model->getMessages(),
		];
		$newMessages = 0;
		foreach ($vars['messages'] as $message) {
			if($message['m_is_read'] == 0) $newMessages++;
		}
		$_SESSION['new_messages'] = $newMessages;
		$this->view->render('Сообщения',$vars);
	}
	public function messageAction() {
		$vars = [
			'message' => $this->model->getMessage($this->route['id'])[0],
		];
		if($vars['message']['m_is_read'] == 0) {
			$this->model->readMessage($this->route['id']);
		}
		$this->view->render('Сообщение от ', $vars);
	}
	public function messageDeleteAction() {
			$this->model->deleteMessage($this->route['id']);
			$this->view->redirect('blogg/admin/messages');
	}
}
