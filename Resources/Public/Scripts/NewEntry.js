$(document).ready(function() {

  $("#new_entry_btn").on("click", function() {
    Avgrund.show("#new_entry_modal");

    $('.tab a').click(function (e) {
      e.preventDefault()
      $(this).tab('show')
    });
  });
});

function closeDialog() {
  Avgrund.hide();
}
