<?php

namespace application\controllers;

use application\core\Controller;
use application\lib\Pagination;
use application\models\Admin;

class MainController extends Controller {

	public function indexAction() {
		$pagination = new Pagination($this->route, $this->model->postsCount());
		$vars = [
			'list' => $this->model->postsList(),
			'slider' => $this->model->sliderList(),
			'headerAside' => $this->model->asideList(),
		];
		$this->view->render('Главная страница', $vars);
	}

	public function tagAction() {
		$tag = 'news';
		$rTag = "Новости";
		$newMax = false;
		if(!empty($_GET)){
			switch($_GET['tag']) {
				case 'medicine': $tag = 'medicine'; $rTag = "Медицина"; break;
				case 'sport'   : $tag = 'sport'; $rTag = "Спорт"; break;
				case 'politics': $tag = 'politics'; $rTag = "Политика"; break;
			}
		}
		$_SESSION['usr_records_number'] = isset($_SESSION['usr_records_number']) ? $_SESSION['usr_records_number'] : 5;
		$max = $_SESSION['usr_records_number'];
		if(!empty($_POST)) {
				$_SESSION['usr_records_number'] = intval($_POST['records_number']);
				$max = intval($_POST['records_number']);
				$newMax = true;
		}
		$pagination = new Pagination($this->route, $this->model->tagPostsCount($tag), $max);
		$vars = [
			'pagination' => $pagination->get($tag),
			'list' => $this->model->postsTag($this->route, $tag, $max),
		];
		if($newMax) $this->view->redirect('blogg/tag/1?tag='.$_GET['tag']);
		$this->view->render($rTag, $vars);
	}

	public function aboutAction() {
		if(!empty($_POST)){
			if(!$this->model->messageValidate($_POST)){
				$this->view->message('error', $this->model->error);
			}
			if($this->model->newMessage($_POST)){
				$this->view->message('success','Ваше сообщение отправлено!');
			}
		}
		$this->view->render('Обо мне');
	}

	public function contactAction() {
		if (!empty($_POST)) {
			if (!$this->model->contactValidate($_POST)) {
				$this->view->message('error', $this->model->error);
			}
			mail('titef@p33.org', 'Сообщение из блога', $_POST['name'].'|'.$_POST['email'].'|'.$_POST['text']);
			$this->view->message('success', 'Сообщение отправлено Администратору');
		}
		$this->view->render('Контакты');
	}

	public function postAction() {
		$adminModel = new Admin;
		if (!$adminModel->isPostExists($this->route['id'])) {
			$this->view->errorCode(404);
		}
		$temp = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
		$vars = [
			'data' => $this->model->postData($this->route['id'])[0],
			'tags' => $this->model->postTags($this->route['id'])[0],
			'comments' => $this->model->postComments($this->route['id']),
			'user_post' => $this->model->userPostsId($this->route['id'], $temp),
			'aside_content' => $this->model->postAside($this->route['id']),
		];
		$this->view->render('Пост', $vars);

	}

	public function loginAction() {
		if (isset($_SESSION['user'])) {
			$this->view->redirect('/');
		}
		if (!empty($_POST)) {
			$user = $this->model->loginValidate($_POST);
			if (!$user) {
				$this->view->message("error","Логин или пароль введены неверно");
			}
			if($user[0]['role_id']==1) {
				$_SESSION['admin'] = true;
				$_SESSION['new_messages'] = $this->model->countMess();
			}
			if($user[0]['role_id']==3){
				$_SESSION['editor'] = true;
			}
			$_SESSION['user_id'] = $user[0]['user_id'];
			$_SESSION['user_name'] = $user[0]['pseudonym'];
			if(isset($_GET['post'])) {
				$this->view->location('blogg/post/'.$_GET['post']);
			}
			$this->view->location('blogg/');
		}
		$this->view->render('Вход');
	}
	public function registerAction() {
		if(!empty($_POST)) {
			if(!$this->model->registerValidate($_POST)){
				$this->view->message('error',$this->model->error);
			}else {
				if(!$this->model->registration($_POST)) {
					$this->view->message('error',"Упс что-то пошло не так");
				}
				$this->view->message('success','Вы успешно зарегистрировались!');
				$this->view->redirect('blogg/');
			}
		}
		$this->view->render('Регистрация');
	}
	public function logoutAction() {
		unset($_SESSION['user_id']);
		unset($_SESSION['user_name']);
		if( isset($_SESSION['admin']) ) {
			unset($_SESSION['admin']);
		}
		if( isset($_SESSION['editor']) ) {
			unset($_SESSION['editor']);
		}
		$this->view->redirect('blogg/');
	}

	public function dashboardAction() {
		$tags = ['news','sport','medicine','politics'];
		$vars = [
			'tags' => $tags,
			'list' => $this->model->userPosts($_SESSION['user_id']),
		];
		$this->view->render("Профиль",$vars);
	}
	public function settingsAction() {
		if(!empty($_POST)) {
			if(!$this->model->userInfoValidate($_POST)) {
				$this->view->message('error',$this->model->error);
			}else {
				$this->model->userInfoAdd($_POST, $_SESSION['user_id']);
				$this->view->location('blogg/profile/settings');
			}
		}
		$vars = [
			'user' => $this->model->userInfo($_SESSION['user_id'])[0],
		];
		$this->view->render("Профиль", $vars);
	}
	public function notificationsAction() {
		$vars = [];
		$this->view->render("Профиль",$vars);
	}
	public function authorAction() {
		if (!$this->model->isAuthorExist($this->route['id'])) {
			$this->view->errorCode(404);
		}
		$vars = [
			'list' => $this->model->authorPosts($this->route['id']),
		];
		$this->view->render("Посты от", $vars);
	}

}
