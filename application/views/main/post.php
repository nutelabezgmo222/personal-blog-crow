<header class="masthead">
    <div class="container post_header_container">
          <div class="page-heading">
                 <div class="post_tags">
                     <span><?php echo $tags['tag_name']; ?></span>
                 </div>
                  <h2><?php echo htmlspecialchars($data['post_name'], ENT_QUOTES); ?></h2>
                  <a href="/blogg/author/<?php echo $data['user_id']; ?>" class="post-author">By <?php echo $data['pseudonym']; ?></a>
                  <p class="auhtor-comment">CROW news</p>
                  <form class="favorite_form" action="" method="post">
                    <button style="display:<?php echo $user_post?'none':'inline-block'?>" class="favorite add" type="button" name="favorite" value="<?php echo isset($_SESSION['user_id'])?'add':'authorize'; ?>"> Добавить в мою ленту</button>
                    <button style="display:<?php echo $user_post?'inline-block':'none'?>" id="remove" class="favorite delete" type="button" name="favorite" value="delete"> Добавлено </button>
                    <a  style="display: <?php echo $user_post?'inline-block':'none'?>" href="/blogg/profile/dashboard" class="favorite" name="favorite"> Перейти в "Мою ленту" </a>
                    <input type="hidden" id="post-id" name="post_id" value="<?php echo $data['id']; ?>">
                    <input type="hidden" id="user-id" name="user_id" value="<?php echo isset($_SESSION['user_id'])?$_SESSION['user_id']:0; ?>">
                    <div class="favorite_authorize">
                      <span class="modal_close">X</span>
                      <p>Сохраняйте новости и статьи,<br> что бы прочитать их позже</p>
                      <a class="primary-btn" href="/blogg/login?post=<?php echo $data['id'];?>">Авторизоваться</a>
                    </div>
                  </form>
                  <div class="post-img">
                    <img width=600 height=400 src="/blogg/public/materials/<?php echo $data['id']; ?>.jpg" alt="Main picture">
                    <div class="img-alt">Description for img</div>
                  </div>
                  <p class="subheading"><?php echo htmlspecialchars($data['description'], ENT_QUOTES); ?></p>
          </div>
          <div class="post_header_aside">
            <h2>Смотрите также!</h2>
            <?php foreach ($aside_content as $adv): ?>
              <div class="post_header">
                <a href="/blogg/post/<?php echo $adv['id']; ?>"class="adv_a">
                  <img src="/blogg/public/materials/<?php echo $adv['id']; ?>.jpg" alt="Main picture">
                  <div class="adv_header">
                    <?php echo htmlspecialchars($adv['post_name'], ENT_QUOTES); ?>
                  </div>
                </a>
              </div>
            <?php endforeach; ?>
        </div>
</header>
<div class="container">
      <div class="text-content">
          <p><?php echo $data['text']; ?></p>
      </div>
    <div class="comments">
      <div class="middle">
        <h3>Комментарии</h3>
        <form class="form_ajax comment_form" action="" method="post">
          <div class="form_row">
            <?php if(isset($_SESSION['user_name'])): ?>
            <input type="hidden" name="" id="comment-name" value="<?php echo $_SESSION['user_id']; ?>">
            <input type="hidden" name="" id="user-name" value="<?php echo $_SESSION['user_name']; ?>">
          </div>
            <div class="form_row">
              <textarea rows=3 class="comment_body" id="comment-body" name="comment-body" placeholder="Оставить комментарий"></textarea>
            </div>
            <div class="form_row comment-submit-field">
              <button type="submit" class="comment-add submit" id="comment-add" name="button">Оставить комментарий</button>
              <button type="button" class="comment-clear" id="comment-clear" name="button">Отмена</button>
            </div>
          <?php else: ?>
            <a class="comment_auth" href="/blogg/login?post=<?php echo $data['id'];?>">Авторизуйтесь что бы оставлять комментарии</a>
          <?php endif; ?>
        </form>
        <div id="comment-field" class="comment_field">
          <?php foreach ($comments as $comment): ?>
            <div class="comment">
              <span class="comment_header"><?php echo $comment['pseudonym']; ?></span>
              <?php if ($comment['role_id'] == 1): ?>
              <span><small>*Админ*</small><span>
              <?php elseif($comment['user_id'] == $data['user_id']): ?>
              <span><small>*Автор*</small><span>
              <?php endif; ?>
              <span class="comment_date"><?php echo $comment['comment_date']; ?></span>
              <p class="comment_content"><?php echo $comment['text']; ?></p>
              <span id="comment_complain" class="comment_complain"><a href="#complain"><small>Пожаловаться</small></a></span>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
</div>
