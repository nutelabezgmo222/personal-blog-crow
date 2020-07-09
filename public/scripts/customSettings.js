//changecolor
let root = document.querySelector(':root');
let rootStyles = getComputedStyle(root);
let mainColor = rootStyles.getPropertyValue('--tag_menu_color');
  let tag = document.getElementById('tag');
  if(tag !== null ) {
    let tagVal = tag.innerHTML;

    switch(tagVal) {
      case "Новости": root.style.setProperty('--tag_menu_color', '#27ae60'); break;
      case "Медицина": root.style.setProperty('--tag_menu_color', '#ff0000'); break;
      case "Спорт": root.style.setProperty('--tag_menu_color', '#ff0066'); break;
      case "Политика": root.style.setProperty('--tag_menu_color', '#ff00bf'); break;
      default:  root.style.setProperty('--tag_menu_color', 'tomato');
    }
  }
  //Elastic
  if (document.querySelector('#elastic')) {
    document.querySelector('#elastic').oninput = function() {
      let val = this.value.trim();
      let elasticItems = document.querySelectorAll('.elastic .tag_post');
      if(val != ''){
        elasticItems.forEach(function(elem){
          let temp = elem.childNodes[3].childNodes[1].childNodes[1].innerText;
          if(temp.search(val) == -1) {
            elem.classList.add('hide');
            elem.childNodes[3].childNodes[1].childNodes[1].innerHTML = elem.childNodes[3].childNodes[1].childNodes[1].innerText;
          }else {
            elem.classList.remove('hide');
            let str = elem.childNodes[3].childNodes[1].childNodes[1].innerText;
            elem.childNodes[3].childNodes[1].childNodes[1].innerHTML = insertMark(str, elem.childNodes[3].childNodes[1].childNodes[1].innerText.search(val), val.length );
          }
        });
      } else{
        elasticItems.forEach(function(elem){
          elem.classList.remove('hide');
          elem.childNodes[3].childNodes[1].childNodes[1].innerHTML = elem.childNodes[3].childNodes[1].childNodes[1].innerText;
        });
      }
    }
}

  function insertMark(string,pos,len){
    return string.slice(0, pos)+'<mark>'+string.slice(pos, pos+len) + '</mark>' +
    string.slice(pos+len);
  }

//deleteAddrecords
$(document).ready(function(){
  $('.profile_remove').click(function(){
    let values = $(this).attr('value').split('|');
    $.ajax({
        method: "POST",
        url: "/blogg/public/php/removePost.php",
        data: {
          post_id: values[0],
          user_id: values[1],
       }
       })
     $(this).parent().remove();
  })
  $('.modal_close').click(function() {
    let modal = $('.favorite_authorize');
    modal.css('display','none');
    modal.css('opacity','0');
  });
  $('#remove').mouseover(function(){
    $(this).text('Удалить');
  }).mouseout(function(){
    $(this).text('Добавлено');
  })

  $('.favorite').click(function(){
    let user_id = $('#user-id').attr('value');
    let post_id = $('#post-id').attr('value');
    if($(this).attr('value') == 'add') {
      $.ajax({
          method: "POST",
          url: "/blogg/public/php/addPost.php",
          data: {
            post_id: post_id,
            user_id: user_id,
         }
         })
      $(this).css('display','none');
      $(this).next().css('display','inline-block');
      $(this).next().next().css('display','inline-block');
    }else if($(this).attr('value') == 'delete') {
      $.ajax({
          method: "POST",
          url: "/blogg/public/php/removePost.php",
          data: {
            post_id: post_id,
            user_id: user_id,
         }
         })
        $(this).css('display','none');
        $(this).next().css('display','none');
        $(this).prev().css('display','inline-block');
    }else if($(this).attr('value') == 'authorize') {
      let modal = $('.favorite_authorize');
      modal.css('display','block');
      modal.css('opacity','1');
    }
  })
})
