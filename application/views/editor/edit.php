<div class="card_body">
  <div class="card_header"><?php echo $title; ?></div>
  <form class="form_ajax form edit_form" action="/blogg/admin/edit/<?php echo $data['id']; ?>" method="post" enctype="multipart/form_data" >
      <div class="form_group">
      <label>Название</label>
        <input class="form_control" type="text" value="<?php echo htmlspecialchars($data['post_name'], ENT_QUOTES); ?>" name="name">
        </div>
      <div class="form_group">
        <label>Описание</label>
        <input class="form_control" type="text" value="<?php echo htmlspecialchars($data['description'], ENT_QUOTES); ?>" name="description">
      </div>
      <div class="form_group">
        <label>Текст</label>
        <textarea class="form_control" rows="3" name="text"><?php echo htmlspecialchars($data['text'], ENT_QUOTES); ?></textarea>
      </div>
      <div class="form_group">
        <label>Изображение</label>
        <input class="form_control" type="file" name="img">
      </div>
      <div class="form_group">
        <button type="submit" class="submit">Сохранить</button>
      </div>
      <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
  </form>
</div>
