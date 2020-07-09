<?php

namespace application\models;

use application\core\Model;
use Imagick;

class Admin extends Model {

	public $error;

	public function loginValidate($post) {
		$config = require 'application/config/admin.php';
		if ($config['login'] != $post['login'] or $config['password'] != $post['password']) {
			$this->error = 'Логин или пароль указан неверно';
			return false;
		}
		return true;
	}

	public function postValidate($post, $type) {
		$nameLen = iconv_strlen($post['name']);
		$descriptionLen = iconv_strlen($post['description']);
		$textLen = iconv_strlen($post['text']);

		$limitBytes  = 1024 * 1024 * 5;
		$limitWidth  = 600;
		$limitHeight = 320;

		if ($nameLen < 3 or $nameLen > 100) {
			$this->error = "Название статьи должно быть от 3 до 100 символов";
			return false;
		} elseif ($descriptionLen < 3 or $descriptionLen > 100) {
			$this->error = 'Описание должно содержать от 3 до 100 символов';
			return false;
		} elseif ($textLen < 10 or $textLen > 5000) {
			$this->error = 'Текст должнен содержать от 10 до 5000 символов';
			return false;
		}
		if(file_exists($_FILES['img']['tmp_name']) || is_uploaded_file($_FILES['img']['tmp_name']) || $type=="add" ){
			if(!file_exists($_FILES['img']['tmp_name']) || !is_uploaded_file($_FILES['img']['tmp_name'])) {
				$this->error = "Пожалуйста выберите фон для статьи";
				return false;
			}else {
				$fi = finfo_open(FILEINFO_MIME_TYPE);
				$filePath  = $_FILES['img']['tmp_name'];
				$mime = (string) finfo_file($fi, $filePath);
				$image = getimagesize($filePath);
				if (strpos($mime, 'image') === false) {
					$this->error = "Можно загружать только картинки";
					return false;
				}
				if (filesize($filePath) > $limitBytes) {
					$this->error = "Размер картинки превышает 5 Мбаит";
					return false;
				}
				if ($image[1] < $limitHeight) {
					$this->error = "Высота картинки должна быть больше 320px";
					return false;
				}
				if ($image[0] < $limitWidth) {
					$this->error = "Ширина картинки должна быть больше 600px";
					return false;
				}
			}
		}
		return true;
	}

	public function postAdd($post) {
		$params = [
			'id' => '',
			'user_id' => $post['user_id'],
			'name' => $post['name'],
			'description' => $post['description'],
			'text' => $post['text'],
			'date' => date("Y-m-d"),
		];
		$this->db->query('INSERT INTO posts VALUES (:id, :user_id, :description, :text, :name, :date)', $params);
		$post_id = $this->db->lastInsertId();
		$posts_tags = [
			'id' => '',
			'post_id' => $post_id,
			'tag_id' => $post['tag'],
		];
		$this->db->query('INSERT INTO posts_tags VALUES (:id, :post_id, :tag_id)', $posts_tags);
		return $post_id;
	}

	public function postEdit($post) {
		$params = [
			'id' => $post['id'],
			'name' => $post['name'],
			'description' => $post['description'],
			'text' => $post['text'],
		];
		return $this->db->query('UPDATE posts SET post_name = :name, description = :description, text = :text WHERE id = :id', $params);
	}

	public function postUploadImage($path, $id) {
		$img = new Imagick($path);
		$img->cropThumbnailImage(1080, 600);
		$img->setImageCompressionQuality(80);
		$img->writeImage('public/materials/'.$id.'.jpg');
	}

	public function isPostExists($id) {
		$params = [
			'id' => $id,
		];
		return $this->db->column('SELECT id FROM posts WHERE id = :id', $params);
	}

