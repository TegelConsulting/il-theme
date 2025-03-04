(function (blocks, element) {
  var el = element.createElement;
  blocks.registerBlockType("il-theme/hero", {
    edit: function () {
      return el("p", {}, "Hero block placeholder");
    },
    save: function () {
      return null; // Rendered in PHP
    },
  });
})(window.wp.blocks, window.wp.element);
