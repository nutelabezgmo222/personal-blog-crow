<header class="masthead">
  <div class="site_heading">
      <h3 id="tag"><?php if(isset($list[0]['tag_name'])) echo $list[0]['tag_name'];?></h1>
  </div>
</header>
<div class="container">
    <div class="row">
      <form class="filter_form" action="" method="post">
        <div class="form_col">
          <div class="form_group">
            <label for="">Поиск</label>
            <input id="elastic" class="el_input" type="text" name="" value="">
          </div>
        </div>
          <div class="form_col">
            <div class="form_group">
              <label>Количество записей на странице</label>
              <select class="" name="records_number">
                <option <?php  if($_SESSION['usr_records_number']==2) echo 'selected'; ?> value="2">2</option>
                <option <?php  if($_SESSION['usr_records_number']==5) echo 'selected'; ?> value="5">5</option>
                <option <?php  if($_SESSION['usr_records_number']==10) echo 'selected'; ?> value="10">10</option>
                <option <?php  if($_SESSION['usr_records_number']==15) echo 'selected'; ?> value="15">15</option>
                <option <?php  if($_SESSION['usr_records_number']==99) echo 'selected'; ?> value="99">Все</option>
              </select>
            </div>
          </div>
        <div class="form_col">
          <div class="form_group">
            <button type="submit" class="filter_button" name="button">Подтвердить</button>
          </div>
        </div>
      </form>
            <?php if (empty($list)): ?>
                <p>Список постов пуст</p>
            <?php else: ?>
              <ul class="tag_posts elastic">
                <?php foreach ($list as $val): ?>
                  <div class="tag_post">
                    <a href="/blogg/post/<?php echo $val['id']; ?>">
                      <img src="/blogg/public/materials/<?php echo $val['id']; ?>.jpg" alt="post-img">
                    </a>
                    <li class="post-preview">
                        <a href="/blogg/post/<?php echo $val['id']; ?>">
                          <h2 class="post-title"><?php echo htmlspecialchars($val['post_name'], ENT_QUOTES); ?></h2>
                          <h5 class="post-subtitle"><?php echo htmlspecialchars($val['description'], ENT_QUOTES); ?></h5>
                          <div class="tag_article__hr"></div>
                        </a>
                      </li>
                  </div>
                <?php endforeach; ?>
               </ul>
          <?php endif; ?>
    </div>
    <div class="pagination">
      <?php echo $pagination; ?>
    </div>
</div>
