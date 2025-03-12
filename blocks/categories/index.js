(function (blocks, element, blockEditor) {
  var el = element.createElement;
  var useBlockProps = blockEditor.useBlockProps;

  blocks.registerBlockType("il-theme/categories", {
    edit: function (props) {
      var blockProps = useBlockProps();
      return el("div", blockProps, "List of categories here");
    },
    save: function () {
      return null; // Rendered in PHP
    },
  });
})(window.wp.blocks, window.wp.element, window.wp.blockEditor);
