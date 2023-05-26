   // Get the modal element
  var modal = document.getElementById("allocationModal");

  // Get the button that opens the modal
  var allocateButtons = document.getElementsByClassName("allocate-btn");

  // Loop through all the allocate buttons
  for (var i = 0; i < allocateButtons.length; i++) {
    allocateButtons[i].addEventListener("click", function() {
      // Get the row element
      var row = this.closest("tr");

      // Get the data from the row
      var id = row.cells[0].innerText;
      var amountAllocated = row.cells[1].innerText;
      var timeAllocated = row.cells[2].innerText;

      // Populate the modal with the data
      document.getElementById("customerNumber").value = id;
      document.getElementById("amountToLend").value = amountAllocated;

      // Perform any additional calculations or modifications here
      // ...

      // Open the modal
      modal.style.display = "block";
    });
  }
 