document.addEventListener("DOMContentLoaded", function () {
      // Get references of HTML elements.
    const searchBox = document.querySelector("#search_box");
    const searchButton = document.querySelector("#search_btn");
    const resultsContainer = document.querySelector(".box-container");
  
    function performSearch() { /// live search function

         // Get the search term from the input element and trim any leading/trailing spaces.
      const searchTerm = searchBox.value.trim();
      if (searchTerm !== "") {
        const xhr = new XMLHttpRequest();  // Create a new XMLHttpRequest object.        
        xhr.open("POST", "search_handler.php", true);  // Set up a POST request to "search_handler_model.php".
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  
                // Define the response callback function.
        xhr.onreadystatechange = function () {
          if (xhr.readyState === 4 && xhr.status === 200) {
            // Update the results container with the response text.           
            resultsContainer.innerHTML = xhr.responseText;
          }
        };
  
        xhr.send("search_box=" + searchTerm); // Send the search term in the request body.        
      } else {
        resultsContainer.innerHTML = "";
      }
    }
      // Add an input event listener to the search box to trigger live search.    
    searchBox.addEventListener("input", performSearch);
  
      // Add a click event listener to the search button (with preventDefault).    
    searchButton.addEventListener("click", function (e) {
      e.preventDefault();
            // Trigger the live search function.
      performSearch(); /// button here as no real functionality can remove 
    });
  });
  