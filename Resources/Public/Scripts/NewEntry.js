$(document).ready(function() {

  // Event listener for the new entry button
  $("#new_entry_btn").on("click", function() {

    // Open modal window
    Avgrund.show("#new_entry_modal");

    // Function for changing the tabs
    $('.tab a').click(function (e) {
      e.preventDefault()
      $(this).tab('show')
    });
  });
});

/**
* Close the modal window
*/
function closeDialog() {
  Avgrund.hide();
}
