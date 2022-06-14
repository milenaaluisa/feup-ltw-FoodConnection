function  deleteDish() {
    const buttons = document.querySelectorAll('#dishes > article > .edit_options > button');

    buttons.forEach(function(button, i){
        console.log(button)
        button.addEventListener('click', function(f){
            idDish = button.getAttribute('data-id');

            let request = new XMLHttpRequest()
            var url = "../api/api_delete_dish.php?id="  + idDish

            request.open("GET", url, true)
            request.send()

            request.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    location.reload()
                }
            }
        })
    })
}

deleteDish();