<header class="header">
  <div class="header_date">
    <span> <?php echo date("l ,d F"); ?></span>
  </div>
  <div class="header_content_box">
    <div class="slidershow middle">
      <div class="slides">
        <input type="radio" name="r" id="r1">
        <input type="radio" name="r" id="r2">
        <input type="radio" name="r" id="r3">
        <input type="radio" name="r" id="r4">
        <div class="slide s1">
          <div class="slide__background" style="background-image:url('/blogg/public/images/1.jpg')">
            <div class="slide__header"><span>Добро пожаловать на блог Crow</span></div>
          </div>
        </div>
        <?php if (empty($slider)): ?>
            <p>Список постов пуст</p>
        <?php else: ?>
            <?php foreach ($slider as $val): ?>
              <div class="slide">
                <div class="slide__background" style="background-image:url('/blogg/public/materials/<?php echo $val['id'].'.jpg';?>')">
                  <a class="slide__header" href="/blogg/post/<?php echo $val['id'];?>"><?php echo htmlspecialchars($val['post_name'], ENT_QUOTES);?></a>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      <div class="navigation">
        <label for="r1" class="bar"></label>
        <label for="r2" class="bar"></label>
        <label for="r3" class="bar"></label>
        <label for="r4" class="bar"></label>
      </div>
    </div>
  </div>
  <div class="header_aside_info">
    <?php for ($i=0 ; $i < 4; $i++):?>
      <a href="/blogg/post/<?php echo $headerAside[$i]['id']; ?>" class="header_aside_content"
         style="background-image:url('/blogg/public/materials/<?php echo $headerAside[$i]['id'].'.jpg';?>')">
        <div class="header_aside_header">
        <?php echo htmlspecialchars($headerAside[$i]['post_name'], ENT_QUOTES);?>
        </div>
      </a>
  <?php endfor; ?>
  </div>
</div>
</header>

<main>
  <div class="main_content_box">

    <?php if (empty($list)): ?>
        <p>Список постов пуст</p>
    <?php else: ?>
        <?php foreach ($list as $articles): ?>
  <div class="articles_by_tag">
    <h3 class="tag_header"> <?php echo $articles[0]['tag_name']; ?> </h3>
    <div class="articles_articles">
    <?php foreach ($articles as $article):?>
      <article class="article__container article_background" style="background-image:url('/blogg/public/materials/<?php echo $article['id'].'.jpg';?>')">
        <a class="article_link" href="/blogg/post/<?php echo $article['id']; ?>" >
          <h2><?php echo htmlspecialchars($article['post_name'], ENT_QUOTES); ?></h2>
          <div class="article__description"><span><?php echo htmlspecialchars($article['description'], ENT_QUOTES); ?></span></div>
          <div class="article__tag"><span><?php echo $article['tag_name'];?></span></div>
          <div class="article__hr"></div>
        </a>
      </article>
    <?php endforeach; ?>
    </div>
</div>
  <?php endforeach; ?>
  <?php endif; ?>
  </div>
</main>
