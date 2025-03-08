(function (blocks, element, blockEditor) {
  var el = element.createElement;
  var useBlockProps = blockEditor.useBlockProps;

  blocks.registerBlockType("il-theme/carousel", {
    edit: function (props) {
      var blockProps = useBlockProps();
      return el(
        "div",
        blockProps,
        el(
          "div",
          { className: "wp-block-cover alignfull no-padding" },
          el(
            "div",
            { className: "wp-block-cover__inner-container" },
            el(
              "div",
              {
                className: "hero box",
              },
              el("p", {}, "Hej och välkommen till min blogg!"),
            ),
          ),
        ),
      );
    },
    save: function () {
      return null; // Rendered in PHP
    },
  });
})(window.wp.blocks, window.wp.element, window.wp.blockEditor);
