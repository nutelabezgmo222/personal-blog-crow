<div class="card_body">
  <form class="filter_form" action="" method="post">
    <div class="form_col">
      <div class="form_group">
        <label id="data" for="filter_tag">По категории</label>
        <select id="filter_tag" class="" name="role">
          <option <?php if($_SESSION['user_role']==0) echo 'selected'; ?>value="0">Все</option>
          <?php foreach ($roles as $role ):?>
          <option <?php echo ($role['id'] == $_SESSION['user_role'])? 'selected' : ''; ?>value="<?php echo $role['id'] ?>"><?php echo $role['name']; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
      <div class="form_col">
        <div class="form_group">
          <label>Количество записей на странице</label>
          <select class="" name="records_number">
            <option <?php  if($_SESSION['records_number']==2) echo 'selected'; ?> value="2">2</option>
            <option <?php  if($_SESSION['records_number']==5 or !isset($_SESSION['records_number'])) echo 'selected'; ?> value="5">5</option>
            <option <?php  if($_SESSION['records_number']==10) echo 'selected'; ?> value="10">10</option>
            <option <?php  if($_SESSION['records_number']==15) echo 'selected'; ?> value="15">15</option>
            <option <?php  if($_SESSION['records_number']==99) echo 'selected'; ?> value="99">Все</option>
          </select>
        </div>
      </div>
    <div class="form_col">
      <div class="form_group">
        <button type="submit" class="filter_button" name="button">Подтвердить</button>
      </div>
    </div>
  </form>
  <div class="card_header"><?php echo $title; ?> </div>
  <?php if (empty($users)): ?>
      <p>Список постов пуст</p>
  <?php else: ?>
      <table class="admin_table">
        <thead>
          <tr>
              <th id="name">Логин</th>
              <th>Псевдоним</th>
              <th>Профиль пользователя</th>
              <th>Удалить аккаунт</th>
          </tr>
        </thead>
        <tbody id="list">
          <?php foreach ($users as $val): ?>
              <tr>
                  <td><a href='/blogg/post/<?=$val['user_id']?>'><?php echo htmlspecialchars($val['login'], ENT_QUOTES); ?></td>
                  <td><?php echo $val['pseudonym']; ?></td>
                  <td><a href="/blogg/admin/user/<?php echo $val['user_id']; ?>" class="edit_btn">Профиль</a></td>
                  <td><a href="/blogg/admin/user/remove/<?php echo $val['user_id']; ?>" class="delete_btn">Удалить</a></td>
              </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <div class="pagination">
        <?php echo $pagination; ?>
      </div>
  <?php endif; ?>
</div>
