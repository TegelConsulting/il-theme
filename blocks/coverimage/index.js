(function (blocks, element, blockEditor) {
  var el = element.createElement;
  var MediaUpload = blockEditor.MediaUpload;
  var BlockControls = blockEditor.BlockControls;
  var InspectorControls = blockEditor.InspectorControls;
  var Button = wp.components.Button;

  blocks.registerBlockType("iltheme/coverimage", {
    edit: function (props) {
      var coverImageUrl = props.attributes.coverImageUrl;

      function onSelectImage(media) {
        props.setAttributes({
          coverImageUrl: media.url,
        });
        // Save the image URL as post meta
        wp.data
          .dispatch("core/editor")
          .editPost({ meta: { _il_theme_coverimage: media.url } });
      }

      return el(
        "div",
        { className: "coverimage-block" },
        el(BlockControls, null),
        el(InspectorControls, null),
        el(MediaUpload, {
          onSelect: onSelectImage,
          allowedTypes: "image",
          value: coverImageUrl,
          render: function (obj) {
            return el(
              Button,
              {
                className: coverImageUrl
                  ? "image-button"
                  : "button button-large",
                onClick: obj.open,
              },
              !coverImageUrl
                ? "Select Cover Image"
                : el("img", { src: coverImageUrl }),
            );
          },
        }),
      );
    },
    save: function () {
      return null; // Rendered in PHP
    },
  });
})(window.wp.blocks, window.wp.element, window.wp.blockEditor);
