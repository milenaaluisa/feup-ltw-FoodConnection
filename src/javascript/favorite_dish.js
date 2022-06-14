function setFavoriteDish() {
    const likeButtons = document.querySelectorAll('#dishes > article > i')

    likeButtons.forEach(function(likeButton, index){
        likeButton.addEventListener('click', function(f){
            
            idDish = likeButton.getAttribute('data-id'); 

            if (likeButton.getAttribute('class') == "fa fa-heart-o") 
                likeButton.className = "fa fa-heart";
            else
            likeButton.className = "fa fa-heart-o";

            let request = new XMLHttpRequest()
            var url = "../api/api_like_dish.php?id=" + idDish

            request.open("GET", url, true)
            request.send()   
        })
    })
}

setFavoriteDish()