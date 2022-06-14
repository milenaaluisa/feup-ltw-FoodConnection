const searchRestaurant = document.querySelector('#search_restaurant')

if(searchRestaurant) {
    searchRestaurant.addEventListener('input', async function() {
        const response = await fetch('../api/api_restaurants.php?search=' + this.value)
        const restaurants = await response.json();

        const section = document.querySelector('#restaurants')
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
            img.src = '../images/restaurants/' + restaurant.file

            img_link.appendChild(img)
            article.appendChild(img_link)

            const span = document.createElement('span')
            if(restaurant.averagePrice <= 10) span.innerHTML = '€'
            else if(restaurant.averagePrice > 10 && restaurant.averagePrice > 10) span.innerHTML = '€€'
            else span.innerHTML = '€€€'

            article.appendChild(span)

            const rate_link = document.createElement('a')
            rate_link.href = 'restaurant.php?id=' + restaurant.idRestaurant + '#reviews'
            rate_link.innerHTML = restaurant.averageRate
            const i = document.createElement('i')
            i.className = 'fa fa-star'
            i.style.color = '#f8cf66'
            rate_link.appendChild(i)
            

            article.appendChild(rate_link)
            
            section.appendChild(article)
        }
    })
}