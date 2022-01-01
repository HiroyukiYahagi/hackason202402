
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

window.Vue = require('vue');

import UIkit from 'uikit';
import Icons from 'uikit/dist/js/uikit-icons';

// loads the Icon plugin
UIkit.use(Icons);
window.UIkit = UIkit;

document.addEventListener('DOMContentLoaded', function() {
  
  Array.prototype.forEach.call(document.querySelectorAll("form"), function (form) {
    form.onkeypress = function(e){
      const key = e.keyCode || e.charCode || 0;
      if (key == 13) {
        e.preventDefault();
      }
    }
    var checkAndEnable = function(){
      var selectable =  true;
      Array.prototype.forEach.call(form.querySelectorAll('*[required]'), function(input){
        if(input.value == null || input.value.length == 0){
          selectable = false;
        }
      });
      if( selectable ){
        Array.prototype.forEach.call(form.querySelectorAll(".only_required"), function(button){
          button.removeAttribute("disabled");
        });
      }else{
        Array.prototype.forEach.call(form.querySelectorAll(".only_required"), function(button){
          button.setAttribute("disabled", true);
        });
      }  
    }
    Array.prototype.forEach.call(form.querySelectorAll('*[required]'), function(input){
      input.onkeyup = checkAndEnable;
    });

    checkAndEnable();
      
  });
});