<?php

namespace application\models;

use application\core\Model;

class Main extends Model {

	public $error;

	public function contactValidate($post) {
		$nameLen = iconv_strlen($post['name']);
		$textLen = iconv_strlen($post['text']);
		if ($nameLen < 3 or $nameLen > 20) {
			$this->error = 'Имя должно содержать от 3 до 20 символов';
			return false;
		} elseif (!filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
			$this->error = 'E-mail указан неверно';
			return false;
		} elseif ($textLen < 10 or $textLen > 500) {
			$this->error = 'Сообщение должно содержать от 10 до 500 символов';
			return false;
		}
		return true;
	}

	public function loginValidate($post) {
		$login = $post['login'];
		$password = $post['password'];
		$params = [
			'login' => $login,
			'password' => $password,
		];
		return $this->db->row('SELECT * FROM users WHERE login = :login AND pass = :password', $params);
	}

	public function registerValidate($post) {
		if( iconv_strlen($post['login']) < 3 or iconv_strlen($post['login']) > 10 ) {
			$this->error = "Логин должен быть от 3 до 10 символов";
			return false;
		}
		if( iconv_strlen($post['pseudonym']) < 3 or iconv_strlen($post['pseudonym']) > 16 ) {
			$this->error = "Псевдоним должен быть от 3 до 16 символов";
			return false;
		}
		if( iconv_strlen($post['password']) < 4 or iconv_strlen($post['password']) > 16) {
			$this->error = "Пароль должен быть от 4 до 16 символов";
			return false;
		}
		if( $post['password'] !== $post['repassword'] ){
			$this->error = "Пароли не совпадают";
			return false;
		}
		$params = [
			'login' => $post['login'],
		];
		$users = $this->db->column('SELECT COUNT(user_id) FROM users WHERE login = :login',$params);
		if($users) {
			$this->error = "Данный логин уже занят выберите другой";
			return false;
		}
		return true;
	}
	public function messageValidate($post) {
		if( iconv_strlen($post['message']) < 3 or iconv_strlen($post['message']) > 1000 ) {
			$this->error = "Сообщение должно быть от 3 до 1000 символов";
			return false;
		}
		return true;
	}
	public function newMessage($post) {
		$params = [
			'user_id' => $post['user_id'],
			'message' => $post['message'],
		];
		return $this->db->query('INSERT INTO messages VALUES(NULL, :user_id, :message, NOW(), 0)', $params);
	}
	public function registration($post) {
		$params = [
			'user_id' => '',
			'role_id' => '2',
			'login' => $post['login'],
			'pseudonym' => $post['pseudonym'],
			'pass' => $post['password'],
		];
		return $this->db->query('INSERT INTO users VALUES(:user_id, :role_id, :login, :pass, :pseudonym, NULL, NULL, NULL, NULL)', $params);
	}
	public function postsCount() {
		return $this->db->column('SELECT COUNT(id) FROM posts');
	}
	public function tagPostsCount($tag) {
		$tags = ['news','sport','medicine','politics'];
		$tag_id = array_search($tag,$tags) + 1;
		$params = [
			'tag_id' => $tag_id,
		];
		return $this->db->column('SELECT COUNT(id) FROM posts p JOIN posts_tags pt ON pt.post_id = p.id WHERE pt.tag_id = :tag_id',$params);
	}

	public function postsList() {

		$sql = 'SELECT * FROM tags';
		$sql = $this->db->query($sql);
		$tags = $sql->fetchAll();
		$articles = [];

		foreach ($tags as $tag) {
		  $sql = "SELECT * FROM (posts p JOIN posts_tags pt On pt.post_id = p.id) JOIN tags t ON t.tag_id = pt.tag_id WHERE pt.tag_id =". $tag['tag_id']." ORDER BY id DESC LIMIT 6";
			$sql = $this->db->query($sql);
		  array_push($articles, $sql->fetchAll());
		}

		return $articles;
	}
	public function sliderList($tag = null){
 		if(is_null($tag)){
			return $this->db->row('SELECT p.id, p.post_name, p.description FROM ((posts p JOIN posts_tags pg ON p.id = pg.post_id)
			 JOIN tags tg ON tg.tag_id = pg.tag_id) LIMIT 3');
		}else {
			$tags = ['news','sport','medicine','politics'];
			$tag_id = array_search($tag,$tags) + 1;
			$params = [
				'tag_id' => $tag_id,
			];
			return $this->db->row('SELECT p.id, p.post_name, p.description FROM ((posts p JOIN posts_tags pg ON p.id = pg.post_id)
			 JOIN tags tg ON tg.tag_id = pg.tag_id) WHERE tg.id=:tag_id DESC LIMIT 3', $params);
		}
	}
	public function postsTag($route, $tag, $max) {
		$tags = ['news','sport','medicine','politics'];
		$tag_id = array_search($tag,$tags) + 1;
		$params = [
			'max' => $max,
			'start' => ((($route['page'] ?? 1) - 1) * $max),
			'tag_id' => $tag_id,
		];
		return $this->db->row('SELECT * FROM ((posts p JOIN posts_tags pg ON p.id = pg.post_id)
		 JOIN tags tg ON tg.tag_id = pg.tag_id) WHERE tg.tag_id = :tag_id ORDER BY p.id DESC LIMIT :start, :max', $params);
	}
	public function userPosts($user) {
		$params = [
			'user_id' => $user,
		];
		return $this->db->row('SELECT * FROM ((users_posts up JOIN posts p ON p.id = up.post_id) JOIN posts_tags pt ON pt.post_id = p.id
			JOIN tags t ON t.tag_id = pt.tag_id) WHERE up.up_user_id =:user_id ',$params);
	}
	public function userPostsId($id, $user) {
		$params = [
			'post_id' => $id,
			'user_id' => $user,
		];
		return $this->db->row('SELECT * FROM users_posts WHERE up_user_id = :user_id AND post_id = :post_id',$params);
	}

