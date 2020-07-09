<?php

namespace application\models;

use application\core\Model;
use Imagick;

class Editor extends Model {

	public $error;

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
	public function isPostYours($user_id, $id) {
		$params = [
			'user_id' => $user_id,
			'id' => $id,
		];
		return $this->db->column('SELECT id FROM posts WHERE id = :id AND user_id = :user_id', $params);
	}

	public function postDelete($id) {
		$params = [
			'id' => $id,
		];
	  $this->db->query('DELETE FROM posts_tags WHERE post_id = :id', $params);
		$this->db->query('DELETE FROM posts WHERE id = :id', $params);
		unlink('public/materials/'.$id.'.jpg');
	}
	public function postData($user_id, $route, $tag = null, $max = 5) {
			$params_all = [
				'max' => $max,
				'start' => ( ($route['page'] ?? 1) - 1 ) * $max,
				'user_id' => $user_id,
			];
			$params_tag = [
				'tag_id' => $tag,
				'max' => $max,
				'start' => ( ($route['page'] ?? 1) - 1 ) * $max,
				'user_id' => $user_id,
			];
			if( $tag == null or $tag  == 0  ) {
					return $this->db->row('SELECT * FROM posts p JOIN posts_tags pt ON pt.post_id = p.id WHERE p.user_id = :user_id ORDER BY p.id DESC LIMIT :start, :max', $params_all);
			}
			return $this->db->row('SELECT * FROM posts p JOIN posts_tags pt ON pt.post_id = p.id WHERE p.user_id = :user_id AND pt.tag_id=:tag_id ORDER BY p.id DESC LIMIT :start, :max', $params_tag);
	}
	public function postDataById($id) {
		$params = [
			'id' => $id,
		];
		return $this->db->row('SELECT * FROM posts WHERE id = :id', $params);
	}
	public function postsCount($user_id ,$tag = null){
		if( $tag == null or $tag  == 0 ) {
			return $this->db->column('SELECT COUNT(id) FROM posts WHERE id='.$user_id);
		}
		return $this->db->column('SELECT COUNT(p.id) FROM posts p JOIN posts_tags pt ON p.id = pt.post_id WHERE p.id='.$user_id.
		' AND pt.tag_id ='.$tag);
	}
	public function tagsList() {
		return $this->db->row('SELECT * FROM tags');
	}

}
