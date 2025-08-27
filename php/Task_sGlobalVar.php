<!DOCTYPE html>
<html>
<head>
  <title>Login Form</title>
</head>
<body>
  <form action="abc.php" method="get" onsubmit="return Validateform()">
    Username:
    <input type="text" name="username"><br><br>

    Password:
    <input type="password" name="password"><br><br>

    <input type="submit" value="Login">
  </form>

  <script>
    function validationForm() {
      let name = document.getElementById("username").value.trim();
      let pass = document.getElementById("password").value.trim();

      let nameErr = document.getElementById("name-error");
      let passErr = document.getElementById("password-error");

      nameErr.textContent = "";
      passErr.textContent = "";

      let isValid = true;

      if (name === "") {
        nameErr.textContent = "Username is required.";
        isValid = false;
      }

      if (pass === "") {
        passErr.textContent = "Password is required.";
        isValid = false;
      }

      return isValid;
    }
  </script>
</body>
</html>


