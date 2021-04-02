'use strict';

function selectLevel(e) {
    var btn_id = e.target.id;
    var level;
    switch (btn_id) {
        case 'button-a' : 
            level = 'Anfänger';
            break;
        case 'button-f' : 
            level = 'Fortgeschrittene';
            break;
        default:
            level = 'all';
    }

    var p = document.getElementsByClassName('level');
    for (var i=0; i<p.length; i++) {
        var div = p[i].parentElement.parentElement;
        if (p[i].innerHTML === level || level === 'all') {
            div.classList.remove('hidden');
        } else {
            div.classList.add('hidden');
        }
    }
}

function markLinkActive(e) {
    var active = document.getElementsByClassName('active');
    if (active[0]) {
      active[0].classList.remove('active');
      e.target.classList.add('active');
    }
  }
  
function handleClick(e) {
  if (!e.target.classList.contains('active')) {
    markLinkActive(e);
    selectLevel(e);
  }
}

function bindHandler() {

    var switcherBtn = document.getElementsByTagName('button');
  for (var i = 0, btn; i < switcherBtn.length; i++) {
    btn = switcherBtn[i];
    btn.addEventListener('click', handleClick);
  }
}

bindHandler();