	public function postDelete($id) {
		$params = [
			'id' => $id,
		];
	  $this->db->query('DELETE FROM posts_tags WHERE post_id = :id', $params);
		$this->db->query('DELETE FROM posts WHERE id = :id', $params);
		unlink('public/materials/'.$id.'.jpg');
	}
	public function postData($route, $tag = null, $max = 5) {
			$params_all = [
				'max' => $max,
				'start' => ( ($route['page'] ?? 1) - 1 ) * $max,
			];
			$params_tag = [
				'tag_id' => $tag,
				'max' => $max,
				'start' => ( ($route['page'] ?? 1) - 1 ) * $max,
			];
			if( $tag == null or $tag  == 0  ) {
					return $this->db->row('SELECT * FROM posts p JOIN posts_tags pt ON pt.post_id = p.id ORDER BY p.id DESC LIMIT :start, :max', $params_all);
			}
			return $this->db->row('SELECT * FROM posts p JOIN posts_tags pt ON pt.post_id = p.id WHERE pt.tag_id=:tag_id ORDER BY p.id DESC LIMIT :start, :max', $params_tag);
	}
	public function postDataById($id) {
		$params = [
			'id' => $id,
		];
		return $this->db->row('SELECT * FROM posts WHERE id = :id', $params);
	}
	public function postsCount($tag = null){
		if( $tag == null or $tag  == 0 ) {
			return $this->db->column('SELECT COUNT(id) FROM posts');
		}
		return $this->db->column('SELECT COUNT(p.id) FROM posts p JOIN posts_tags pt ON p.id = pt.post_id WHERE pt.tag_id ='.$tag);
	}
	public function tagsList() {
		return $this->db->row('SELECT * FROM tags');
	}

	public function usersCount($role) {
		if( $role == null or $role == 0) {
			return $this->db->column('SELECT COUNT(user_id) FROM users WHERE role_id != 1');
		}
		return $this->db->column('SELECT COUNT(user_id) FROM users WHERE role_id = ' . $role);
	}
	public function rolesList() {
		return $this->db->row('SELECT * FROM role');
	}
	public function usersList($route, $role = null, $max = 5) {
		$params_all = [
			'this_user' => $_SESSION['user_id'],
			'max' => $max,
			'start' => ( ($route['page'] ?? 1) - 1 ) * $max,
		];
		$params_role = [
			'role' => $role,
			'this_user' => $_SESSION['user_id'],
			'max' => $max,
			'start' => ( ($route['page'] ?? 1) - 1 ) * $max,
		];
		if ( $role == null or $role == 0) {
			return $this->db->row('SELECT * FROM users WHERE user_id != :this_user  ORDER BY user_id DESC LIMIT :start, :max', $params_all);
		}
		return $this->db->row('SELECT * FROM users WHERE user_id != :this_user AND role_id = :role ORDER BY user_id DESC LIMIT :start, :max', $params_role);
	}
	public function userInfo($route) {
		return $this->db->row('SELECT * FROM users u JOIN role r ON r.id = u.role_id WHERE u.user_id = ' . $route['id']);
	}
	public function userToEditor($user_id){
		$params = [
			'id' => $user_id,
		];
		return $this->db->query('UPDATE users SET role_id = 3 WHERE user_id = :id', $params);
	}
	public function editorToUser($user_id) {
		$params = [
			'id' => $user_id,
		];
		return $this->db->query('UPDATE users SET role_id = 2 WHERE user_id = :id', $params);
	}
	public function removeUser($id) {
		$params = [
			'id' => $id,
		];
		$this->db->query('UPDATE posts SET user_id = 1 WHERE user_id = :id', $params);
		$this->db->query('DELETE FROM comments WHERE user_id = :id', $params);
		$this->db->query('DELETE FROM users_posts WHERE up_user_id = :id', $params);
		$this->db->query('DELETE FROM messages WHERE user_id = :id', $params);
		return $this->db->query('DELETE FROM users WHERE user_id = :id', $params);
	}
	public function getMessages() {
		return $this->db->row('SELECT * FROM messages m JOIN users u ON u.user_id = m.user_id ORDER BY m.m_is_read ASC');
	}
	public function getMessage($id) {
		$params = [
			'id' => $id,
		];
		return $this->db->row('SELECT * FROM messages m JOIN users u ON u.user_id = m.user_id WHERE m.m_id = :id ORDER BY m.m_is_read ASC',$params);
	}
	public function readMessage($id) {
		$params = [
			'id' => $id,
		];
		return $this->db->query('UPDATE messages SET m_is_read = 1 WHERE m_id = :id', $params);
	}
	public function deleteMessage($id) {
		$params = [
			'id' => $id,
		];
		return $this->db->query('DELETE FROM messages WHERE m_id = :id', $params);
	}

}
