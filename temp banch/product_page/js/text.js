// (function ($) {
//     $(document).ready(function() {
//       $("#press").click(function() {
//         $("#message-id").html("Added to Cart"); // Display the message
//         // $("#message-id").append('<button class="buy_now">Buy Now<button>');
//       })
//     });
// })(jQuery);


// (function ($, Drupal, once) {
//   Drupal.behaviors.myModuleBehavior = {
//     attach: function (context, settings) {
//       // Attach a click event handler to the button with ID "press"
//       $('#press', context).once('myModuleBehavior').click(function() {
//         // Display the message in the designated message element
//         $('#message-id').html('Product added to Cart');
//       });
//     }
//   };
// })(jQuery, Drupal,once);
(function ($, Drupal, drupalSettings) {
  Drupal.behaviors.prodBehavior = {
    attach: function (context, settings) {
      var target = $('#press', context);
      target.on('click', function () {
        $('#message-id').html('</br><p>Product added to cart!</p>');
      });
    },
  };
})(jQuery, Drupal, drupalSettings);

  