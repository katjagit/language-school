'use strict';

$.validator.addMethod (
  'letterswithbasicpunc',
  function (value, element) {
    return this.optional(element) || /^[a-zäöüß\-.,()'"\s]+$/i.test(value);
  },
  'Nur Buchstaben und Interpunktion erlaubt! addMethod'
);

var settings = {
  errorElement: 'div',
  errorClass: 'error_form',
  normalizer: function (value) {
    return $.trim(value);
  },

  errorPlacement: function ($errorElement, $element) {
    $element.parent().prev().after($errorElement);
   
  },
  highlight: function (element, errorClass, validClass) {
    $(element).after().css('border', '2px solid red');
  },
  unhighlight: function (element, errorClass, validClass) {
    $(element).addClass(validClass).removeClass(errorClass);
    $(element).after().css('border', '');
  },
  rules: {
    firstname: {
      pattern: /^[a-zäöüß\-.,()'"\s]+$/i
    
    },

    lastname: {
      pattern: /^[a-zäöüß\-.,()'"\s]+$/i
      
    },

    email: {
      email: true
      
    },
    password: {
      minlength: 5,
      
    },

    'password_confirmation': {
      equalTo: '#password'
      
    },

  },

  messages: {
    firstname: {
      pattern: 'Bitte einen gültigen Namen eingeben'
    },

    lastname: {
      pattern: 'Bitte einen gültigen Namen eingeben'
    },

    'password_confirmation': {
      pattern: 'Die Passwörter müssen übereinstimmen'
    },

  }
};

$(function ($) {
  var $form = $('form');
  if (!$form.checkValidity || $form.checkValidity()) {
    $form.eq(0).validate(settings);
    $form.eq(1).validate(settings);
  }
  
  
});