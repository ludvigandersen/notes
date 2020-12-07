$(document).ready(function(e){

  // Actions for finishing purchase
  $("#purchase").on("click", function(e){
    invoiceLine = $(".invoiceLine")
    invoiceLine = invoiceLine.slice(1)
    if(invoiceLine.length < 1){
      alert("You have no items in your cart")
      return;
    }
    let modal = $("#purchaseModal")
    modal.css("display", "block")
  })

  $("#cancelPurchase").on("click", function(e){
    let modal = $("#purchaseModal")
    modal.css("display", "none")
  })

  $("#finishPurchase").on("click", function(e){
    e.preventDefault()


    if($("#billingAddress").val() == ""){
      alert("Please provide a billing address")
      return
    }
    
    // Get all the InvoiceLines from the cart, and add them to the Items array.
    items = []

    invoiceLine = $(".invoiceLine")
    invoiceLine = invoiceLine.slice(1)
    if(invoiceLine.length < 1){
      alert("You have no items in your cart")
      return;
    }
    invoiceLine.each(function(data){
      dict = {}
      children = $(this).children('input')
      children.each(function(){
        dict[$(this).attr('id')] = $(this).val()
      })
      items.push(dict)
    })

    // Make request to API for creating an Invoice
    $.ajax({
      url: "http://notes-api.com/v1/invoice",
      type: "POST",
      data: {
        "customerId": $("#userId").val(),
        "billingAddress": $("#billingAddress").val(),
        "billingCity": $("#billingCity").val(),
        "billingState": $("#billingState").val(),
        "billingCountry": $("#billingCountry").val(),
        "billingPostalCode": $("#billingPostalCode").val(),
        "total": $("#billingTotal").val(),
        "items": items
      },
      success: function(data){
        
        if(data == "1"){
          alert("Invoice creation succeeded")
          $("#purchaseForm").submit()
        } else {
          console.log(data)
          alert("Invoice creation failed")
        }
      },
      failure: function(e){
        console.log(e)
      }
    })
  })
})