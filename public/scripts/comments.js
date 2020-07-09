$(document).ready(function(){
    $('button.comment-add').on('click', function(){
      let commentName = document.getElementById('comment-name');
      let commentBody = document.getElementById('comment-body');
      let userName = document.getElementById('user-name');
      let postId = document.getElementById('post-id');
      let comment = {
        post_id: postId.value,
        user_name: userName.value,
        user_id: commentName.value,
        text: commentBody.value,
        comment_date: timeConverter(Math.floor(Date.now()/1000)),
      };
      if(comment['text']!=''){
        $.ajax({
            method: "POST",
            url: "/blogg/public/php/phpHelper.php",
            data: {
              post_id: comment['post_id'],
              user_id: comment['user_id'],
              content: comment['text'],
              comment_date: comment['comment_date'],
           }
         });
        commentBody.value = '';
        showComments(comment);
      }else{
        alert('Поле для ввода комментария должно содержать сообщение');
      }
    })
})

function showComments(item){
  let commentField = document.getElementById('comment-field');
  let out = '';
  out += `<div class="comment">`;
  out += `<span class="comment_header">${item.user_name}</span>`;
  if(item.user_id == 1){
    out += `<span><small> *Админ* </small><span>`;
  }
  out += `<span class="comment_date">${item.comment_date}</span>`;
  out += `<p class="comment_content">${item.text}</p>`;
  out += `<span id="comment_complain" class="comment_complain"><a href="#complain"><small>Пожаловаться</small></a></span>`;
  out += `</div>`;
  commentField.innerHTML = out + commentField.innerHTML;
}

function timeConverter(UNIX_timestamp) {
  var a = new Date(UNIX_timestamp * 1000);
  var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
  var year = a.getFullYear();
  var month = a.getMonth()+1;
  var date = a.getDate();
  var hour = a.getHours();
  var min = a.getMinutes();
  var sec = a.getSeconds();
  var time = year + '-0' + month + '-' + date + ' ' + hour + ':' + min + ':' + sec;
  return time;
}