	public function userInfo($id) {
		$params = [
			'id' => $id,
		];
		return $this->db->row('SELECT * FROM users WHERE user_id = :id', $params);
	}

	public function userInfoValidate($post) {
		if($post['name'] != ''){
			if(iconv_strlen($post['name'])<2 or iconv_strlen($post['name'])>25 ) {
				$this->error = 'Длина имена должна быть от 2 до 25 символом';
				return false;
			}
		}
		if($post['surname'] != '') {
			if( iconv_strlen($post['surname'])<2 or iconv_strlen($post['surname'])>25 ) {
				$this->error = 'Длина фамилии должна быть от 2 до 25 символом';
				return false;
			}
		}
		return true;
	}
	public function userInfoAdd($post, $id) {
		$params = [
			'user_id' => $id,
			'name' => $post['name'],
			'surname' => $post['surname'],
			'gender' => $post['gender'],
			'birthday' => date_format(date_create($post['birthday']),'Y-m-d'),
		];
		return $this->db->query('UPDATE users SET u_name = :name, u_surname = :surname, u_gender = :gender, u_birthday = :birthday WHERE user_id = :user_id ', $params);
	}
	public function postAside($id) {
		$randTag = rand(1,4);
		$randOrder = rand(0,1);
		$params = [
			'id' => $id,
			'tag' => $randTag,
		];
		if($randOrder == 1) {
			return $this->db->row('SELECT * FROM posts p JOIN posts_tags pt ON pt.post_id = p.id WHERE id!=:id AND pt.tag_id=:tag ORDER BY p.id ASC LIMIT 4',$params);
		}
		return $this->db->row('SELECT * FROM posts p JOIN posts_tags pt ON pt.post_id = p.id WHERE id!=:id AND pt.tag_id=:tag ORDER BY p.id DESC LIMIT 4',$params);
	}

	public function tagsList() {
		return $this->db->row('SELECT * FROM tags');
	}

	public function asideList() {
		$params = [];
		return $this->db->row('SELECT * FROM (posts p JOIN posts_tags pt ON p.id = pt.post_id) JOIN tags t ON pt.tag_id = t.tag_id ORDER BY id DESC LIMIT 4');
	}

	public function postData($id) {
		$params = [
			'id' => $id,
		];
		return $this->db->row('SELECT * FROM posts p JOIN users u ON u.user_id = p.user_id  WHERE id = :id', $params);
	}

	public function postTags($id) {
		$params = [
			'id' => $id,
		];
		return $this->db->row('SELECT * FROM posts_tags pt JOIN tags t ON t.tag_id = pt.tag_id  WHERE pt.post_id = :id', $params);
	}
	public function postComments($id) {
		$params = [
			'id' => $id,
		];
		return $this->db->row('SELECT * FROM comments c JOIN users u ON c.user_id = u.user_id WHERE c.post_id = :id ORDER BY c.comment_id DESC', $params);
	}
	public function authorPosts($id) {
		$params = [
			'id' => $id,
		];
		return $this->db->row('SELECT * FROM posts p JOIN users u ON u.user_id = p.user_id WHERE p.user_id = :id',$params);
	}
	public function isAuthorExist($id) {
		return $this->db->column('SELECT COUNT(user_id) FROM posts WHERE user_id = ' . $id);
	}
	public function countMess() {
		return $this->db->column('SELECT COUNT(m_id) FROM messages WHERE m_is_read = 0');
	}
}
