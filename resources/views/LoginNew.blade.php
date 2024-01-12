<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {font-family: Arial, Helvetica, sans-serif;}
form {border: 3px solid #f1f1f1;}

input[type=text], input[type=password] {
  width: 100%;
  height: 6.5vh;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
}

button {
  background-color:#007bff;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
}

button:hover {
  opacity: 0.8;
}

.cancelbtn {
  width: auto;
  padding: 10px 18px;
  background-color: #f44336;
}

.imgcontainer {
  text-align: center;
  margin: 24px 0 12px 0;
  width: 80vh;
  /* border-style: solid; */
  /* align-items: center;
  align-self: center; */
}

img.avatar {
  width: 40%;
  border-radius: 50%;
}

.container {
  padding: 16px;
  width: 40%;
  /* border-style:solid; */
  align-self: center;
}

span.psw {
  float: right;
  padding-top: 16px;
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
  span.psw {
     display: block;
     float: none;
  }
  .cancelbtn {
     width: 100%;
  }
}
</style>
</head>
<body>

{{-- <h2>Datalogic Systems Corporation</h2> --}}

<form action="/logins" method="POST">
    @csrf
    <center>
  <div class="imgcontainer">

    <img src="{{asset('img/dsclogo.png')}}" alt="Avatar" class="avatar">

</div>

  <div class="container">
    <label for="uname"><b>Cashier Number:</b></label>
      @error('username')
    <div style="color: red;background-color:lightpink;border-width:0.5px;padding:3px">{{ $message }}</div>
  @enderror
    <input type="text" placeholder="Enter Username" name="uname" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" required>

    <button type="submit">Login</button>
    <label>
      <input type="checkbox" checked="checked" name="remember"> Remember me
    </label>
  </div>

  <div class="container" style="background-color:#f1f1f1">
    <button type="button" class="cancelbtn">Cancel</button>
    <span class="psw">Forgot <a href="#">password?</a></span>
  </div>
</form>
</center>
</body>
<script>
//     document.addEventListener('DOMContentLoaded', function() {
//   // This function will be called when the DOM is fully loaded or when the document is reloaded
//         alert('Wrong Username or Password');
//   // Add your code here to handle the document reload event
// });

</script>
</html>
