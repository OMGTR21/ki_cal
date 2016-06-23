$(document).ready(function() {

  // Event listener for the search button
  $("#search_btn").on("click", function() {

    // Open the search modal window
    Avgrund.show("#search_modal");

    // Function for changing the tab
    $('.tab a').click(function (e) {

      e.preventDefault()
      $(this).tab('show')
    });
  });
});

/**
* Close the dialog window
*/
function closeDialog() {
  Avgrund.hide();
}
