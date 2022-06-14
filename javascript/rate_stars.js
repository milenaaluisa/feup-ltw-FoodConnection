function changeStarColor () {
    const allStars = document.querySelectorAll('#user_forms .stars i');
    const grey = '#E7E7E7';
    const yellow = '#F8CF66';

    allStars.forEach(function(star, i){
        star.addEventListener('click', function(f){
            allStars.forEach(function(otherStar, j){
                if(j <= i)  {
                    otherStar.style.color = yellow;
                }    
                else
                    otherStar.style.color = grey;
            })
        })
    })
}

changeStarColor();