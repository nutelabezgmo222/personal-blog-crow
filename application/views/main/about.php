<header class="masthead">
    <div class="container">
          <div class="page-heading">
                <h2>Я Максик из Пи-436</h2>
                <span class="subheading">Учусь в ХРТК</span>
          </div>
    </div>
</header>
<div class="container about">
    <p>Я люблю:</p>
    <ul>
      <li>Дыни</li>
      <li>Помидоры</li>
      <li>Сок бананово-яблочно-клубничный</li>
    </ul>
    <?php if(! isset($_SESSION['user_id'])): ?>
      <p><a class="comment_auth" href="/blogg/login">Авторизуйтесь что бы отправить мне сообщение</a></p>
    <?php else: ?>
    <form class="form_ajax form" method="post">
      <div class="form_row">
        <h3>Для связи со мной :)</h3>
      </div>
      <div class="form_row">
        <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
        <textarea id="contact_area" rows=3 class="comment_body" name="message" placeholder="Написать сообщение"></textarea>
      </div>
      <div class="form_row">
        <button id="contact_button" type="submit" class="submit" name="button">Отправить</button>
      </div>
    </form>
  <?php endif; ?>
</div>
