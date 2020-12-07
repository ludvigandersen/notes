$(document).ready(function(e){

  // Actions for updating User information
  $("#updateInfo").on("click", function(e){
    e.preventDefault()
    let id = $("#userId").val()
    let emailPattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i

    if (!emailPattern.test($("#email").val())) {
      alert("Invalid email")
      return
    }

    $.ajax({
      url: `http://notes-api.com/v1/user/${id}`,
      type: "POST",
      data: {
        "firstName": $("#firstName").val(),
        "lastName": $("#lastName").val(),
        "company": $("#company").val(),
        "address": $("#address").val(),
        "city": $("#city").val(),
        "state": $("#state").val(),
        "country": $("#country").val(),
        "postalCode": $("#postalCode").val(),
        "phone": $("#phoneNumber").val(),
        "fax": $("#fax").val(),
        "email": $("#email").val(),
      },
      success: function(data){
        console.log(data)
        if(data){
          $("#updateInfoForm").submit()
        } else {
          alert("User update failed")
        }
      },
      failure: function(e){
        console.log("Failure")
        console.log(e)
      }
    })
  })

  // Actions for updating password
  $("#updatePassword").on("click", function(e){
    e.preventDefault()
    let id = $("#userId").val()
    password = $("#password").val()
    passwordRepeat = $("#passwordRepeat").val()

    if(password != passwordRepeat){
      alert("Passwords do not match")
      return;
    }

    $.ajax({
      url: `http://notes-api.com/v1/user/${id}`,
      type: "POST",
      data: {
        "password": password,
        "passwordRepeat": passwordRepeat
      },
      success: function(data){
        if(data){
          alert("Password update succeeded")
          location.reload()
        } else {
          alert("Password update failed")
        }
      },
      failure: function(e){
        console.log(e)
      }
    })
  })
})