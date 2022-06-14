function changeOrderState() {
    const states = document.querySelectorAll('#restaurants > article > #orders > article > select');

    states.forEach(function(state, i) {
        idFoodOrder = state.getAttribute('data-id');

        state.addEventListener('change', function(){
            idOrder = state.getAttribute('data-id');
            newState = state.value;
            newState = newState.substring(1);
            console.log(newState);
            let request = new XMLHttpRequest()
            
            var url = "../api/api_order_state.php?state=" + newState + "&idOrder=" + idOrder;
            request.open("GET", url, true)
            request.send()
        })
    })
}

changeOrderState();