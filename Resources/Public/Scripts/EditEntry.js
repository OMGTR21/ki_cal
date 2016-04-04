$(document).ready(function() {

  // Check if user clicks on an entry
  $(".detailedEntry").on("click", function() {

    // Open modal window
    Avgrund.show("#edit_entry_modal");

    // Set height for the modal window
    $('#edit_entry_modal').css('height', 'auto');
  });
});

// Close button for modal
function closeDialog() {
  Avgrund.hide();
}
