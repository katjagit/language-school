'use-strict';

function isBlank(s) {
    return s.trim().length === 0 ? true : false;
}


function emptyEl(element) {
    while (element.firstChild) {
        element.firstChild.remove();
    }
}


function createEl(tag, txt) {
    tag = document.createElement(tag);
    if (txt) {
      txt = document.createTextNode(txt);
      tag.appendChild(txt);
    }
    return tag;
}


function insertAfter(newNode, refNode) {
    return refNode.parentNode.insertBefore(newNode, refNode.nextSibling);
}


function insertBefore(newNode, refNode) {
    return refNode.insertBefore(newNode, refNode);
}


function ucfirst(s) {
    return s.slice(0, 1).toUpperCase() + s.slice(1);
}