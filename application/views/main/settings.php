<div class="container">
  <div class="profile_header">
      <ul>
        <li><a href="/blogg/profile/dashboard"> Мои материалы </a></li>
        <li class="profile_active"><a href="/blogg/profile/settings"> Настройки аккаунта </a></li>
        <li><a href="/blogg/profile/notifications"> Уведомления </a></li>
      </ul>
  </div>
  <main>
    <div class="main_content_box settings">
      <h2>Настройки аккаунта</h2>
      <h3>Личные данные</h3>
      <form class="form_ajax settings_form" action="" method="post">
        <div class="form_group">
          <label for="name">Имя</label>
          <input id="name" class="input_livelable" type="text" value="<?php echo isset($user['u_name'])?$user['u_name']:''; ?>" name="name" placeholder="Имя">
        </div>
        <div class="form_group">
          <label for="surname">Фамилия</label>
          <input id="surname" class="input_livelable" type="text" name="surname" value="<?php echo isset($user['u_surname'])?$user['u_surname']:''; ?>"  placeholder="Фамилия">
        </div>
        <div class="form_group">
          <label for="gender">Пол</label>
          <select id="gender" class="input_livelable" name="gender" placeholder="Пол">
            <option <?php echo ($user['u_gender']=='0')?'selected':'';?> value="0">Пол</option>
            <option <?php echo ($user['u_gender']=='1')?'selected':''; ?> value="1">Мужчина</option>
            <option <?php echo ($user['u_gender']=='2')?'selected':''; ?> value="2">Женщина</option>
          </select>
        </div>
        <div class="form_group">
          <label for="birthday">День рождения</label>
          <input id="birthday" class="input_livelable" value="<?php echo isset($user['u_birthday'])?$user['u_birthday']:''; ?>" max="<?php echo date('Y-m-d'); ?>" type="date" name="birthday" value="" placeholder="Дата рождения">
        </div>
        <div class="form_group">
          <button class="primary-btn settings_button" type="submit" name="button">Сохранить</button>
        </div>
      </form>
    </div>
  </main>
</div>
