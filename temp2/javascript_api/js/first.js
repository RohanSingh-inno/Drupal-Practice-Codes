(function ($, Drupal) {
  Drupal.behaviors.customHoverText = {
    attach: function (context, settings) {
      // Add the hover effect to the specified element.
      $('#block-bootstrap5-content', context).once('customHoverText').hover(
        function () {
          $(this).css('color', 'red'); // Change this to the desired hover color.
        },
        function () {
          $(this).css('color', ''); // Reset the color on hover out.
        }
      );
    }
  };
})(jQuery, Drupal);


