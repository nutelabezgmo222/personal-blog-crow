<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title><?php echo $title; ?></title>
        <link rel="stylesheet" href="/blogg/public/css/style.css">
        <link rel="stylesheet" href="/blogg/public/css/admin.css">
        <link href="https://fonts.googleapis.com/css?family=Inria+Serif|Ma+Shan+Zheng|Oswald&display=swap" rel="stylesheet">
    </head>
    <body>
      <header>
      <div class="wrapper">
        <div class="header__nav">
          <div class="content_box">
            <div class="logo">
              <a href="#">
                <span>Панель Редактора</span>
              </a>
            </div>
            <nav>
              <ul class="menu">
                <li><a href="/blogg/tag">Новости</a></li>
                <li><a href="/blogg/tag?tag=medicine">Медицина</a></li>
                <li><a href="/blogg/tag?tag=sport">Спорт</a></li>
                <li><a href="/blogg/tag?tag=politics">Политика</a></li>
                <li><a href="/blogg/about">О редакторе</a></li>
                <?php  if (!isset($_SESSION['user_name'])) {?>
                <li><a href="/blogg/login">Войти</a></li>
              <?php } else {?>
                <li class="menu-item">
                    Добро пожаловать  <?php echo $_SESSION['user_name'];?>
                  <div class="menu-dropdown">
                    <?php if(isset($_SESSION['editor'])): ?>
                    <a href="/blogg/editor/add">Редактор</a>
                    <?php endif; ?>
                    <a href="/blogg/profile/dashboard">Посты</a>
                    <a href="/blogg/about">Сообщения</a>
                    <a href="/blogg/logout">Выйти</a>
                  </div>
                </li>
              <?php }?>
              </ul>
            </nav>
          </div>
        </div>
      </header>
      <main>
        <div class="admin_right_panel">
          <div class="admin_menu">
            <li class="item" id="profile">
              <a href="#profile" class="btn">Посты</a>
              <div class="smenu">
                <a href="/blogg/editor/posts" >Все посты</a>
                <a href="/blogg/editor/add" >Добавить</a>
                <a href="/blogg/editor/posts" >Редактировать</a>
              </div>
            </li>
            <li class="item" id="messages">
              <a href="#messages" class="btn">Сообщения</a>
              <div class="smenu">
                <a href="/blogg/about" >Написать</a>
                <a href="#" >Новые</a>
                <a href="#" >Спам</a>
              </div>
            </li>
            <li class="item" id="settings">
              <a href="#settings" class="btn">Профиль</a>
              <div class="smenu">
                <a href="/blogg/profile/settings" >Настройки</a>
                <a href="/blogg/logout" >Выйти</a>
              </div>
            </li>
          </div>
        </div>
        <?php echo $content; ?>
      </main>
        <hr>
        <footer class="footer">
          <div class="content_box">
              <div class="footer__nav">
                <nav>
                  <ul>
                    <li><a href="/blogg/tag">Новости</a></li>
                    <li><a href="/blogg/tag?tag=medicine">Медицина</a></li>
                    <li><a href="/blogg/tag?tag=sport">Спорт</a></li>
                    <li><a href="/blogg/tag?tag=politics">Политика</a></li>
                  </ul>
                </nav>
              </div>
              <hr>
              <div class="footer_contacts">
                  <h3>Контакты</h3>
                  <ul>
                      <li><a href="tel:880553535"><img src="/blogg/public/images/telephone.png" alt="telnumber"> 880553535</a></li>
                      <li><a href="mailto:info@oldboy.com"><img src="/blogg/public/images/mail.png" alt="mail"> solodovnikov.masimka@blogger.com</a></li>
                      <li><img src="/blogg/public/images/adress.png" alt="adress"> ул. Героев Труда, 7а</li>
                  </ul>
              </div>
              <span>Copyright © 2019 CROW. The CROW is not responsible for the content of external sites. Read about our approach to external linking.</span>
          </div>
        </footer>
       </div>
       <script src="/blogg/public/scripts/jquery-3.4.1.min.js"></script>
       <script src="/blogg/public/scripts/form.js"></script>
       <script src="/blogg/public/scripts/comments.js"></script>
       <script src="/blogg/public/scripts/customSettings.js"></script>
       <script src="/blogg/public/scripts/admin.js"></script>
      </body>
</html>
