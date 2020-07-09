<div class="card_body">
  <div class="card_header"><?php echo $title.' '; ?><span><?php echo $user['pseudonym']; ?></span> </div>
  <div class="card_inner">
    <div class="user_img">
      <img width=150 height=150 src="/blogg/public/images/user.png" alt="user_img">
    </div>
    <div class="user_info">
      <p>Логин: <?php echo $user['login']; ?></p>
      <p>Имя: <?php echo $user['u_name'] ? $user['u_name'] : 'Не указано'; ?></p>
      <p>Фамилия: <?php echo $user['u_surname'] ? $user['u_surname'] : 'Не указано'; ?></p>
      <p>Пол: <?php echo $user['u_gender'] ? ($user['u_gender']==1 ? "Мужчина" : "Женщина") : 'Не указано'; ?></p>
      <p>Дата рождения: <?php echo $user['u_birthday'] ? $user['u_birthday'] : 'Не указано'; ?></p>
      <p>Роль: <?php echo $user['name']; ?></p>
    </div>
  </div>
  <div class="card_op">
    <form class="" action="" method="post">
      <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
      <input type="hidden" name="user_role" value="<?php echo $user['role_id']; ?>">
      <?php if($user['role_id'] == 2):  ?>
      <button type="submit" class="edit_btn" name="button">Дать статус редактора</button>
    <?php elseif($user['role_id'] == 3): ?>
      <button type="submit" class="delete_btn" name="button">Убрать статус редактора</button>
    <?php endif; ?>
    </form>
  </div>
</div>
