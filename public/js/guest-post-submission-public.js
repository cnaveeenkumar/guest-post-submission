(function ($) {
  "use strict";

  /**
   * All of the code for your public-facing JavaScript source
   * should reside in this file.
   *
   * Note: It has been assumed you will write jQuery code here, so the
   * $ function reference has been prepared for usage within the scope
   * of this function.
   *
   * This enables you to define handlers, for when the DOM is ready:
   *
   * $(function() {
   *
   * });
   *
   * When the window is loaded:
   *
   * $( window ).load(function() {
   *
   * });
   *
   * ...and/or other possibilities.
   *
   * Ideally, it is not considered best practise to attach more than a
   * single DOM-ready or window-load handler for a particular page.
   * Although scripts in the WordPress core, Plugins and Themes may be
   * practising this, we should strive to set a better example in our own work.
   */
  $(document).on("submit", "#gps-form", function (e) {
    e.preventDefault();
    var form = $("#gps-form")[0];
    var postInfo = new FormData(form);
    postInfo.append("action", "create_post_using_ajax");
    postInfo.append("gps_post_title", $("#txt_title").val());
    postInfo.append("gps_post_type", $("#txt_post_type").val());
    postInfo.append("gps_post_content", $("#txt_description").val());
    postInfo.append("gps_post_excerpt", $("#txt_excerpt").val());
    postInfo.append("gps_featured_image", $("#txt_featured_image")[0].files[0]);

    $.ajax({
      url: guest_post_ajax_object.ajax_url,
      type: "POST",
      data: postInfo,
      contentType: false,
      processData: false,
      beforeSend: function () {
        $(".success-message").html(
          "<p class='text-center'>Processing please wait...!</p>"
        );
      },
      success: function (result) {
        console.log(result);
        //$(".success-message").html(result);
        $(".success-message").html(
          "<p class='success'>Added your post successfully. Please await moderation administrator.</p>"
        );
        $("#gps-form")[0].reset();
      },
    });
  });
})(jQuery);
