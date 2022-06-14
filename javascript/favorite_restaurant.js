function setFavoriteRestaurant() {
    const likeButtons = document.querySelectorAll('#restaurants > article > i')

    likeButtons.forEach(function(likeButton, index){
        console.log(likeButton) 
        likeButton.addEventListener('click', function(f){
            
            idRestaurant = likeButton.getAttribute('data-id'); 
            console.log(idRestaurant)  

            if (likeButton.getAttribute('class') == "fa fa-heart-o") 
                likeButton.className = "fa fa-heart";
            else
            likeButton.className = "fa fa-heart-o";

            let request = new XMLHttpRequest()
            var url = "../api/api_like_restaurant.php?id=" + idRestaurant

            request.open("GET", url, true)
            request.send()   
        })
    })
}

setFavoriteRestaurant()