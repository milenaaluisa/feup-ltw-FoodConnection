const searchRestaurant = document.querySelector('#search_restaurant')

if(searchRestaurant) {
    searchRestaurant.addEventListener('input', async function() {
        const response = await fetch('../api/api_restaurants.php?search=' + this.value)
        const restaurants = await response.json();

        const section = document.querySelector('#categories')
        section.innerHTML = ''

        for(const restaurant of restaurants) {
            const article = document.createElement('article')

            const header = document.createElement('header')
            const h2 = document.createElement('h2')
            const link = document.createElement('a')
            link.href = '../pages/restaurant.php?id=' + restaurant.idRestaurant
            link.textContent = restaurant.name

            h2.appendChild(link)
            header.appendChild(h2)
            article.appendChild(header)

            const img_link = document.createElement('a')
            img_link.href = 'restaurant.php?id=' + restaurant.idRestaurant
            const img = document.createElement('img')
            img.src = '../images/restaurants' + restaurant.file

            img.appendChild(img_link)
            article.appendChild(img)

            const rate_link = document.createElement('a')

            article.appendChild(rate_link)
            
            section.appendChild(article)
        }
    })
}