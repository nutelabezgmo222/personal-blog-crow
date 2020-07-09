<div class="card_body">
  <form class="filter_form" action="" method="post">
    <div class="form_col">
      <div class="form_group">
        <label for="filter_tag">По категории</label>
        <select id="filter_tag" class="" name="tag">
          <option <?php if($_SESSION['admin_tag']==0) echo 'selected'; ?>value="0">Все</option>
          <?php foreach ($tags as $tag ):?>
          <option <?php echo ($tag['tag_id'] == $_SESSION['admin_tag'])? 'selected' : ''; ?>value="<?php echo $tag['tag_id'] ?>"><?php echo $tag['tag_name']; ?></option>
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
  <?php if (empty($list)): ?>
      <p>Список постов пуст</p>
  <?php else: ?>
      <table class="admin_table">
        <thead>
          <tr>
              <th id="name">Название</th>
              <th id="data">Дата</th>
              <th>Редактировать</th>
              <th>Удалить</th>
          </tr>
        </thead>
        <tbody id="list">
          <?php foreach ($list as $val): ?>
              <tr>
                  <td><a href='/blogg/post/<?=$val['id']?>'><?php echo htmlspecialchars($val['post_name'], ENT_QUOTES); ?></td>
                  <td><?php echo $val['post_date']; ?></td>
                  <td><a href="/blogg/admin/edit/<?php echo $val['id']; ?>" class="edit_btn">Редактировать</a></td>
                  <td><a href="/blogg/admin/delete/<?php echo $val['id']; ?>" class="delete_btn">Удалить</a></td>
              </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <div class="pagination">
        <?php echo $pagination; ?>
      </div>
  <?php endif; ?>
</div>
