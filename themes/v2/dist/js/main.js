jQuery(document).ready(function(){let e=jQuery("section.content"),r=jQuery("aside.left-navigation"),a=(jQuery("#btn-toggle-sidebar").on("click",function(){"0px"===r.css("width")?(e.css("margin-left","200px"),r.css("width","200px"),r.css("border-right","1px solid #e9ecef")):(e.css("margin-left",0),r.css("width",0),r.css("border-right","none"))}),jQuery(".sidebar-nav li").click(function(e){let r=jQuery(this).find("div.pe-1 i");r.hasClass("bi-arrow-right-circle")?(r.removeClass("bi-arrow-right-circle"),r.addClass("bi-arrow-down-circle")):(r.removeClass("bi-arrow-down-circle"),r.addClass("bi-arrow-right-circle"))}),jQuery("#search-menu"));document.onkeyup=function(e){e.ctrlKey&&191===e.which&&a.select2("open")};const t="light";let i=jQuery("body");let s=jQuery("#navbar");let l=jQuery("#dark-light-link");if(l.click(function(e){return e.preventDefault(),l.html(" ....... "),jQuery.get(l.attr("href"),function(e){var r;e.theme===t?l.html('<i class="bi bi-moon"></i>'):l.html('<i class="bi bi-sun"></i>'),r=e,i.removeClass(t),i.removeClass("dark"),i.addClass(r.theme),r=e,s.removeClass("navbar-dark"),s.removeClass("bg-dark"),s.removeClass("navbar-light"),s.removeClass("bg-light"),s.addClass("navbar-"+r.theme),s.addClass("bg-"+r.theme)}),!1}),jQuery(document).on("beforeSubmit","form",function(e){let r=jQuery(this).find("button[type=submit]");r.html('<i class="bi bi-arrow-repeat"></i> Memproses...'),r.attr("disabled",!0).addClass("disabled")}),jQuery("#pa3py6aka-modal-alert")){let e=jQuery("#pa3py6aka-modal-alert .modal-dialog .modal-content .modal-header .modal-title");""===e.html()&&e.html("Pesan Sistem")}});