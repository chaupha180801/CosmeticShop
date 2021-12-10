function cartTotal(){
    var cartItem = document.querySelectorAll("tbody tr")
    var totalA = 0
    var tong = 0
    for(var i=0; i<cartItem.length; i++){    
        var inputValue = cartItem[i].querySelector("input");
        console.log(inputValue)
        var productPrice = cartItem[i].querySelector(".product_price span")
        inputValue = inputValue.value
        console.log(inputValue)
        productPrice = productPrice.innerHTML
        console.log(productPrice)
        totalA = inputValue * productPrice
        tong = tong + totalA
        console.log(productPrice)
    } 
       
    var cartItalA = document.querySelector(".product_total span")
    cartItalA.innerHTML = totalA
    /*   var sum = document.querySelector(".cart_amount span")
        sum.innerHTML = tong */
   
} 

var cartItem = document.querySelectorAll("tbody tr")
for(var i=0; i<cartItem.length; i++){ 
    var Item = document.querySelectorAll("tbody tr")
    for(var j=0; j<Item.length; j++){    
    var inputValue = cartItem[j].querySelector("input");
    inputValue.addEventListener("change", function(){
       cartTotal()
   })
}
}


