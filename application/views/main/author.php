<header class="masthead">
  <div class="site_heading">
      <h3 id="tag"><?php echo $title . " " . $list[0]['pseudonym']; ?></h1>
  </div>
</header>
<div class="container">
    <div class="author_container">
          <?php if (empty($list)): ?>
                <p>Список постов пуст</p>
          <?php else: ?>
              <ul class="author_posts">
                <?php foreach ($list as $val): ?>
                  <div class="author_post">
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
</div>
