let list = document.querySelector('#list');
let items = document.querySelectorAll('#list tr');
let dataSort = document.querySelector('#data');
let nameSort = document.querySelector('#name');
let dataFlag = true;
let nameFlag = true;

dataSort.addEventListener('click', function() {
  let sorted;
  if(dataFlag){
     sorted = [...items].sort(function(a,b){
      let temp = a.cells[1].innerHTML.split('-');
      let date1 = new Date(temp[0],temp[1],temp[2]);
      temp = b.cells[1].innerHTML.split('-');
      let date2 = new Date(temp[0],temp[1],temp[2]);
        return date2 - date1;
    });
    dataFlag = false;
  }else {
     sorted = [...items].sort(function(a,b){
      let temp = a.cells[1].innerHTML.split('-');
      let date1 = new Date(temp[0],temp[1],temp[2]);
      temp = b.cells[1].innerHTML.split('-');
      let date2 = new Date(temp[0],temp[1],temp[2]);
        return date1 - date2;
    });
    dataFlag = true;
  }
  list.innerHTML = "";
  for (let tr of sorted) {
    list.appendChild(tr);
  }
});

nameSort.addEventListener('click', function() {
  let sorted;
  if(nameFlag){
     sorted = [...items].sort(function(a,b){
        return a.cells[0].innerText < b.cells[0].innerText;
    });
    nameFlag = false;
  }else {
     sorted = [...items].sort(function(a,b){
       return a.cells[0].innerText > b.cells[0].innerText;
    });
    nameFlag = true;
  }
  list.innerHTML = "";
  for (let tr of sorted) {
    list.appendChild(tr);
  }
});
