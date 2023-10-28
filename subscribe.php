<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Subscribe</title>
  <link rel="icon" href="icon.jpeg" type="image/x-icon" />

  <style>
    body {
      text-decoration: none;
      background: black;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .card {
      background-color: black;
      color: white;
      box-shadow: 0px 0px 20px rgba(0, 191, 255, 0.7);
      padding: 40px 40px;
      border-radius: 10px;
      text-align: center;
    }

    .input-field {
      display: block;
      /* Display inputs as block elements */
      margin-bottom: 10px;
      /* Add some spacing between inputs */
      width: 100%;
      /* Make inputs take the full width of the container */
      padding: 10px;
      /* Add padding for better appearance */
      margin-left: -10px;
    }

    .subscribe-btn {
      background-color: rgba(0, 191, 255, 0.7);
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s, box-shadow 0.3s;
      /* Add transition for smooth hover effect */
    }

    /* Hover effect for the subscribe button */
    .subscribe-btn:hover {
      background-color: rgba(0, 191, 255, 1);
      /* Change the background color on hover */
      box-shadow: 0px 0px 20px rgba(0, 191, 255, 0.7);
      /* Add box-shadow on hover */
    }
  </style>

</head>

<body>
  <div class="card">
    <h3 class="h2">Enter your details to get weather updates</h3>
    <input class="input-field" type="text" placeholder="Name" id="name" />
    <input class="input-field" type="email" placeholder="Email" id="email" />
    <button class="subscribe-btn" onclick="subscribe()">Subscribe</button>
    <p id="message"></p>
  </div>

  <script>
    function subscribe() {
      const name = document.getElementById("name");
      const email = document.getElementById("email");
      const message = document.getElementById("message");

      const nameValue = name.value.trim();
      const emailValue = email.value.trim();

      if (nameValue === "" || emailValue === "") {
        message.textContent = "Name and Email are required.";
      } else if (!isValidEmail(emailValue)) {
        message.textContent = "Please enter a valid email address.";
      } else {
        // Create a FormData object to send the data
        const formData = new FormData();
        formData.append("name", nameValue);
        formData.append("email", emailValue);

        // Send an AJAX request to subscribe.php with the FormData
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "subscribe.php", true);
        xhr.onreadystatechange = function() {
          if (xhr.readyState === 4 && xhr.status === 200) {
            // Display the success message after the AJAX request is complete
            message.textContent = xhr.responseText;

            // Clear the input fields
            name.value = "";
            email.value = "";
          }
        };
        // Send the FormData to the server
        xhr.send(formData);
      }
    }

    function isValidEmail(email) {
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return emailRegex.test(email);
    }
  </script>

</body>

</html>
<?php
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["name"]) && isset($_POST["email"])) {
  $name = $_POST["name"];
  $email = $_POST["email"];
  $file = fopen("save.txt", "a");

  fwrite($file, "Name : ");
  fwrite($file, $name . "\n");
  fwrite($file, "Email : ");
  fwrite($file, $email . "\n");
  fclose($file);

  echo "Data saved successfully";
}
?>