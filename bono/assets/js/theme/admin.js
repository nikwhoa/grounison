jQuery(document).ready(function(e){e(".js-wpshop-reset-settings").on("click",function(){var n,t=e(this);return confirm("Are you sure?")&&(n={action:"wpshop_reset_settings",_wpnonce:t.data("nonce")},jQuery.post(ajaxurl,n,function(n){t.text(n)})),!1}),e(".customize-control-range input[type=range]").each(function(){var t=e(this);e('<span class="customize-control-range-val">'+t.val()+"</span>").insertAfter(t),t.on("input change",function(){var n=e(this).val();t.next().text(n)})})});