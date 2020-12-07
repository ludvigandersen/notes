$(document).ready(function(e){

  listArtists(0)

  // Navigating artist table
  $("#btnForward").on("click", function(e){
    p = $(this).attr('page')
    listArtists(p)
    count = ++ p
    $(this).attr('page', count)
    $("#btnBackward").attr('page', count - 2)
    $("#btnBackward").attr('disabled', false)
  })

  $("#btnBackward").on("click", function(e){
    p = $(this).attr('page')
    listArtists(p)
    count = -- p
    $(this).attr('page', count)
    count = ++ p
    count = ++ p
    $("#btnForward").attr('page', count)
    if($(this).attr('page') == -1){
      $(this).attr('disabled', true)
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

    if ($.trim(name) == "") {
      alert("Name is missing")
      return;
    }

    $.ajax({
      url: "http://notes-api.com/v1/artist",
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
        url: `http://notes-api.com/v1/artist/${id}`,
        type: 'DELETE',
        success: function(data){
          console.log(data)
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
    name = $("#nameUpdate").val()
    if($.trim(name) == ""){
      alert("Please provide a name")
      return
    }

    // Refactor how data is sent, only a single string atm.
    $.ajax({
      url: `http://notes-api.com/v1/artist/${$("#artistId").val()}`,
      type: "POST",
      data: {
        "name": name
      },
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

function listArtists(p){
  if($("#artistsAdmin").length){
    $("#artistsAdmin").find('tr:gt(0)').remove()
  } else {
    $("#artists").find('tr:gt(0)').remove()
  }

  $.ajax({
    url: `http://notes-api.com/v1/artist?p=${p}`,
    type: "GET",
    dataType: "json",
    success: function(data){
      if(data.length < 25){
        $("#btnForward").attr("disabled", true)
      } else {
        $("#btnForward").attr("disabled", false)
      }

      data.forEach(element => {
        let tableElement = $('<td>', {
          text: element['Name']
        })
        
        // If the current user is an admin, show the CRUD operations
        // Else just list the Artists
        // TODO: Refactor so the appending only happens once.
        if ($('#artistsAdmin').length){
          var tableBtns = $('<td>', {
            class: "tableBtns"
          }).append($("<input>", {
            type: "image", src: "../img/information-icon.jpg", id: element['ArtistId']
          })).append($("<input>", {
            type: "image", src: "../img/settings-icon.png", id: element['ArtistId'], class: "update"
          })).append($("<input>", {
            type: "image", src: "../img/delete-icon.png", id: element['ArtistId'], class: "delete"
          }))
        
          $("#artistsAdmin").find('tbody')
          .append($('<tr>', {id: element['ArtistId']})
          .append(tableElement).append(tableBtns))
        } else {
          $("#artists").find('tbody')
          .append($('<tr>', {id: element['ArtistId']})
          .append(tableElement))
        }        
      });
    },
    error: function(e){
      console.log(e)
    }
  })
}