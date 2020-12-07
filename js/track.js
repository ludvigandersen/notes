$(document).ready(function(e){

  listTracks(0)

  // Navigating track table
  $("#btnForward").on("click", function(e){
    p = $(this).attr('page')
    listTracks(p)
    count = ++ p
    $(this).attr('page', count)
    $("#btnBackward").attr('page', count - 2)
    $("#btnBackward").attr('disabled', false)
  })

  $("#btnBackward").on("click", function(e){
    p = $(this).attr('page')
    listTracks(p)
    count = -- p
    $(this).attr('page', count)
    count = ++ p
    count = ++ p
    $("#btnForward").attr('page', count)
    if($(this).attr('page') == -1){
      $(this).attr('disabled', true)
    }
  })

  // Actions for searching track by title
  $("#btnSearch").on("click", function(e){
    e.preventDefault()

    if($("#searchTitle").val() == ""){
      alert("Please provide search title")
      return;
    }
    title = $("#searchTitle").val()

    $.ajax({
      url: `http://notes-api.com/v1/track?q=${title}&t=title`,
      type: "GET",
      success: function(data){
        list(data)
      }
    })
  })

  // Actions for searching track by album
  $("#btnSearchAlbum").on("click", function(e){
    e.preventDefault()

    if($("#searchAlbum").val() == ""){
      alert("Please provide search album")
      return;
    }
    title = $("#searchAlbum").val()

    $.ajax({
      url: `http://notes-api.com/v1/track?q=${title}&t=album`,
      type: "GET",
      success: function(data){
        list(data)
      }
    })
  })

  // Actions for creating tracks
  $("#createTrackBtn").on("click", function(e){
    let modal = $("#createModal")
    modal.css("display", "block")

    $.ajax({
      url: "http://notes-api.com/v1/album",
      type: "GET",
      success: function(data){
        console.log(data)
        data.forEach(element => {
          $("#albumsDropdownCreate").append($("<option>", {value: element['albumId'], text: element['title']}))
        });
      }
    })

    $.ajax({
      url: "http://notes-api.com/v1/genre",
      type: "GET",
      success: function(data){
        console.log(data)
        data.forEach(element => {
          $("#genresDropdownCreate").append($("<option>", {value: element['genreId'], text: element['genre']}))
        });
      }
    })
  })

  $("#finishCreate").on("click", function(e){
    e.preventDefault()
    console.log($("#price").val())
    
    // Filling out and deleting contents of text input not validated
    // This makes sure it is always validated
    if ($("#name").val() == "" || $("#composers").val() == ""){
      alert("Please provide valid name and composers")
      return false;
    } else if ($("#price").val() == "" || $("#length").val() == "") {
      alert("Please provide valid numerical price and length")
      return false;
    }


    $.ajax({
      url: "http://notes-api.com/v1/track",
      type: "POST",
      data: {
        "title": $("#name").val(),
        "albumId": $("#albumsDropdownCreate option:selected").val(),
        "genreId": $("#genresDropdownCreate option:selected").val(),
        "price": $("#price").val(),
        "mediaTypeId": $("#mediaTypesDropdownCreate option:selected").val(),
        "composers": $("#composers").val(),
        "length": $("#length").val()
      },
      success: function(data){
        console.log(data)
        if(data == "1"){
          alert("Track creation succeeded")
          window.location.reload()
        } else {
          console.log(data)
          alert("Track creation failed")
        }
      },
      failure: function(e){
        console.log(e)
      }
    })
  })

  $("#cancelCreate").on("click", function(e){
    let modal = $("#createModal")
    modal.css("display", "none")
  })

  // Actions for deleting tracks
  $("#tracksAdmin").on("click", ".delete", function(e){
    var id = this.id
  
    if (confirm("Are you sure you want to delete?")){
      $.ajax({
        url: `http://notes-api.com/v1/track/${id}`,
        type: "DELETE",
        success: function(data){
          if(data['status'] == "track has been purchased"){
            alert("Track has been purchased, and can therefore not be delete")
            return
          } else if(data) {
            window.location.reload()
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

  // Actions for updating tracks
  $("#tracksAdmin").on("click", ".update", function(e){
    let id = this.id
    $("#trackId").val(id);

    let currentTitle = this.parentElement.previousSibling.previousSibling.previousSibling.previousSibling.innerText
    $("#trackName").text(currentTitle)
    $("#nameUpdate").val(currentTitle)

    let modal = $("#updateModal")
    modal.css("display", "block")

    $.ajax({
      url: "http://notes-api.com/v1/album",
      type: "GET",
      success: function(data){
        console.log(data)
        data.forEach(element => {
          $("#albumsDropdownUpdate").append($("<option>", {value: element['albumId'], text: element['title']}))
        });
      }
    })

    $.ajax({
      url: "http://notes-api.com/v1/genre",
      type: "GET",
      success: function(data){
        // console.log(data)
        data.forEach(element => {
          // console.log(element)
          $("#genresDropdownUpdate").append($("<option>", {value: element['genreId'], text: element['genre']}))
        });
      }
    })
  })

  $("#finishUpdate").on("click", function(e){
    e.preventDefault()
    id = $("#trackId").val()

    // Filling out and deleting contents of text input not validated
    // This makes sure it is always validated
    if ($("#nameUpdate").val() == "" || $("#composersUpdate").val() == ""){
      return false;
    }

    $.ajax({
      url: `http://notes-api.com/v1/track/${id}`,
      type: "POST",
      data: {
        "title": $("#nameUpdate").val(),
        "albumId": $("#albumsDropdownUpdate option:selected").val(),
        "genreId": $("#genresDropdownUpdate option:selected").val(),
        "price": $("#priceUpdate").val(),
        "mediaTypeId": $("#mediaTypesDropdownUpdate option:selected").val(),
        "composers": $("#composersUpdate").val(),
        "length": $("#lengthUpdate").val()
      },
      success: function(data){
        console.log(data)
        if(data){
          alert("Album update succeeded")
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

function listTracks(p){
  // Listing all track
  if($("#tracksAdmin").length){
    $("#tracksAdmin").find('tr:gt(0)').remove()
  } else {
    $("#tracks").find('tr:gt(0)').remove()
  }
  
  $.ajax({
    url: `http://notes-api.com/v1/track?p=${p}`,
    type: "GET",
    dataType: "json",
    success: function(data){
      if(data.length < 25){
        $("#btnForward").attr("disabled", true)
      } else {
        $("#btnForward").attr("disabled", false)
      }
      
      list(data)
    },
    error: function(e){
      console.log(e)
    }
  })
}

function list(data){
  if($("#tracksAdmin").length){
    $("#tracksAdmin").find('tr:gt(0)').remove()
  } else {
    $("#tracks").find('tr:gt(0)').remove()
  }

  data.forEach(element => {
    let tableElementTitle = $('<td>', {
      text: element['trackName']
    })

    let tableElementAlbum = $('<td>', {
      text: element['albumTitle']
    })

    let tableElementGenre = $('<td>', {
      text: element['genre']
    })

    let tableElementPrice = $('<td>', {
      text: element['unitPrice']
    })
    
    // If the current user is an admin, show the CRUD operations
    // Else just list the Tracks
    // TODO: Refactor so the appending only happens once.
    if ($('#tracksAdmin').length){
      var tableBtns = $('<td>', {
        class: "tableBtns"
      }).append($("<input>", {
        type: "image", src: "../img/information-icon.jpg", id: element['trackId']
      })).append($("<input>", {
        type: "image", src: "../img/settings-icon.png", id: element['trackId'], class: "update"
      })).append($("<input>", {
        type: "image", src: "../img/delete-icon.png", id: element['trackId'], class: "delete"
      }))
    
      $("#tracksAdmin").find('tbody')
      .append($('<tr>', {id: element['trackId']}).append(tableElementTitle)
      .append(tableElementAlbum).append(tableElementGenre).append(tableElementPrice).append(tableBtns))
    } else {
      let form = $("<form>", { method: "post", action: "track.php"})
      let inputTitle = $("<input>", { type: "hidden", name: "title", value: element['trackName']})
      let inputAlbum = $("<input>", { type: "hidden", name: "album", value: element['albumTitle']})
      let inputGenre = $("<input>", { type: "hidden", name: "genre", value: element['genre']})
      let inputPrice = $("<input>", { type: "hidden", name: "price", value: element['unitPrice']})
      let inputId = $("<input>", { type: "hidden", name: "trackId", value: element['trackId']})
        
      form.append(inputTitle).append(inputAlbum).append(inputGenre).append(inputPrice).append(inputId)
      form.append($("<button>", { type: "submit", text: "Purchase"}))

      var tableBtns = $('<td>', {
        class: "tableBtn"
      }).append(form)

      $("#tracks").find('tbody')
      .append($('<tr>', {id: element['trackId']}).append(tableElementTitle)
      .append(tableElementAlbum).append(tableElementGenre).append(tableElementPrice).append(tableBtns))
    }        
  });
}