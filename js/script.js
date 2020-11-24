$(document).ready(function(){
  
  // Sign up as a new user
  $("#signUpForm").on("submit", function(e){
    e.preventDefault();

    password = $("#password").val();
    passwordRepeat = $("#passwordRepeat").val();

    // Validating matching passwords
    // if(password != passwordRepeat){
    //   alert("Passwords are not matching!");
    //   return;
    // }

    // Prepare data to be sent in POST request to api
    data = {
      "entity": "user",
      "action": "post",
      "firstName": $("#firstName").val(),
      "lastName": $("#lastName").val(),
      "company": $("#company").val(),
      "address": $("#address").val(),
      "city": $("#city").val(),
      "state": $("#state").val(),
      "country": $("#country").val(),
      "postalCode": $("#postalCode").val(),
      "phoneNumber": $("#phoneNumber").val(),
      "fax": $("#fax").val(),
      "email": $("#emailSignUp").val(),
      "password": password,
      "passwordRepeat": passwordRepeat
    }

    $.ajax({
      url: "src/api.php",
      type: "POST",
      data: data,
      success: function(data){
        if(data){
          window.location.replace('../index.php');
        } else {
          alert("User creation failed");4
        }
      }
    })
  })
})