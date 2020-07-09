<div class="card_body">
  <div class="card_header"><?php echo $title; ?> </div>
  <?php if (empty($messages)): ?>
      <p>У вас нет новых сообщений :(</p>
  <?php else: ?>
    <div class="messages">
      <?php foreach ($messages as $message): ?>
        <div class="message <?php if ($message['m_is_read'] == 0) echo "new_message"; ?>">
          <a href="/blogg/admin/messages/<?php echo $message['m_id']; ?>" class="message_inner">
          <div class="user_img">
            <img width=75 height=75 src="/blogg/public/images/user.png" alt="user_img">
          </div>
          <div class="message_body">
            <p class="message_header"><?php echo $message['pseudonym'].' '.$message['m_date']; ?></p>
            <p class="message_text"><?php echo $message['message']; ?></p>
          </div>
          </a>
          <a class="message_delete" href="/blogg/admin/messages/delete/<?php echo $message['m_id']; ?>">X</a>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>
