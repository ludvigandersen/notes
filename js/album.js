$(document).ready(function(e){
  listAlbums(0)

  // Navigating artist table
  $("#btnForward").on("click", function(e){
    p = $(this).attr('page')
    listAlbums(p)
    count = ++ p
    $(this).attr('page', count)
    $("#btnBackward").attr('page', count - 2)
    $("#btnBackward").attr('disabled', false)
  })

  $("#btnBackward").on("click", function(e){
    p = $(this).attr('page')
    listAlbums(p)
    count = -- p
    $(this).attr('page', count)
    count = ++ p
    count = ++ p
    $("#btnForward").attr('page', count)
    if($(this).attr('page') == -1){
      $(this).attr('disabled', true)
    }
  })

    // Actions for creating an album
    $("#createAlbumBtn").on("click", function(e){
      let modal = $("#createModal")
      modal.css("display", "block")

      $.ajax({
        url: "http://notes-api.com/v1/artist",
        type: "GET",
        success: function(data){
          console.log(data)
          data.forEach(element => {
            $("#artistsDropdownCreate").append($("<option>", {value: element['ArtistId'], text: element['Name']}))
          });
        }
      })
    })

    $("#finishCreate").on("click", function(e){
      e.preventDefault();
      name = $("#name").val()
      artistId = $("#artistsDropdownCreate option:selected").val()

      if(name.trim() == "") {
        alert("Please provide a Title")
        return
      }

      $.ajax({
        url: "http://notes-api.com/v1/album",
        type: "POST",
        data: {
          "name": name,
          "artistId": artistId
        },
        success: function(data){
          console.log(data)
          if(data == "1"){
            alert("Album creation succeeded")
            window.location.reload()
          } else {
            console.log(data)
            alert("Album creation failed")
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

    // Actions for deleting an album
    $("#albumsAdmin").on("click", ".delete", function(e){
      var id = this.id

      if (confirm("Are you sure you want to delete?")){
        $.ajax({
          url: `http://notes-api.com/v1/album/${id}`,
          type: "DELETE",
          success: function(data){

            if(data == "1") {
              window.location.reload()
            } else if (data == "album has associated tracks"){
              alert("Album has a track, and can therefore not be deleted.")
            } else {
              alert("album deletion failed.")
            }
          },
          error: function(e){
            console.log(e)
          }
        })
      }
    })

  // Actions for updating an album
  $("#albumsAdmin").on("click", ".update", function(e){
    let id = this.id
    $("#albumId").val(id);

    let currentTitle = this.parentElement.previousSibling.innerText
    let artistId = this.parentElement.previousSibling.previousSibling.getAttribute('artistId')

    $("#albumName").text(currentTitle)
    $("#artistId").val(artistId)

    $("#finishUpdate").attr("albumId", id)

    let modal = $("#updateModal")
    modal.css("display", "block")

    $.ajax({
      url: "http://notes-api.com/v1/artist",
      type: "GET",
      success: function(data){
        console.log(data)
        data.forEach(element => {
          $("#artistsDropdownUpdate").append($("<option>", {value: element['ArtistId'], text: element['Name']}))
        });
      }
    })
  })

  $("#finishUpdate").on("click", function(e){
    e.preventDefault()

    id = $("#albumId").val()
    artistId = $("#artistsDropdownUpdate option:selected").val()
    title = $("#nameUpdate").val()

    if( artistId == "" && title == ""){
      alert("Please provide update data")
      return;
    }

    // Could be refactored into one liner ifs
    if (artistId == "") {
      artistId = $("#artistId").val()
    }

    if (title == "") {
      title = $("#albumName").text()
    }

    $.ajax({
      url: `http://notes-api.com/v1/album/${id}`,
      type: "POST",
      data: {
        "title": title,
        "artistId": artistId 
      },
      success: function(data){
        if(data){
          window.location.reload()
        } else {
          alert("Album update failed")
        }
      },
      failure: function(e){
        console.log(e)
      }
    })
  })

  $("#cancelUpdate").on("click", function(e){
    let modal = $("#updateModal")
    modal.css("display", "none")
  })
})

function listAlbums(p){
  if($("#albumsAdmin").length){
    $("#albumsAdmin").find('tr:gt(0)').remove()
  } else {
    $("#albums").find('tr:gt(0)').remove()
  }

  $.ajax({
    url: `http://notes-api.com/v1/album?p=${p}`,
    type: "GET",
    dataType: "json",
    success: function(data){
      if(data.length < 25){
        $("#btnForward").attr("disabled", true)
      } else {
        $("#btnForward").attr("disabled", false)
      }

      data.forEach(element => {
        let tableElementName = $('<td>', {
          text: element['name'],
          artistId: element['artistId']
        })

        let tableElementTitle = $('<td>', {
          text: element['title']
        })
        
        // If the current user is an admin, show the CRUD operations
        // Else just list the Artists
        // TODO: Refactor so the appending only happens once.
        if ($('#albumsAdmin').length){
          var tableBtns = $('<td>', {
            class: "tableBtns"
          }).append($("<input>", {
            type: "image", src: "../img/information-icon.jpg", id: element['albumId']
          })).append($("<input>", {
            type: "image", src: "../img/settings-icon.png", id: element['albumId'], class: "update"
          })).append($("<input>", {
            type: "image", src: "../img/delete-icon.png", id: element['albumId'], class: "delete"
          }))
        
          $("#albumsAdmin").find('tbody')
          .append($('<tr>', {id: element['albumId']}).append(tableElementName)
          .append(tableElementTitle).append(tableBtns))
        } else {
          $("#albums").find('tbody')
          .append($('<tr>', {id: element['albumId']}).append(tableElementName)
          .append(tableElementTitle))
        }        
      });
    },
    error: function(e){
      console.log(e)
    }
  })
}