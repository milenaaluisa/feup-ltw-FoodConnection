function updateValue(){
    for(const item of document.querySelectorAll('#restaurants > article > #orders > form > .item')){
        const id_aux = item.getAttribute('id');

        const input = document.querySelector("#restaurants > article > #orders > form input[id=" + CSS.escape(id_aux) + "]");
        const quantity = input.getAttribute('value')
        console.log(quantity); 
    }
}

updateValue()