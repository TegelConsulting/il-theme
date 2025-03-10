(function (blocks, element) {
  var el = element.createElement;
  blocks.registerBlockType("il-theme/highlights", {
    edit: function () {
      return el("p", {}, "Custom Fields Block");
    },
    save: function () {
      return null; // Rendered in PHP
    },
  });
})(window.wp.blocks, window.wp.element);
