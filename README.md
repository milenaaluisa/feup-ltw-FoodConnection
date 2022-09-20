# ltw-t09-g01

> **2021/2022** - 2nd Year, 2nd Semester
> 
> **Course** - LTW (Linguagens e Tecnologias Web | Web Languages and Technologies)
> 
> **Project developed by**
> - Hugo Castro (up202006770)
> - Milena Gouveia (up202008862)
> - Sofia Moura (up201907201)

### Project Description
The **purpose** of this project was to create a website where restaurants can list and offer their menus for take-away. To create this application, we had to:
- Create an SQLite database that stores information about restaurants, menus, dishes, customers, and orders.
- Create documents using HTML and CSS representing the application's web pages.
- Use PHP to generate those web pages after retrieving/changing data from the database.
- Use Javascript to enhance the user experience (for example, using Ajax).
<br>

The minimum expected set of **requirements** was the following:
* **All users** should be able to (users can simultaneously be customers and restaurant owners):
    * Register a new account.
    * Login and Logout.
    * Edit their profile (at least username, password, address, and phone number).
* **Restaurant owners** should be able to:
    * Add and edit information about each one of their restaurants. Including the name, address, and category.
    * Add a list of dishes, their names, prices, photos and categories.
    * List and respond to reviews made by customers.
    * List orders and change their state (e.g., received, preparing, ready, delivered).
* **Customers** should be able to:
    * Search restaurants by name, dish name, average review score, etc.
    * Order dishes from a single restaurant.
    * Mark restaurants and dishes as favorites.
    * Review a restaurant they have ordered from (at least score and some text).
    
We also had to make sure that:
* The following technologies are all used:
HTML, CSS, PHP, Javascript, Ajax/JSON, PDO/SQL (using sqlite).
* The website should be as secure as possible, having special attention to SQL injection, XSS and CSRF attack protection, and good password storage principles.
* Code should be organized and consistent.
* Design doesn't need to be top-notch but should be clean and consistent throughout the site. It should also work on mobile devices.
* Frameworks are not allowed.
* Small helper libraries (e.g., displaying a gallery of pictures) might be allowed (talk with your practical class teacher).
<br>

Some suggested **additional requirements**. These requirements were a way of making sure each project was unique and it was not necessary to implement all of them:
* Restaurant owners should be able to add temporary promotions to dishes.
* There should be a way to keep each dish's price history.
* Users should be able to send photos of the dishes they ordered so that other users know what to expect.
* Users should receive a system notification every time something significant happens (e.g., new order, the ordered dish is on its way).
* Add more information about restaurants and dishes.
* Use the <a href="https://developer.mozilla.org/en-US/docs/Web/API/Geolocation_API"> geolocation API</a> and restaurant addresses to order the restaurants by distance.
* Add a third type of user, the driver, responsible for picking up dishes from restaurants and delivering them to customers.
  * Use the <a href="https://developer.mozilla.org/en-US/docs/Web/API/Geolocation_API"> geolocation API </a> to show the driver's location at any given time.
  * Drivers should be able to list restaurants near them that have orders almost ready to be delivered.
  * Drivers should be able to see information for orders they were given, including the customer name, address, and phone.
  * Drivers should be able to set an order's state to 'delivered.'
* Develop a REST API for the front end of the website or third-party services.

We could also create our own additional requirements.
<br>

## Features

- [x] Register
- [x] Login/Logout
- [x] Edit Profile
- [x] Add Restaurant
- [x] Edit Restaurant
- [x] Add Dishes
- [x] Add Dish Photo
- [x] List Reviews
- [x] Restaurant Owner Can Answer to Review
- [x] List Customer Orders
- [x] Change Order State
- [x] Search Restaurants
- [x] Order Dishes
- [x] List My Orders
- [x] Mark Restaurant as Favourite
- [x] Mark Dish as Favourite
- [x] Customer Can Leave a Review

## Extra Features

- [x] Customer can also rate ordered dishes
- [x] Upload Restaurant, profile and review photo
- [x] Edit Dish, Restaurant and Profile photo
- [x] Restaurant Owner can remove dishes
- [x] Add more information about dishes (allergens)

## Credentials

saradias/sara2004 <br>
lluislima/informatica2020 <br>
dav_soares/mysecretpassword <br>

## Instructions
This project needs `php-gd` to be installed:
```
sudo apt-get install php-gd
```

Start the project with the following command using wsl:

```
php -S localhost:9000/src/pages/index.php
```
