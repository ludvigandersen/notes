$(document).ready(function(e){

  // Listing all artists
  $.ajax({
    url: "src/rest_api.php/artist",
    type: "GET",
    dataType: "json",
    success: function(data){

      data.forEach(element => {
        let tableElement = $('<td>', {
          text: element[1]
        })
        
        // If the current user is an admin, show the CRUD operations
        // Else just list the Artists
        // TODO: Refactor so the appending only happens once.
        if ($('#artistsAdmin').length){
          var tableBtns = $('<td>', {
            class: "tableBtns"
          }).append($("<input>", {
            type: "image", src: "../img/information-icon.jpg", id: element[0]
          })).append($("<input>", {
            type: "image", src: "../img/settings-icon.png", id: element[0], class: "update"
          })).append($("<input>", {
            type: "image", src: "../img/delete-icon.png", id: element[0], class: "delete"
          }))
        
          $("#artistsAdmin").find('tbody')
          .append($('<tr>', {id: element[0]})
          .append(tableElement).append(tableBtns))
        } else {
          $("#artists").find('tbody')
          .append($('<tr>', {id: element[0]})
          .append(tableElement))
        }        
      });
    },
    error: function(e){
      console.log(e)
    }
  })

  // Actions for creating an Artist
  $("#createArtistBtn").on("click", function(e){
    let modal = $("#createModal")
    modal.css("display", "block")
  })

  $("#finishCreate").on("click", function(e){
    e.preventDefault();
    let name = $("#name").val()

    if (name === "") {
      alert("Name is missing")
      return;
    }

    $.ajax({
      url: "src/rest_api.php/artist",
      type: "POST",
      data: {
        "name": name
      },
      success: function(data){
        if(data == "1"){
          alert("Artist creation succeeded")
          window.location.reload()
        } else {
          console.log(data)
          alert("Artist creation failed")
        }
      },
      error: function(e){
        console.log(e)
      }
    })
  })

  $("#cancelCreate").on("click", function(e){
    let modal = $("#createModal")
    modal.css("display", "none")
  })

  // Actions for deleting an Artist
  $("#artistsAdmin").on("click", ".delete", function(e){
    var id = this.id

    if (confirm("Are you sure you want to delete?")){
      $.ajax({
        url: `src/rest_api.php/artist/${id}`,
        type: "DELETE",
        success: function(data){

          if(data == "1") {
            window.location.reload()
          } else if(data == "artist has an album") {
            alert("Artist has an album, and can therefore not be deleted.")
          } else {
            alert("Artist deletion failed.")
          }
        },
        error: function(e){
          console.log(e)
        }
      })
    }
  })

  // Actions for updating an Artist
  $("#artistsAdmin").on("click", ".update", function(e){
    let id = this.id
    $("#artistId").val(id);

    let currentName = this.parentElement.previousSibling.innerText
    $("#artistName").text(currentName)

    $("#finishUpdate").attr("artistId", id)

    let modal = $("#updateModal")
    modal.css("display", "block")
  })

  $("#finishUpdate").on("click", function(e){
    e.preventDefault();

    // Refactor how data is sent, only a single string atm.
    $.ajax({
      url: `src/rest_api.php/artist/${$("#artistId").val()}`,
      type: "PUT",
      data: $("#nameUpdate").val(),
      success: function(data){
        if(data === "artist update success"){
          alert("Update successful")
          window.location.reload()
        } else {
          alert("Update failed")
        }
      },
      error: function(e){
        console.log(e)
      }
    })
  })

  $("#cancelUpdate").on("click", function(e){
    let modal = $("#updateModal")
    modal.css("display", "none")
  })
})