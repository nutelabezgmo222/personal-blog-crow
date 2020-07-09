<div class="card_body">
  <div class="card_header"><?php echo $title.' '; ?><span><?php echo $message['pseudonym']; ?></span><span class="back"> <a href="/blogg/admin/messages">Назад</a></span> </div>
  <div class="card_inner">
    <div class="user_img">
      <a href="/blogg/admin/user/<?php echo $message['user_id']; ?>">
      <img width=150 height=150 src="/blogg/public/images/user.png" alt="user_img">
      </a>
    </div>
    <div class="message_content">
    <small><?php echo $message['m_date']; ?></small>
    <p><?php echo $message['message']; ?></p>
    </div>
  </div>
</div>
