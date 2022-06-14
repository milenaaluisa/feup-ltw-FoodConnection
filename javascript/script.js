function updateValue(){
    for(const item of document.querySelectorAll('#restaurants > article > #orders > form > .item')){
        const id_aux = item.getAttribute('id')

        const input = document.querySelector("#restaurants > article > #orders > form input[id=" + CSS.escape(id_aux) + "]")
    
        input.addEventListener('input', function(){
            quantity = input.value
            input.setAttribute('value', quantity)
            const price_query =  document.querySelector("#restaurants > article > #orders > form .price[id=" + CSS.escape(id_aux) + "]")
            //const total_price_query = document.querySelector("#restaurants > article > #orders > form > div .total_price")
            const price = price_query.getAttribute('value')
            //total_price = total_price_query.textContent()
            price_query.textContent = (price*quantity).toFixed(2)
            
            console.log('total_price')
            //console.log((price*quantity).toFixed(2))
            //console.log(price);
            //console.log(quantity) 
        })
    }
}

updateValue()
