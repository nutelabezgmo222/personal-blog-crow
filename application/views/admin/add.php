            <div class="card_body">
                <div class="card_header"><?php echo $title; ?> </div>
                <div class="row">
                        <form class="form_ajax form add_form" action="/blogg/admin/add" method="post" enctype="multipart/form_data">
                            <div class="form_group">
                                <label>Название</label>
                                <input placeholder="Название статьи..." class="form_control" type="text" name="name">
                            </div>
                            <div class="form_group">
                                <label>Описание</label>
                                <input placeholder="Описание статьи..." class="form_control" type="text" name="description">
                            </div>
                            <div class="form_group">
                                <label>Текст</label>
                                <textarea placeholder="Текст статьи..."class="form_control" rows="3" name="text"></textarea>
                            </div>
                            <div class="form_group">
                                <label>Тег</label>
                                <select class="form_control" name="tag">
                                  <?php
                                  foreach($vars['tags'] as $tag):
                                    echo "<option value=" . $tag['tag_id'] .">". $tag['tag_name'] . "</option>";
                                  endforeach;?>
                                </select>
                            </div>
                            <div class="form_group">
                                <label>Изображение</label>
                                <input class="form_control" type="file" name="img">
                            </div>
                            <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                            <div class="form_group">
                              <button type="submit" class="submit">Добавить</button>
                            </div>
                        </form>
                </div>
            </div>
