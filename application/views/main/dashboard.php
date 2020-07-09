<div class="container">
  <div class="profile_header">
      <ul>
        <li class="profile_active"><a href="/blogg/profile/dashboard"> Мои материалы </a></li>
        <li><a href="/blogg/profile/settings"> Настройки аккаунта </a></li>
        <li><a href="/blogg/profile/notifications"> Уведомления </a></li>
      </ul>
  </div>
  <main>
  <div class="profile_content">
    <div class="main_content_box">
          <?php if (empty($list)): ?>
              <p>Список постов пуст</p>
          <?php else: ?>
          <div class="profile_articles">
              <?php foreach ($list as $article): ?>
            <article class="profile_article">
            <a class="profile_remove" value="<?php echo $article['id']."|".$_SESSION['user_id']; ?>" href="#">X</a>
            <div class="profile_article_header"><a href="/blogg/tag/1?tag=<?php echo $tags[$article['tag_id']-1]; ?>"><span><?php echo $article['tag_name'];?>
            </span></a> - <span><?php echo $article['post_date']; ?></span></div>
              <a class="article_link" href="/blogg/post/<?php echo $article['id']; ?>" >
                <img src="/blogg/public/materials/<?php echo $article['id']; ?>.jpg" alt="article_img">
              </a>
              <a class="article_link" href="/blogg/post/<?php echo $article['id']; ?>.jpg" >
                  <h2><?php echo $article['post_name']; ?></h2>
              </a>
              <div class="article_description">
                <p><?php echo $article['description']; ?></p>
              </div>
            </article>
          <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </main>
</div>
