$(document).ready(function() {

  $("#search_btn").on("click", function() {
    Avgrund.show("#search_modal");

    $('.tab a').click(function (e) {
      e.preventDefault()
      $(this).tab('show')
    });
  });
});

function closeDialog() {
  Avgrund.hide();
}
