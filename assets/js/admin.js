// filepath: /C:/MAMP/htdocs/wordpress/wp-content/themes/IL-theme/assets/js/admin.js
jQuery(document).ready(function ($) {
  var file_frame;

  $("#il_theme_coverimage_button").on("click", function (event) {
    event.preventDefault();

    if (file_frame) {
      file_frame.open();
      return;
    }

    file_frame = wp.media.frames.file_frame = wp.media({
      title: "Select Cover Image",
      button: {
        text: "Use this image",
      },
      multiple: false,
    });

    file_frame.on("select", function () {
      var attachment = file_frame.state().get("selection").first().toJSON();
      $("#il_theme_coverimage").val(attachment.url);
      $("#il_theme_coverimage_preview").html(
        '<img src="' + attachment.url + '" style="max-width: 100%;">',
      );
    });

    file_frame.open();
  });
});
