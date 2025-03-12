jQuery(document).ready(function ($) {
  var frame;
  $("#category_image_button").on("click", function (e) {
    e.preventDefault();
    if (frame) {
      frame.open();
      return;
    }
    frame = wp.media({
      title: "Select or Upload Image",
      button: {
        text: "Use this image",
      },
      multiple: false,
    });
    frame.on("select", function () {
      var attachment = frame.state().get("selection").first().toJSON();
      $("#category_image").val(attachment.url);
      $("#category_image_preview").html(
        '<img src="' + attachment.url + '" style="max-width: 100%;" />',
      );
      //   frame.off("select");
      //   frame.close();
    });
    frame.open();
  });

  $("#category_image_remove_button").on("click", function (e) {
    e.preventDefault();
    $("#category_image").val("");
    $("#category_image_preview").html("");
  });
});
