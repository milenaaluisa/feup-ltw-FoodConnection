DROP TABLE IF EXISTS User;
DROP TABLE IF EXISTS Restaurant;
DROP TABLE IF EXISTS Category;
DROP TABLE IF EXISTS RestaurantCategory;
DROP TABLE IF EXISTS Shift;
DROP TABLE IF EXISTS RestaurantShift;
DROP TABLE IF EXISTS Menu;
DROP TABLE IF EXISTS FoodOrder;
DROP TABLE IF EXISTS Dish;
DROP TABLE IF EXISTS Review;
DROP TABLE IF EXISTS Photo;
DROP TABLE IF EXISTS MenuDish;
DROP TABLE IF EXISTS Allergen;
DROP TABLE IF EXISTS DishAllergen;
DROP TABLE IF EXISTS Selection;
DROP TABLE IF EXISTS Reply;
DROP TABLE IF EXISTS FavRestaurant;
DROP TABLE IF EXISTS FavDish;
DROP TABLE IF EXISTS DishCategory;

/*******************************************************************************
   Create Tables
********************************************************************************/
CREATE TABLE User
(
    name VARCHAR,
    address VARCHAR NOT NULL,
    zipCode VARCHAR NOT NULL,
    city VARCHAR NOT NULL,
    email VARCHAR NOT NULL UNIQUE,
    phoneNum INT CHECK(length(phoneNum) = 9) NOT NULL UNIQUE,
    username VARCHAR(15) PRIMARY KEY,
    password VARCHAR(15) NOT NULL
);

CREATE TABLE Restaurant
(
    idRestaurant INTEGER PRIMARY KEY,
    name VARCHAR NOT NULL,
    averagePrice REAL(2,1) NOT NULL DEFAULT(0),
    phoneNum INT NOT NULL,
    address VARCHAR NOT NULL,
    averageRate INT NOT NULL DEFAULT(0),
    owner VARCHAR NOT NULL REFERENCES User(username)
);

CREATE TABLE Category
(
    idCategory INT PRIMARY KEY,
    name VARCHAR NOT NULL
);

CREATE TABLE RestaurantCategory
(
    idRestaurant INT NOT NULL REFERENCES Restaurant(idRestaurant),
    idCategory INT NOT NULL REFERENCES Category(idCategory),
    PRIMARY KEY(idRestaurant, idCategory)
);

CREATE TABLE Shift
(
    idShift INT PRIMARY KEY,
    openingTime TIME NOT NULL,
    closingTime TIME NOT NULL,
    day VARCHAR NOT NULL
);

CREATE TABLE RestaurantShift
(
    idRestaurant INT NOT NULL REFERENCES Restaurant(idRestaurant),
    idShift INT NOT NULL REFERENCES Shift(idShift),
    PRIMARY KEY (idRestaurant, idShift)
);

CREATE TABLE Menu
(
    idMenu INTEGER PRIMARY KEY,
    price REAL(5, 2) NOT NULL,
    idRestaurant INT NOT NULL REFERENCES Restaurant(idRestaurant)
);

CREATE TABLE FoodOrder
( 
    idFoodOrder INTEGER PRIMARY KEY,     
    state VARCHAR NOT NULL CHECK(state = 'received' OR state = 'preparing' OR state = 'ready' OR state = 'delivered'),  
    orderDate DATE NOT NULL,   
    username VARCHAR NOT NULL REFERENCES User(username)
);

CREATE TABLE Dish
(
    idDish INTEGER PRIMARY KEY,
    name VARCHAR NOT NULL,
    ingredients VARCHAR,
    price REAL(5,2) NOT NULL,
    priceHistory VARCHAR NOT NULL DEFAULT(' '),
    averageRate INT NOT NULL DEFAULT(0), 
    idRestaurant INT NOT NULL REFERENCES Restaurant(idRestaurant)
);

CREATE TABLE Review
(
    idReview INTEGER PRIMARY KEY,
    comment VARCHAR, 
    rate INT NOT NULL CHECK(rate >= 1 and rate <= 5),
    reviewDate DATE NOT NULL,
    idFoodOrder INT REFERENCES FoodOrder(idFoodOrder)
);

CREATE TABLE Photo
(
    idPhoto INTEGER PRIMARY KEY,
    file VARCHAR NOT NULL,
    idRestaurant INTEGER REFERENCES Restaurant(idRestaurant),
    idReview INT REFERENCES Review(idReview),
    username INT REFERENCES User(username),
    idDish INT REFERENCES Dish(idDish)
);

CREATE TABLE MenuDish 
(
    idMenu INT NOT NULL REFERENCES Menu(idMenu),
    idDish INT NOT NULL REFERENCES Dish(idDish),
    PRIMARY KEY (idMenu, idDish)
);

CREATE TABLE Allergen 
(
    idAllergen INT PRIMARY KEY,
    name VARCHAR
);

CREATE TABLE DishAllergen
(
    idDish INT NOT NULL REFERENCES Dish(idDish),
    idAllergen INT NOT NULL REFERENCES Allergen(idAllergen),
    PRIMARY KEY(idDish, idAllergen)
);

CREATE TABLE Selection
(
    quantity INT NOT NULL,
    extras VARCHAR,
    notes VARCHAR,
    idFoodOrder INT NOT NULL REFERENCES FoodOrder(idFoodOrder),
    idDish INT NOT NULL REFERENCES Dish(idDish),
    PRIMARY KEY (idFoodOrder, idDish)
);

CREATE TABLE Reply
(
    idReplay INTEGER PRIMARY KEY,
    comment VARCHAR NOT NULL,
    owner VARCHAR NOT NULL REFERENCES User(username),
    idReview INT NOT NULL REFERENCES Review(idReview)
);

CREATE TABLE FavRestaurant
(
    idRestaurant INT NOT NULL REFERENCES Restaurant(idRestaurant),
    username INT NOT NULL REFERENCES User(username),
    PRIMARY KEY(idRestaurant, username)
);

CREATE TABLE FavDish(
    idDish INT NOT NULL REFERENCES Dish(idDish),
    username INT NOT NULL REFERENCES User(username),
    PRIMARY KEY (idDish, username)
);

CREATE TABLE DishCategory(
    idDish INT NOT NULL REFERENCES Dish(idDish), 
    idCategory INT NOT NULL REFERENCES Category(idCategory),
    PRIMARY KEY(idDish, idCategory)
);

/*******************************************************************************
   Create Triggers
********************************************************************************/
---Trigger that updates the restaurant average rating every time the users review their order  
CREATE TRIGGER IF NOT EXISTS RestaurantRate
AFTER INSERT ON Review
WHEN (new.idFoodOrder NOT NULL)

BEGIN
    UPDATE Restaurant
    SET averageRate = (SELECT avg(rate) 
                      FROM Review NATURAL JOIN FoodOrder NATURAL JOIN Selection NATURAL JOIN Dish NATURAL JOIN Restaurant 
                      WHERE Dish.idRestaurant = (SELECT idRestaurant 
                                                 FROM Dish NATURAL JOIN (SELECT idDish 
                                                                         FROM Selection NATURAL JOIN FoodOrder 
                                                                         WHERE FoodOrder.idFoodOrder = new.idFoodOrder LIMIT 1)))

    WHERE idRestaurant = (SELECT idRestaurant 
                         FROM Dish NATURAL JOIN (SELECT idDish 
                                                 FROM Selection NATURAL JOIN FoodOrder 
                                                 WHERE FoodOrder.idFoodOrder = new.idFoodOrder LIMIT 1));
END;

---Trigger that updates the dish average rating every time a new review is inserted
CREATE TRIGGER IF NOT EXISTS DishRate
AFTER INSERT ON Review  
WHEN (new.idDish NOT NULL)

BEGIN
    UPDATE Dish
    SET averageRate = (SELECT avg(rate) 
                       FROM Review
                       WHERE idDish = new.idDish)
    WHERE idDish = new.idDish;
END;

---Trigger that updates the average price of a restaurant every time a new dish is inserted
CREATE TRIGGER IF NOT EXISTS InsertDishUpdateAvgPrice
AFTER INSERT ON Dish
For Each Row
BEGIN
    UPDATE Restaurant
    SET averagePrice = (SELECT avg(price) FROM Dish WHERE idRestaurant = new.idRestaurant)
    WHERE idRestaurant = new.idRestaurant;
END;

---Trigger that updates the average price of the restaurant when the price of a certain dish is updated
CREATE TRIGGER IF NOT EXISTS UpdateDishUpdateAvgPrice
AFTER UPDATE ON Dish
For Each Row
BEGIN
    UPDATE Restaurant
    SET averagePrice = (SELECT avg(price) FROM Dish WHERE idRestaurant = new.idRestaurant)
    WHERE idRestaurant = new.idRestaurant;
END;

---Trigger that updates the price history of a dish when its price changes
CREATE TRIGGER IF NOT EXISTS UpdatePriceHistory
AFTER UPDATE ON Dish
WHEN (new.price <> old.price)

BEGIN
    UPDATE Dish
    SET priceHistory = priceHistory || ';' || new.price
    WHERE idDish = new.idDish;
END;

---Trigger that inserts dish price into priceHistory
CREATE TRIGGER IF NOT EXISTS NewDishPriceHistory
AFTER INSERT ON Dish
BEGIN
    UPDATE Dish
    SET priceHistory = new.price
    WHERE idDish = new.idDish;
END;

/*******************************************************************************
   Populate Tables
********************************************************************************/
INSERT INTO User(name, username, email, phoneNum, address, zipCode, city, password) VALUES ('Sara Dias', 'saradias', 'sarinhadias2004@gmail.com', 937856499, "Rua Padre Francisco Rangel 63","4250-156", "Porto", "ea2a2729de977ba3a862c870eaa13211");
INSERT INTO User(name, username, email, phoneNum, address, zipCode, city, password) VALUES ('Luís Lima', 'lluislima', 'luis23lima@hotmail.com', 966567899, "Rua da Esperanca 21", "9760-100", "Lisboa", "843d8348d5302f4c2a88742401263e81");
INSERT INTO User(name, username, email, phoneNum, address, zipCode, city, password) VALUES ('Maria Azevedo', 'mariaa12', 'mariazevedo@hotmail.com', 934746528, "R. de Gonçalo Sampaio 243", "4150-367", "Porto", "25f9e794323b453885f5181f1b624d0b");
INSERT INTO User(name, username, email, phoneNum, address, zipCode, city, password) VALUES ('David Soares', 'dav_soares', 'soaresdavid@gmail.com', 935665584, "R. de Montebelo 97B", "4150-131", "Porto", "bed128365216c019988915ed3add75fb");
INSERT INTO User(name, username, email, phoneNum, address, zipCode, city, password) VALUES ('Nicole Oliveira', 'nicoleolive', 'nicoleeoli@outlook.pt', 951554887, "Rua de Santos Pousada 673", "4000-156", "Porto", "1ab765246e9269d9625860509ce6d058");
INSERT INTO User(name, username, email, phoneNum, address, zipCode, city, password) VALUES ('Filipe Pereira', 'fpereira', 'filipereira71@gmail.com' , 937441147, "Tv. de Cedofeita 24", "4050-448", "Porto", "5badcaf789d3d1d09794d8f021f40f0e");
INSERT INTO User(name, username, email, phoneNum, address, zipCode, city, password) VALUES ('Rui Sousa', 'ruisousa4', 'ruisousa4@hotmail.com', 922357445, "Canada da Vista 15", "9760-110", "Almada", "f980131d96ce601bdf198079d863c5cb");
INSERT INTO User(name, username, email, phoneNum, address, zipCode, city, password) VALUES ('Rute Martins', 'rute5martins', 'rutemartins5@outlook.pt', 912778963, "Rua Carlos Manuel 23", "4200-156", "Porto", "e8cc834e7bd6b88620945d55cd1c7f74");      
INSERT INTO User(name, username, email, phoneNum, address, zipCode, city, password) VALUES ('Henrique Costa', 'henricosta45', 'costahenrique@gmail.com' , 925446778, "Tv. de Lima 55", "4200-205", "Coimbra", "fcdbd9372ebe5d77896b2d930a0d2f71");
INSERT INTO User(name, username, email, phoneNum, address, zipCode, city, password) VALUES ('Bruna Vaz', 'brunaavazz1', 'bruna1vaz@hotmail.com', 913456654, "Canada do Saco 36", "9760-456", "Almada", "f42a8d5e0ca020033e6bcc7e05539a1f");
INSERT INTO User(name, username, email, phoneNum, address, zipCode, city, password) VALUES ('Cláudio Ornelas', 'ornelasclaudio', 'ornelasclaudio@outlook.pt', 934998789, "Rua de Baixo 42", "4000-894", "Aveiro", "22105931d28282314fc3edbb66e0b4f4");
INSERT INTO User(name, username, email, phoneNum, address, zipCode, city, password) VALUES ('Nuno Amaro', 'nunoamaro13', 'nunoamaro13@gmail.com' , 919789369, "Tv. de Sao Cristovao 1", "4050-101", "Porto", "80df6758cdb8b27fd2ab3077e4016679");
INSERT INTO User(name, username, email, phoneNum, address, zipCode, city, password) VALUES ('Andreia Silva', 'dreiasilva', 'andreiasilava08@gmail.com', 934518743, "Rua das Andresas 306", "4100-051", "Porto","4cab2a2db6a3c31b01d804def28276e6");

INSERT INTO Restaurant(idRestaurant, name, phoneNum, address, owner) VALUES(1, 'Camélia Brunch Garden', 226170009, 'Rua do Passeio Alegre, 368', 'saradias');
INSERT INTO Restaurant(idRestaurant, name, phoneNum, address, owner) VALUES(2, 'Eleven Lab Concept', 910550994, 'Rua do Ouro nº 418', 'saradias');
INSERT INTO Restaurant(idRestaurant, name, phoneNum, address, owner) VALUES(3, 'Starbucks', 'Rua Mouzinho da Silveira, 188', 220437782, 'saradias');
INSERT INTO Restaurant(idRestaurant, name, phoneNum, address, owner) VALUES(4, 'DeGema', 221116336, 'Rua Fonte da Luz, 217', 'lluislima');
INSERT INTO Restaurant(idRestaurant, name, phoneNum, address, owner) VALUES(5, 'Noshi Healthy Food', 222053034, 'Rua do Carmo, 11/12', 'lluislima');
INSERT INTO Restaurant(idRestaurant, name, phoneNum, address, owner) VALUES(6, 'Apuro', 224024756, 'Rua do Breiner, 236', 'lluislima');
INSERT INTO Restaurant(idRestaurant, name, phoneNum, address, owner) VALUES(7, 'Fava Tonka', 915343494, 'Rua de Santa Catarina, 100', 'lluislima');
INSERT INTO Restaurant(idRestaurant, name, phoneNum, address, owner) VALUES(8, 'Manna', 223161536, 'Rua da Conceicao 60', 'mariaa12');
INSERT INTO Restaurant(idRestaurant, name, phoneNum, address, owner) VALUES(9, 'Nola Kitchen', 910595015, 'Praça Dona Filipa de Lencastre, 25', 'mariaa12');
INSERT INTO Restaurant(idRestaurant, name, phoneNum, address, owner) VALUES(10, 'Subenshi', 964097707, 'Campo Dos Martires da Patria, 65', 'mariaa12');
INSERT INTO Restaurant(idRestaurant, name, phoneNum, address, owner) VALUES(11, 'Sushihana', 916551972, 'Rua Professor Mota Pinto, 138', 'dav_soares');
INSERT INTO Restaurant(idRestaurant, name, phoneNum, address, owner) VALUES(12, 'Noodles by RO', 967307887, 'Norteshopping, Rua Sara Afonso, 105-117', 'dav_soares');
INSERT INTO Restaurant(idRestaurant, name, phoneNum, address, owner) VALUES(13, 'Taco Bell', 932160090, 'Norteshopping, Rua Sara Afonso, 105-117', 'dav_soares');
INSERT INTO Restaurant(idRestaurant, name, phoneNum, address, owner) VALUES(14, 'Guaka', 910153794, 'Rua de Santo Ildefonso, 305', 'dav_soares');
INSERT INTO Restaurant(idRestaurant, name, phoneNum, address, owner) VALUES(15, 'Boteco Mexicano', 964249974, 'Campo dos Mártires da Pátria 38-41', 'nicoleolive');
INSERT INTO Restaurant(idRestaurant, name, phoneNum, address, owner) VALUES(16, 'Real Indiana', 226162107, 'Avenida de Montevideu, 26', 'nicoleolive');
INSERT INTO Restaurant(idRestaurant, name, phoneNum, address, owner) VALUES(17, 'Chutnify Canteen', 229542114, 'The Cook Book, Norteshopping Piso 1, Rua Sara Afonso', 'nicoleolive');
INSERT INTO Restaurant(idRestaurant, name, phoneNum, address, owner) VALUES(18, 'Indi Go Indian Flavours', 226065136, 'Arrábida Shopping, Praceta Henrique Moreira, 244', 'nicoleolive');
INSERT INTO Restaurant(idRestaurant, name, phoneNum, address, owner) VALUES(19, 'Bocca', 226170004, 'Rua do Passeio Alegre, Jardim das Sobreiras, Lj 1', 'fpereira');
INSERT INTO Restaurant(idRestaurant, name, phoneNum, address, owner) VALUES(20, "Casad'oro", 226106012, 'Rua do Ouro, 797', 'fpereira');
INSERT INTO Restaurant(idRestaurant, name, phoneNum, address, owner) VALUES(21, 'Modì', 223186690, 'Praça Cidade do Salvador, 296', 'fpereira');
INSERT INTO Restaurant(idRestaurant, name, phoneNum, address, owner) VALUES(22, 'Capa Negra II', 226078383, 'Rua do Campo Alegre, 191', 'ruisousa4'); 
INSERT INTO Restaurant(idRestaurant, name, phoneNum, address, owner) VALUES(23, "Madureira's", 220138373, 'Rua da Praia, 9950', 'ruisousa4');
INSERT INTO Restaurant(idRestaurant, name, phoneNum, address, owner) VALUES(24, 'Taberna Londrina', 221119320, 'Estrada da Circunvalação, 7964', 'ruisousa4');
INSERT INTO Restaurant(idRestaurant, name, phoneNum, address, owner) VALUES(25, 'Tâmaras - Pastelaria Saudável', 912345678, 'R. de José Falcão 157 Loja 10', 'rute5martins');
INSERT INTO Restaurant(idRestaurant, name, phoneNum, address, owner) VALUES(26, 'Cremosi', 935401378, 'Rua do Passeio Alegre, 372-380', 'rute5martins');
INSERT INTO Restaurant(idRestaurant, name, phoneNum, address, owner) VALUES(27, 'Tavi', 226180152, 'Rua da Senhora da Luz, 368', 'rute5martins');
INSERT INTO Restaurant(idRestaurant, name, phoneNum, address, owner) VALUES(28, 'Padaria Ribeiro', 222005067, 'Praça Guilherme Gomes Fernandes, 21', 'henricosta45');
INSERT INTO Restaurant(idRestaurant, name, phoneNum, address, owner) VALUES(29, 'Rooftop Santa Catarina', 915452459, 'La Vie, Rua de Fernandes Tomás, 508', 'henricosta45');
INSERT INTO Restaurant(idRestaurant, name, phoneNum, address, owner) VALUES(30, "B'Artist, The Artist - Porto Hotel e Bistrô", 220132700, 'Rua da Firmeza, 49', 'henricosta45');
INSERT INTO Restaurant(idRestaurant, name, phoneNum, address, owner) VALUES(31, "Daikiri Bar" , 918424324, "Rua da Praia, 907", 'henricosta45');

INSERT INTO Category(idCategory, name) VALUES(1, 'Breakfast');
INSERT INTO Category(idCategory, name) VALUES(2, 'Vegetarian');
INSERT INTO Category(idCategory, name) VALUES(3, 'Vegan');
INSERT INTO Category(idCategory, name) VALUES(4, 'Japanese');
INSERT INTO Category(idCategory, name) VALUES(5, 'Mexican');
INSERT INTO Category(idCategory, name) VALUES(6, 'Indian');
INSERT INTO Category(idCategory, name) VALUES(7, 'Italian');
INSERT INTO Category(idCategory, name) VALUES(8, 'Portuguese');
INSERT INTO Category(idCategory, name) VALUES(9, 'Fast-food');
INSERT INTO Category(idCategory, name) VALUES(10, 'Healthy');
INSERT INTO Category(idCategory, name) VALUES(11, 'Dessert');
INSERT INTO Category(idCategory, name) VALUES(12, 'Bakery');
INSERT INTO Category(idCategory, name) VALUES(13, 'Drinks');

INSERT INTO RestaurantCategory(idRestaurant, idCategory) VALUES(1, 1);
INSERT INTO RestaurantCategory(idRestaurant, idCategory) VALUES(2, 1);
INSERT INTO RestaurantCategory(idRestaurant, idCategory) VALUES(3, 1);
INSERT INTO RestaurantCategory(idRestaurant, idCategory) VALUES(3, 12);
INSERT INTO RestaurantCategory(idRestaurant, idCategory) VALUES(4, 2);
INSERT INTO RestaurantCategory(idRestaurant, idCategory) VALUES(4, 9);
INSERT INTO RestaurantCategory(idRestaurant, idCategory) VALUES(5, 2);
INSERT INTO RestaurantCategory(idRestaurant, idCategory) VALUES(5, 10);
INSERT INTO RestaurantCategory(idRestaurant, idCategory) VALUES(6, 2);
INSERT INTO RestaurantCategory(idRestaurant, idCategory) VALUES(6, 9);
INSERT INTO RestaurantCategory(idRestaurant, idCategory) VALUES(7, 3);
INSERT INTO RestaurantCategory(idRestaurant, idCategory) VALUES(7, 10);
INSERT INTO RestaurantCategory(idRestaurant, idCategory) VALUES(8, 3);
INSERT INTO RestaurantCategory(idRestaurant, idCategory) VALUES(9, 3);
INSERT INTO RestaurantCategory(idRestaurant, idCategory) VALUES(10, 4);
INSERT INTO RestaurantCategory(idRestaurant, idCategory) VALUES(11, 4);
INSERT INTO RestaurantCategory(idRestaurant, idCategory) VALUES(12, 4);
INSERT INTO RestaurantCategory(idRestaurant, idCategory) VALUES(13, 5);
INSERT INTO RestaurantCategory(idRestaurant, idCategory) VALUES(13, 9);
INSERT INTO RestaurantCategory(idRestaurant, idCategory) VALUES(14, 5);
INSERT INTO RestaurantCategory(idRestaurant, idCategory) VALUES(15, 5);
INSERT INTO RestaurantCategory(idRestaurant, idCategory) VALUES(16, 6);
INSERT INTO RestaurantCategory(idRestaurant, idCategory) VALUES(17, 6);
INSERT INTO RestaurantCategory(idRestaurant, idCategory) VALUES(18, 6);
INSERT INTO RestaurantCategory(idRestaurant, idCategory) VALUES(19, 7);
INSERT INTO RestaurantCategory(idRestaurant, idCategory) VALUES(20, 7);
INSERT INTO RestaurantCategory(idRestaurant, idCategory) VALUES(21, 7);
INSERT INTO RestaurantCategory(idRestaurant, idCategory) VALUES(21, 11);
INSERT INTO RestaurantCategory(idRestaurant, idCategory) VALUES(22, 8);
INSERT INTO RestaurantCategory(idRestaurant, idCategory) VALUES(23, 8);
INSERT INTO RestaurantCategory(idRestaurant, idCategory) VALUES(24, 8);
INSERT INTO RestaurantCategory(idRestaurant, idCategory) VALUES(25, 10);
INSERT INTO RestaurantCategory(idRestaurant, idCategory) VALUES(25, 11);
INSERT INTO RestaurantCategory(idRestaurant, idCategory) VALUES(26, 11);
INSERT INTO RestaurantCategory(idRestaurant, idCategory) VALUES(27, 12);
INSERT INTO RestaurantCategory(idRestaurant, idCategory) VALUES(28, 12);
INSERT INTO RestaurantCategory(idRestaurant, idCategory) VALUES(29, 13);
INSERT INTO RestaurantCategory(idRestaurant, idCategory) VALUES(30, 13);
INSERT INTO RestaurantCategory(idRestaurant, idCategory) VALUES(31, 13);

INSERT INTO Shift(idShift, openingTime, closingTime, day) VALUES(1, '8:00:00', '12:00:00', 'Business days');
INSERT INTO Shift(idShift, openingTime, closingTime, day) VALUES(2, '8:00:00', '12:00:00', 'Saturday');
INSERT INTO Shift(idShift, openingTime, closingTime, day) VALUES(3, '8:00:00', '12:00:00', 'Sundays');
INSERT INTO Shift(idShift, openingTime, closingTime, day) VALUES(4, '12:00:00', '14:30:00', 'Business days');
INSERT INTO Shift(idShift, openingTime, closingTime, day) VALUES(5, '13:00:00', '14:30:00', 'Saturday');
INSERT INTO Shift(idShift, openingTime, closingTime, day) VALUES(6, '13:00:00', '15:00:00', 'Sunday');
INSERT INTO Shift(idShift, openingTime, closingTime, day) VALUES(7, '11:00:00', '14:00:00', 'Holiday');
INSERT INTO Shift(idShift, openingTime, closingTime, day) VALUES(8, '19:30:00', '23:30:00', 'Business days');
INSERT INTO Shift(idShift, openingTime, closingTime, day) VALUES(9, '20:00:00', '24:00:00', 'Saturday');
INSERT INTO Shift(idShift, openingTime, closingTime, day) VALUES(10, '20:00:00', '24:00:00', 'Sunday');
INSERT INTO Shift(idShift, openingTime, closingTime, day) VALUES(11, '19:00:00', '22:00:00', 'Holiday');

INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(1, 1);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(2, 1);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(2, 2);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(3, 1);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(3, 2);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(3, 3);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(4, 4);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(5, 4);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(5, 5);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(6, 4);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(6, 5);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(6, 6);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(7, 4);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(7, 5);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(7, 6);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(7, 7);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(8, 4);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(8, 5);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(8, 6);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(8, 7);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(8, 8);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(9, 4);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(9, 5);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(9, 6);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(9, 7);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(9, 8);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(9, 9);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(10, 4);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(10, 5);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(10, 6);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(10, 7);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(10, 8);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(10, 9);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(10, 10);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(11, 4);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(11, 5);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(11, 6);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(11, 7);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(11, 8);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(11, 9);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(11, 10);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(11, 11);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(12, 4);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(13, 4);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(13, 5);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(14, 4);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(14, 5);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(14, 6);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(15, 4);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(15, 5);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(15, 6);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(15, 7);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(16, 4);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(16, 5);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(16, 6);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(16, 7);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(16, 8);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(17, 4);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(17, 5);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(17, 6);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(17, 7);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(17, 8);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(17, 9);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(18, 4);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(18, 5);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(18, 6);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(18, 7);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(18, 8);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(18, 9);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(18, 10);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(19, 4);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(19, 5);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(19, 6);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(19, 7);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(19, 8);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(19, 9);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(19, 10);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(19, 11);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(20, 4);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(21, 4);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(21, 5);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(22, 4);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(22, 5);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(22, 6);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(23, 4);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(23, 5);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(23, 6);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(23, 7);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(24, 4);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(24, 5);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(24, 6);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(24, 7);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(24, 8);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(25, 4);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(25, 5);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(25, 6);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(25, 7);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(25, 8);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(25, 9);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(26, 4);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(26, 5);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(26, 6);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(26, 7);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(26, 8);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(26, 9);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(26, 10);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(27, 4);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(27, 5);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(27, 6);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(27, 7);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(27, 8);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(27, 9);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(27, 10);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(27, 11);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(28, 4);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(29, 4);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(29, 5);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(30, 4);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(30, 5);
INSERT INTO RestaurantShift(idRestaurant, idShift) VALUES(30, 6);

INSERT INTO Menu(idRestaurant, price) VALUES (1, 9.00);
INSERT INTO Menu(idRestaurant, price) VALUES (2, 7.00);
INSERT INTO Menu(idRestaurant, price) VALUES (3, 5.00);
INSERT INTO Menu(idRestaurant, price) VALUES (4, 10.50);
INSERT INTO Menu(idRestaurant, price) VALUES (5, 5.50);
INSERT INTO Menu(idRestaurant, price) VALUES (6, 5.90);
INSERT INTO Menu(idRestaurant, price) VALUES (7, 8.50);
INSERT INTO Menu(idRestaurant, price) VALUES (8, 8.00);
INSERT INTO Menu(idRestaurant, price) VALUES (9, 11.50);
INSERT INTO Menu(idRestaurant, price) VALUES (10, 16.00);
INSERT INTO Menu(idRestaurant, price) VALUES (11, 9.50);
INSERT INTO Menu(idRestaurant, price) VALUES (12, 9.50);
INSERT INTO Menu(idRestaurant, price) VALUES (13, 19.50);
INSERT INTO Menu(idRestaurant, price) VALUES (14, 18.00);
INSERT INTO Menu(idRestaurant, price) VALUES (15, 3.70);
INSERT INTO Menu(idRestaurant, price) VALUES (16, 7.50);
INSERT INTO Menu(idRestaurant, price) VALUES (17, 12.00);
INSERT INTO Menu(idRestaurant, price) VALUES (18, 13.00);
INSERT INTO Menu(idRestaurant, price) VALUES (19, 20.50);
INSERT INTO Menu(idRestaurant, price) VALUES (20, 27.70);
INSERT INTO Menu(idRestaurant, price) VALUES (21, 27.00);
INSERT INTO Menu(idRestaurant, price) VALUES (22, 21.00);
INSERT INTO Menu(idRestaurant, price) VALUES (23, 9.10);
INSERT INTO Menu(idRestaurant, price) VALUES (24, 9.10);
INSERT INTO Menu(idRestaurant, price) VALUES (25, 8.00);
INSERT INTO Menu(idRestaurant, price) VALUES (26, 8.00);
INSERT INTO Menu(idRestaurant, price) VALUES (27, 12.00);
INSERT INTO Menu(idRestaurant, price) VALUES (28, 10.90);
INSERT INTO Menu(idRestaurant, price) VALUES (29, 10.60);
INSERT INTO Menu(idRestaurant, price) VALUES (30, 13.50);

INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(1, 'Ovos Benedict', 'Tosta de pão de sementes, cogumelos, espinafres, ovos escalfados, molho holandês e cebolinho', 7.00, 1);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(2, 'Panqueca de nutella', 'Morangos e banana', 6.00, 1);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(3, 'Brownie bowl', 'Chocolate negro, brownie, banana e chocolate quente', 5.00, 1);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(4, 'Smoothie de fruta', 'Pitaia, banana e morango', 4.50, 1);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(5, 'Sumo de laranja', null, 3.00, 1);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(6, 'Sumo de pitaia e frutos vermelhos', null, 3.25, 1);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(7, 'Açaí bowl', 'Açaí, banana, morangos, granola caseira e mel', 8.50, 2);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(8, 'Panquecas Nova Iorque', 'Farinha de centeio, doce de leite, amêndoas caramelizadas e lascas de côco', 6.50, 2);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(9, 'Bagel de salmão', 'Salmão fumado, ovos mexidos, mix de folhas verdes, guacamole, cebolinho e hummus', 9.00, 2);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(10, 'Café expresso', null, 1.00, 2);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(11, 'Mocha latte', null, 2.80, 2);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(12, 'Limonada', null, 2.65, 2);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(13, 'Pumpkin spice latte', null, 3.50, 3);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(14, 'Toffee nut latte', null, 3.50, 3); 
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(15, 'Pinkity drinkity', null, 3.50, 3);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(16, 'Cake pop', null, 2.50, 3);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(17, 'Muffin de mirtilo', null, 3.20, 3);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(18, 'Pumpkin bread', null, 2.90, 3);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(19, 'Hamburguer Tripeiro', 'Carne de novilho, queijo flamengo, linguiça, salsicha, bacon, fiambre, ovo estrelado e molho de francesinha', 8.10, 4);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(20, 'Hamburguer É Só Bitaites', 'Carne de novilho, bacon, queijo flamengo, cogumelos salteados, alface, tomate, cebola roxa e molho cocktail', 7.50, 4);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(21, 'Hamburguer Come e Cala', 'Hamburguer de feijão preto, cogumelos, azeitonas e uvas passas, rúcula, cebola roxa e molho guacamole', 6.95, 4);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(22, 'Crepe de nutella', null, 3.30, 4);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(23, 'Iced Tea', null, 1.20, 4);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(24, 'Limonada', null, 1.30, 4);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(25, 'Tosta veggie', 'Pasta de abacate, mozarela fresca, tomate, malagueta seca e ovo escalfado', 9.00, 5);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(26, 'A Salada', 'Tzatziki, ovo escalfado, molho pesto, abacate, nozes, tomato masala, batata doce assada, salada e salmão', 13.00, 5);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(27, 'ChickenAvo Burger', 'Frango, abacate, queijo cheddar, rúcula, tomate, cebola em conserva e molho tzatziki', 9.50, 5);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(28, 'Matcha Latte', 'Matcha, leite, agave e canela', 4.00, 5);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(29, 'Matcha Limonada', 'Sumo de limão, agave e matcha', 4.00, 5);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(30, 'Limonada', 'Sumo de limão, gengibre, hortelã e agave', 3.50, 5);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(31, 'Hot dog', 'Salsicha de tofu, alface, tomate, cenoura, cebola, maionese, mostarda e ketchup', 6.90, 6);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(32, 'Hamburguer No Beef', 'Burger de seitan, alface, rúcula, tomate, cogumelos salteados, cebola maionese e ketchup', 6.90, 6);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(33, 'Hamburguer No Fish', 'Burguer estilo filete "peixe" panado, alface, tomate, cebola, salsa e maionese', 8.50, 6);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(34, 'Cerveja artesanal Eye of the Lagger', null, 3.60, 6);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(35, 'Cerveja artesanal Red Zeppelin', null, 3.60, 6);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(36, 'Cerveja artesanal Twist and Stout', null, 3.60, 6);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(37, 'Dumplings, fivespice e xo', null, 15.00, 7);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(38, 'Ervilhas algas e raiz forte', null, 12.00, 7);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(39, 'Tosta de cebola, "queijo" e trufa', null, 14.00, 7);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(40, 'Pastinaca, feno e caramelo salgado', null, 9.00, 7);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(41, 'Ananás dos açores e eucalipto', null, 7.50, 7);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(42, 'Chocolate, avelã e café', null, 10.00, 7);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(43, 'Pão de fermentação lenta', null, 1.50, 8);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(44, 'Papas de arroz integral', 'Leite de amêndoa, cardamomo, baunilha, manteiga de amêndoa, amêndoa tostada e compota', 6.50, 8);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(45, 'Tosta salgada', 'Húmus, legumes, trigo sarraceno tostado e molho zaatar', 8.50, 8);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(46, 'Flat white', null, 2.70, 8);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(47, 'Tosta doce', 'Manteiga de amêndoa, fruta fresca e geleia de hortelã', 5.50, 8);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(48, 'Malga de arroz', 'Arroz salteado, kimchi, cogumelos, ervas frescas e frutos secos', 12.00, 8);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(49, 'Banana bread', 'Iogurte de côco, compota de maçã, tâmaras medjool, nozes pecâns e matcha', 7.00, 9);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(50, 'Shakshuka Nola Style', 'Ovo escalfado em estufado de tomate, beringela, especiarias, hummus e flatbread de fermentação natural', 12.00, 9);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(51, 'Protein bowl', 'Hummus, espinafre, kale, abóbora hokkaido, raiz de aipo assada, tupinambo pickelado, noz pecan e romã', 12.00, 9);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(52, 'The superhero shot', 'Abacaxi, gengibre, limão, mistura de pimentas, mel, cúrcuma e pólen de abelha', 3.00, 9);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(53, 'Choco(licious, 9); pancake', 'NOLA-tella, manteiga de Avelã, gra-NOLA e maple syrup', 8.00, 9);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(54, 'Smoothie Peanut&Berries', 'Frutos vermelhos, banana, manteiga de amendoim, sementes de cânhamo e pólen de abelha', 6.00, 9);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(55, 'Sashimi Toro', 'Fatias de barrigade atum', 19.95, 10);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(56, 'Temaki Espadarte', 'Com guacamole', 6.80, 10);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(57, 'Menu Benshi L', 'Peças de fusão e sashimi', 21.90, 10);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(58, 'Menu Benshi XL', 'Peças de fusão e sashimi', 31.95, 10);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(59, 'Salada Wakame', 'Algas e sésamo', 5.90, 10);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(60, 'Tártaro de atum', 'Guacamole, cebola roxa, wasabi, cebolinho, gema de ovo, tobico e atum rabilho', 12.00, 10);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(61, 'Sushi 1', null, 21.80, 11);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(62, 'Sushi 2', null, 13.50, 11);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(63, 'Sushi 3', null, 21.80, 11);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(64, 'Dumplings', null, 9.70, 11);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(65, 'Sangria', null, 6.50, 11);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(66, 'Tarte de lima', null, 7.20, 11);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(67, 'Ramen Shoyu Veggie', 'Noodles, caldo de cogumelos com soja, tofu, meio ovo, ceboleto, pakchoi, milho e nori', 7.50, 12);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(68, 'Ramen Shoyu Porco', 'Noodles, caldo de frango com soja, meio ovo, ceboleto, pakchoi e nori', 7.50, 12);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(69, 'Ramen Miso Gambas', 'Noodles, caldo de cogumelos com miso, gambas, meio ovo, naruto, ceboleto, manteiga de alho, pakchoi e milho', 9.00, 12);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(70, 'Pana Cotta de matcha', null, 2.50, 12);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(71, 'Pana Cotta de sésamo preto', null, 2.50, 12);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(72, 'Bobba RoHai de lichia', null, 2.50, 12);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(73, '2 Crunchy Taco Supreme', 'Carne picada, alface, queijo cheddar, nata cremosa e tomate', 6.00, 13);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(74, 'Quesarito', 'Carne picada, arroz, molho habanero, nata cremosa, tortilha quente e queijo derretido', 5.50, 13);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(75, 'Quesadilla', 'Carne picada, molho Jalapeño e o dobro do queijo', 5.20, 13);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(76, 'Crunchy Wrap Supreme', 'Molho nacho, nata cremosa, alface, tomate e tortilha crocante', 5.30, 13);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(77, 'Nachos Fire', 'Nachos mexican, molho mexican, molho nacho, molho jalapeño, molho brava e jalapeños', 3.70, 13);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(78, 'Kit Kat Chocadilla', 'Chocolate de leite derretido, kit kat', 3.20, 13);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(79, 'Elotes com manteiga de alho', null, 4.70, 14);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(80, 'Quesadillas Tinga Chipotle', null, 8.90, 14);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(81, 'Margarita de maracujá', null, 3.15, 14);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(82, 'Taco Befteka', null, 7.40, 14);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(83, 'Pico de gallo', null, 4.30, 14);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(84, 'Margarita Clássica', null, 5.00, 14);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(85, 'Taco de fajitas de picanha', null, 8.50, 15);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(86, 'Quesadilla de camarão', null, 9.00, 15);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(87, 'Huevos divorciados', null, 7.50, 15);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(88, 'Churros com chocolate', null, 4.00, 15);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(89, 'Bobó de camarão', null, 8.50, 15);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(90, 'Margarita de morango', null, 6.00, 15);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(91, 'Samosa de frango', null, 4.50, 16);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(92, 'Pão naan', null, 3.00, 16);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(93, 'Chamuças', null, 6.00, 16);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(94, 'Caril de frango', null, 14.00, 16);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(95, 'Frango tikka masala', null, 14.00, 16);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(96, 'Mousse de manga', null, 4.00, 16);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(97, 'Caril de abóbora', null, 6.50, 17);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(98, 'Caril de queijo paneer e pimentos', null, 7.00, 17);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(99, 'Biryani de frango', null, 9.00, 17);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(100, 'Cerveja indiana Kingfisher', null, 3.00, 17);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(101, 'Kulfi de pistachio', null, 3.00, 17);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(102, 'Cocktail Babaji ki Bootea', null, 6.00, 17);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(103, 'Menu frango', null, 6.90, 18);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(104, 'Menu camarão', null, 8.90, 18);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(105, 'Menu borrego', null, 7.90, 18);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(106, 'Chá frio', null, 1.00, 18);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(107, 'Lassi', null, 3.00, 18);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(108, 'Sangria', null, 3.00, 18);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(109, 'Calzone', 'Tomate San Marzano DOP, mozzarella fior de latte, salame picante, fiambre, ovo', 13.00, 19);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(110, 'Focaccia Genovese', 'Língua afiambrada, mostarda de ovas curadas, tomate semi seco, rúcula', 8.00, 19);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(111, 'Pizza Prosciutto funghi', 'Tomate San Marzano DOP, mozzarella fior de latte, cogumelos paris, presunto', 14.00, 19);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(112, 'Sangria de frutos vermelhos', null, 6.50, 19);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(113, 'Cocktail', null, 5.00, 19);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(114, 'Vinho branco', null, 6.00, 19);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(115, 'Linguine al nero di seppia e gamberi', null, 12.50, 20);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(116, 'Pizza Diavola', 'Tomate, mozzarella salame picante', 13.00, 20);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(117, 'Carpaccio di carne', null, 16.00, 20);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(118, 'Cheesecake de Framboesa', null, 5.00, 20);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(119, 'Cocktail de laranja', null, 7.00, 20);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(120, 'Vinho tinto', null, 4.00, 20);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(121, 'Cone 1 bola', null, 2.20, 21);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(122, 'Cone 2 bolas', null, 3.90, 21);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(123, 'Copo 1 bola', null, 2.40, 21);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(124, 'Copo 2 bolas', null, 4.10, 21);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(125, 'Caixa 10l', null, 17.00, 21);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(126, 'Caixa 15l', null, 20.00, 21);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(127, 'Francesinha', null, 8.50, 22);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(128, 'Pataniscas de bacalhau com arroz de feijão', null, 8.65, 22);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(129, 'Filetes de pescada com salada russa', null, 9.90, 22);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(130, 'Tripas à moda do Porto', null, 10.00, 22);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(131, 'Toucinho do céu', null, 4.15, 22);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(132, 'Cerveja', null, 2.00, 22);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(133, 'Francesinha', null, 10.00, 23);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(134, 'Robalos na brasa', null, 11.00, 23);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(135, 'Prego no prato', null, 9.50, 23);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(136, 'Bacalhau com broa', null, 13.00, 23);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(137, 'Feijoada', null, 12.00, 23);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(138, 'Polvo à lagareiro', null, 15.00, 23);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(139, 'Picanha Cheese', null, 14.00, 24);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(140, 'Francesinha', null, 11.00, 24);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(141, 'Cachorro especial', null, 9.50, 24);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(142, 'Cerveja da Londrina', null, 3.00, 24);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(143, 'Folhado de alheira', null, 7.20, 24);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(144, 'Mojito', null, 4.50, 24);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(145, 'Amêndoas caramelizadas com especiarias', 'Amêndoas, erithritol, canela, gengibre, cardamomo, noz moscada e cravinho', 7.90, 25);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(146, 'Amêndoas de chocolate e côco', 'Amêndoas, chocolate negro sem açúcar e coco', 7.90, 25);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(147, 'Cookie crunch', 'Chocolate 52% cacau sem açúcar (maltitol);,  farinha de amêndoas, farinha de grão-de-bico, erithritol, farinha de linhaça, óleo de coco, bicarbonato de sódio', 8.90, 25);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(148, '4 Ovos de Páscoa', null, 35.00, 25);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(149, 'Brownies', 'Tâmaras, farinha de aveia, cacau, banana', 10.90, 25);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(150, 'Cookie cake', null, 11.00, 25);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(151, 'Gelado em cone', null, 2.90, 26);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(152, 'Waffle com toppings', null, 6.00, 26);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(153, 'Chocolate quente', null, 3.50, 26);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(154, 'Crepe com topping', null, 5.40, 26);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(155, 'Affogato', null, 3.90, 26);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(156, 'Milkshake', null, 4.70, 26);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(157, 'Pastel de nata', null, 0.90, 27);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(158, 'Regueifa', null, 1.20, 27);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(159, 'Eclair', null, 0.95, 27);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(160, 'Croissant simples', null, 1.00, 27);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(161, 'Café expresso', null, 1.00, 27);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(162, 'Meia de leite', null, 0.70, 27);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(163, 'Biscoitos', null, 5.90, 28);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(164, 'Croissant', null, 1.00, 28);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(165, 'Pão rústico', null, 1.30, 28);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(166, 'Café com leite', null, 1.20, 28);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(167, 'Fatia de bolo de gengibre', null, 1.50, 28);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(168, 'Fatia de bolo com cobertura de chocolate', null, 1.60, 28);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(169, 'Mojito', null, 4.50, 29);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(170, 'Red Sparkling Passion', null, 4.20, 29);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(171, 'Yellow Submarine', null, 6.00, 29);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(172, 'Heineken', null, 3.00, 29);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(173, 'El Capitan', null, 4.90, 29);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(174, 'Martini Fiero', null, 5.90, 29);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(175, 'Margarita', null, 4.00, 30);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(176, 'Espresso Martini', null, 6.00, 30);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(177, 'Kamikaze', null, 4.50, 30);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(178, 'Cosmopolitan', null, 4.00, 30);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(179, 'Moscow Mule', null, 4.00, 30);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(180, 'Mimosa', null, 3.90, 30);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(181, 'Cocktail Milano', null, 4.00, 31);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(182, 'Somersby', null, 3.50, 31);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(183, 'Pinapple Express', null, 5.00, 31);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(184, 'Cuban Hot Chocolate', null, 5.00, 31);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(185, 'SweetTorino', null, 6.50, 31);
INSERT INTO Dish(idDish, name, ingredients, price, idRestaurant) VALUES(186, 'Martini Brut', null, 7.00, 31);

INSERT INTO Photo(file, idDish) VALUES('dish1.jpg', 1);
INSERT INTO Photo(file, idDish) VALUES('dish2.jpg', 2);
INSERT INTO Photo(file, idDish) VALUES('dish3.jpg', 3);
INSERT INTO Photo(file, idDish) VALUES('dish4.jpg', 4);
INSERT INTO Photo(file, idDish) VALUES('dish5.jpg', 5);
INSERT INTO Photo(file, idDish) VALUES('dish6.jpg', 6);
INSERT INTO Photo(file, idDish) VALUES('dish7.jpg', 7);
INSERT INTO Photo(file, idDish) VALUES('dish8.jpg', 8);
INSERT INTO Photo(file, idDish) VALUES('dish9.jpg', 9);
INSERT INTO Photo(file, idDish) VALUES('dish10.jpg', 10);
INSERT INTO Photo(file, idDish) VALUES('dish11.jpg', 11);
INSERT INTO Photo(file, idDish) VALUES('dish12.jpg', 12);
INSERT INTO Photo(file, idDish) VALUES('dish13.jpg', 13);
INSERT INTO Photo(file, idDish) VALUES('dish14.jpg', 14);
INSERT INTO Photo(file, idDish) VALUES('dish15.jpg', 15);
INSERT INTO Photo(file, idDish) VALUES('dish16.jpg', 16);
INSERT INTO Photo(file, idDish) VALUES('dish17.jpg', 17);
INSERT INTO Photo(file, idDish) VALUES('dish18.jpg', 18);
INSERT INTO Photo(file, idDish) VALUES('dish19.jpg', 19);
INSERT INTO Photo(file, idDish) VALUES('dish20.jpg', 20);
INSERT INTO Photo(file, idDish) VALUES('dish21.jpg', 21);
INSERT INTO Photo(file, idDish) VALUES('dish22.jpg', 22);
INSERT INTO Photo(file, idDish) VALUES('dish23.jpg', 23);
INSERT INTO Photo(file, idDish) VALUES('dish24.jpg', 24);
INSERT INTO Photo(file, idDish) VALUES('dish25.jpg', 25);
INSERT INTO Photo(file, idDish) VALUES('dish26.jpg', 26);
INSERT INTO Photo(file, idDish) VALUES('dish27.jpg', 27);
INSERT INTO Photo(file, idDish) VALUES('dish28.jpg', 28);
INSERT INTO Photo(file, idDish) VALUES('dish29.jpg', 29);
INSERT INTO Photo(file, idDish) VALUES('dish30.jpg', 30);
INSERT INTO Photo(file, idDish) VALUES('dish31.jpg', 31);
INSERT INTO Photo(file, idDish) VALUES('dish32.jpg', 32);
INSERT INTO Photo(file, idDish) VALUES('dish33.jpg', 33);
INSERT INTO Photo(file, idDish) VALUES('dish34.jpg', 34);
INSERT INTO Photo(file, idDish) VALUES('dish35.jpg', 35);
INSERT INTO Photo(file, idDish) VALUES('dish36.jpg', 36);
INSERT INTO Photo(file, idDish) VALUES('dish37.jpg', 37);
INSERT INTO Photo(file, idDish) VALUES('dish38.jpg', 38);
INSERT INTO Photo(file, idDish) VALUES('dish39.jpg', 39);
INSERT INTO Photo(file, idDish) VALUES('dish40.jpg', 40);
INSERT INTO Photo(file, idDish) VALUES('dish41.jpg', 41);
INSERT INTO Photo(file, idDish) VALUES('dish42.jpg', 42);
INSERT INTO Photo(file, idDish) VALUES('dish43.jpg', 43);
INSERT INTO Photo(file, idDish) VALUES('dish44.jpg', 44);
INSERT INTO Photo(file, idDish) VALUES('dish45.jpg', 45);
INSERT INTO Photo(file, idDish) VALUES('dish46.jpg', 46);
INSERT INTO Photo(file, idDish) VALUES('dish47.jpg', 47);
INSERT INTO Photo(file, idDish) VALUES('dish48.jpg', 48);
INSERT INTO Photo(file, idDish) VALUES('dish49.jpg', 49);
INSERT INTO Photo(file, idDish) VALUES('dish50.jpg', 50);
INSERT INTO Photo(file, idDish) VALUES('dish51.jpg', 51);
INSERT INTO Photo(file, idDish) VALUES('dish52.jpg', 52);
INSERT INTO Photo(file, idDish) VALUES('dish53.jpg', 53);
INSERT INTO Photo(file, idDish) VALUES('dish54.jpg', 54);
INSERT INTO Photo(file, idDish) VALUES('dish55.jpg', 55);
INSERT INTO Photo(file, idDish) VALUES('dish56.jpg', 56);
INSERT INTO Photo(file, idDish) VALUES('dish57.jpg', 57);
INSERT INTO Photo(file, idDish) VALUES('dish58.jpg', 58);
INSERT INTO Photo(file, idDish) VALUES('dish59.jpg', 59);
INSERT INTO Photo(file, idDish) VALUES('dish60.jpg', 60);
INSERT INTO Photo(file, idDish) VALUES('dish61.jpg', 61);
INSERT INTO Photo(file, idDish) VALUES('dish62.jpg', 62);
INSERT INTO Photo(file, idDish) VALUES('dish63.jpg', 63);
INSERT INTO Photo(file, idDish) VALUES('dish64.jpg', 64);
INSERT INTO Photo(file, idDish) VALUES('dish65.jpg', 65);
INSERT INTO Photo(file, idDish) VALUES('dish66.jpg', 66);
INSERT INTO Photo(file, idDish) VALUES('dish67.jpg', 67);
INSERT INTO Photo(file, idDish) VALUES('dish68.jpg', 68);
INSERT INTO Photo(file, idDish) VALUES('dish69.jpg', 69);
INSERT INTO Photo(file, idDish) VALUES('dish70.jpg', 70);
INSERT INTO Photo(file, idDish) VALUES('dish71.jpg', 71);
INSERT INTO Photo(file, idDish) VALUES('dish72.jpg', 72);
INSERT INTO Photo(file, idDish) VALUES('dish73.jpg', 73);
INSERT INTO Photo(file, idDish) VALUES('dish74.jpg', 74);
INSERT INTO Photo(file, idDish) VALUES('dish75.jpg', 75);
INSERT INTO Photo(file, idDish) VALUES('dish76.jpg', 76);
INSERT INTO Photo(file, idDish) VALUES('dish77.jpg', 77);
INSERT INTO Photo(file, idDish) VALUES('dish78.jpg', 78);
INSERT INTO Photo(file, idDish) VALUES('dish79.jpg', 79);
INSERT INTO Photo(file, idDish) VALUES('dish80.jpg', 80);
INSERT INTO Photo(file, idDish) VALUES('dish81.jpg', 81);
INSERT INTO Photo(file, idDish) VALUES('dish82.jpg', 82);
INSERT INTO Photo(file, idDish) VALUES('dish83.jpg', 83);
INSERT INTO Photo(file, idDish) VALUES('dish84.jpg', 84);
INSERT INTO Photo(file, idDish) VALUES('dish85.jpg', 85);
INSERT INTO Photo(file, idDish) VALUES('dish86.jpg', 86);
INSERT INTO Photo(file, idDish) VALUES('dish87.jpg', 87);
INSERT INTO Photo(file, idDish) VALUES('dish88.jpg', 88);
INSERT INTO Photo(file, idDish) VALUES('dish89.jpg', 89);
INSERT INTO Photo(file, idDish) VALUES('dish90.jpg', 90);
INSERT INTO Photo(file, idDish) VALUES('dish91.jpg', 91);
INSERT INTO Photo(file, idDish) VALUES('dish92.jpg', 92);
INSERT INTO Photo(file, idDish) VALUES('dish93.jpg', 93);
INSERT INTO Photo(file, idDish) VALUES('dish94.jpg', 94);
INSERT INTO Photo(file, idDish) VALUES('dish95.jpg', 95);
INSERT INTO Photo(file, idDish) VALUES('dish96.jpg', 96);
INSERT INTO Photo(file, idDish) VALUES('dish97.jpg', 97);
INSERT INTO Photo(file, idDish) VALUES('dish98.jpg', 98);
INSERT INTO Photo(file, idDish) VALUES('dish99.jpg', 99);
INSERT INTO Photo(file, idDish) VALUES('dish100.jpg', 100);
INSERT INTO Photo(file, idDish) VALUES('dish101.jpg', 101);
INSERT INTO Photo(file, idDish) VALUES('dish102.jpg', 102);
INSERT INTO Photo(file, idDish) VALUES('dish103.jpg', 103);
INSERT INTO Photo(file, idDish) VALUES('dish104.jpg', 104);
INSERT INTO Photo(file, idDish) VALUES('dish105.jpg', 105);
INSERT INTO Photo(file, idDish) VALUES('dish106.jpg', 106);
INSERT INTO Photo(file, idDish) VALUES('dish107.jpg', 107);
INSERT INTO Photo(file, idDish) VALUES('dish108.jpg', 108);
INSERT INTO Photo(file, idDish) VALUES('dish109.jpg', 109);
INSERT INTO Photo(file, idDish) VALUES('dish110.jpg', 110);
INSERT INTO Photo(file, idDish) VALUES('dish111.jpg', 111);
INSERT INTO Photo(file, idDish) VALUES('dish112.jpg', 112);
INSERT INTO Photo(file, idDish) VALUES('dish113.jpg', 113);
INSERT INTO Photo(file, idDish) VALUES('dish114.jpg', 114);
INSERT INTO Photo(file, idDish) VALUES('dish115.jpg', 115);
INSERT INTO Photo(file, idDish) VALUES('dish116.jpg', 116);
INSERT INTO Photo(file, idDish) VALUES('dish117.jpg', 117);
INSERT INTO Photo(file, idDish) VALUES('dish118.jpg', 118);
INSERT INTO Photo(file, idDish) VALUES('dish119.jpg', 119);
INSERT INTO Photo(file, idDish) VALUES('dish120.jpg', 120);
INSERT INTO Photo(file, idDish) VALUES('dish121.jpg', 121);
INSERT INTO Photo(file, idDish) VALUES('dish122.jpg', 122);
INSERT INTO Photo(file, idDish) VALUES('dish123.jpg', 123);
INSERT INTO Photo(file, idDish) VALUES('dish124.jpg', 124);
INSERT INTO Photo(file, idDish) VALUES('dish125.jpg', 125);
INSERT INTO Photo(file, idDish) VALUES('dish126.jpg', 126);
INSERT INTO Photo(file, idDish) VALUES('dish127.jpg', 127);
INSERT INTO Photo(file, idDish) VALUES('dish128.jpg', 128);
INSERT INTO Photo(file, idDish) VALUES('dish129.jpg', 129);
INSERT INTO Photo(file, idDish) VALUES('dish130.jpg', 130);
INSERT INTO Photo(file, idDish) VALUES('dish131.jpg', 131);
INSERT INTO Photo(file, idDish) VALUES('dish132.jpg', 132);
INSERT INTO Photo(file, idDish) VALUES('dish133.jpg', 133);
INSERT INTO Photo(file, idDish) VALUES('dish134.jpg', 134);
INSERT INTO Photo(file, idDish) VALUES('dish135.jpg', 135);
INSERT INTO Photo(file, idDish) VALUES('dish136.jpg', 136);
INSERT INTO Photo(file, idDish) VALUES('dish137.jpg', 137);
INSERT INTO Photo(file, idDish) VALUES('dish138.jpg', 138);
INSERT INTO Photo(file, idDish) VALUES('dish139.jpg', 139);
INSERT INTO Photo(file, idDish) VALUES('dish140.jpg', 140);
INSERT INTO Photo(file, idDish) VALUES('dish141.jpg', 141);
INSERT INTO Photo(file, idDish) VALUES('dish142.jpg', 142);
INSERT INTO Photo(file, idDish) VALUES('dish143.jpg', 143);
INSERT INTO Photo(file, idDish) VALUES('dish144.jpg', 144);
INSERT INTO Photo(file, idDish) VALUES('dish145.jpg', 145);
INSERT INTO Photo(file, idDish) VALUES('dish146.jpg', 146);
INSERT INTO Photo(file, idDish) VALUES('dish147.jpg', 147);
INSERT INTO Photo(file, idDish) VALUES('dish148.jpg', 148);
INSERT INTO Photo(file, idDish) VALUES('dish149.jpg', 149);
INSERT INTO Photo(file, idDish) VALUES('dish150.jpg', 150);
INSERT INTO Photo(file, idDish) VALUES('dish151.jpg', 151);
INSERT INTO Photo(file, idDish) VALUES('dish152.jpg', 152);
INSERT INTO Photo(file, idDish) VALUES('dish153.jpg', 153);
INSERT INTO Photo(file, idDish) VALUES('dish154.jpg', 154);
INSERT INTO Photo(file, idDish) VALUES('dish155.jpg', 155);
INSERT INTO Photo(file, idDish) VALUES('dish156.jpg', 156);
INSERT INTO Photo(file, idDish) VALUES('dish157.jpg', 157);
INSERT INTO Photo(file, idDish) VALUES('dish158.jpg', 158);
INSERT INTO Photo(file, idDish) VALUES('dish159.jpg', 159);
INSERT INTO Photo(file, idDish) VALUES('dish160.jpg', 160);
INSERT INTO Photo(file, idDish) VALUES('dish161.jpg', 161);
INSERT INTO Photo(file, idDish) VALUES('dish162.jpg', 162);
INSERT INTO Photo(file, idDish) VALUES('dish163.jpg', 163);
INSERT INTO Photo(file, idDish) VALUES('dish164.jpg', 164);
INSERT INTO Photo(file, idDish) VALUES('dish165.jpg', 165);
INSERT INTO Photo(file, idDish) VALUES('dish166.jpg', 166);
INSERT INTO Photo(file, idDish) VALUES('dish167.jpg', 167);
INSERT INTO Photo(file, idDish) VALUES('dish168.jpg', 168);
INSERT INTO Photo(file, idDish) VALUES('dish169.jpg', 169);
INSERT INTO Photo(file, idDish) VALUES('dish170.jpg', 170);
INSERT INTO Photo(file, idDish) VALUES('dish171.jpg', 171);
INSERT INTO Photo(file, idDish) VALUES('dish172.jpg', 172);
INSERT INTO Photo(file, idDish) VALUES('dish173.jpg', 173);
INSERT INTO Photo(file, idDish) VALUES('dish174.jpg', 174);
INSERT INTO Photo(file, idDish) VALUES('dish175.jpg', 175);
INSERT INTO Photo(file, idDish) VALUES('dish176.jpg', 176);
INSERT INTO Photo(file, idDish) VALUES('dish177.jpg', 177);
INSERT INTO Photo(file, idDish) VALUES('dish178.jpg', 178);
INSERT INTO Photo(file, idDish) VALUES('dish179.jpg', 179);
INSERT INTO Photo(file, idDish) VALUES('dish180.jpg', 180);
INSERT INTO Photo(file, idDish) VALUES('dish181.jpg', 181);
INSERT INTO Photo(file, idDish) VALUES('dish182.jpg', 182);
INSERT INTO Photo(file, idDish) VALUES('dish183.jpg', 183);
INSERT INTO Photo(file, idDish) VALUES('dish184.jpg', 184);
INSERT INTO Photo(file, idDish) VALUES('dish185.jpg', 185);
INSERT INTO Photo(file, idDish) VALUES('dish186.jpg', 186);
INSERT INTO Photo(file, idRestaurant) VALUES('restaurant1.jpg', 1);
INSERT INTO Photo(file, idRestaurant) VALUES('restaurant2.jpg', 2);
INSERT INTO Photo(file, idRestaurant) VALUES('restaurant3.jpg', 3);
INSERT INTO Photo(file, idRestaurant) VALUES('restaurant4.jpg', 4);
INSERT INTO Photo(file, idRestaurant) VALUES('restaurant5.jpg', 5);
INSERT INTO Photo(file, idRestaurant) VALUES('restaurant6.jpg', 6);
INSERT INTO Photo(file, idRestaurant) VALUES('restaurant7.jpg', 7);
INSERT INTO Photo(file, idRestaurant) VALUES('restaurant8.jpg', 8);
INSERT INTO Photo(file, idRestaurant) VALUES('restaurant9.jpg', 9);
INSERT INTO Photo(file, idRestaurant) VALUES('restaurant10.jpg', 10);
INSERT INTO Photo(file, idRestaurant) VALUES('restaurant11.jpg', 11);
INSERT INTO Photo(file, idRestaurant) VALUES('restaurant12.jpg', 12);
INSERT INTO Photo(file, idRestaurant) VALUES('restaurant13.jpg', 13);
INSERT INTO Photo(file, idRestaurant) VALUES('restaurant14.jpg', 14);
INSERT INTO Photo(file, idRestaurant) VALUES('restaurant15.jpg', 15);
INSERT INTO Photo(file, idRestaurant) VALUES('restaurant16.jpg', 16);
INSERT INTO Photo(file, idRestaurant) VALUES('restaurant17.jpg', 17);
INSERT INTO Photo(file, idRestaurant) VALUES('restaurant18.jpg', 18);
INSERT INTO Photo(file, idRestaurant) VALUES('restaurant19.jpg', 19);
INSERT INTO Photo(file, idRestaurant) VALUES('restaurant20.jpg', 20);
INSERT INTO Photo(file, idRestaurant) VALUES('restaurant21.jpg', 21);
INSERT INTO Photo(file, idRestaurant) VALUES('restaurant22.jpg', 22);
INSERT INTO Photo(file, idRestaurant) VALUES('restaurant23.jpg', 23);
INSERT INTO Photo(file, idRestaurant) VALUES('restaurant24.jpg', 24);
INSERT INTO Photo(file, idRestaurant) VALUES('restaurant25.jpg', 25);
INSERT INTO Photo(file, idRestaurant) VALUES('restaurant26.jpg', 26);
INSERT INTO Photo(file, idRestaurant) VALUES('restaurant27.jpg', 27);
INSERT INTO Photo(file, idRestaurant) VALUES('restaurant28.jpg', 28);
INSERT INTO Photo(file, idRestaurant) VALUES('restaurant29.jpg', 29);
INSERT INTO Photo(file, idRestaurant) VALUES('restaurant30.jpg', 30);
INSERT INTO Photo(file, idRestaurant) VALUES('restaurant31.jpg', 31);
INSERT INTO Photo(file, username) VALUES('user1.jpg', 'saradias');
INSERT INTO Photo(file, username) VALUES('user2.jpg', 'lluislima');
INSERT INTO Photo(file, username) VALUES('user3.jpg', 'mariaa12');
INSERT INTO Photo(file, username) VALUES('user4.jpg', 'dav_soares');
INSERT INTO Photo(file, username) VALUES('user5.jpg', 'nicoleolive');

INSERT INTO MenuDish(idMenu, idDish) VALUES(1, 1);
INSERT INTO MenuDish(idMenu, idDish) VALUES(1, 5);
INSERT INTO MenuDish(idMenu, idDish) VALUES(2, 3);
INSERT INTO MenuDish(idMenu, idDish) VALUES(2, 6);
INSERT INTO MenuDish(idMenu, idDish) VALUES(3, 8);
INSERT INTO MenuDish(idMenu, idDish) VALUES(3, 10);
INSERT INTO MenuDish(idMenu, idDish) VALUES(4, 9);
INSERT INTO MenuDish(idMenu, idDish) VALUES(4, 12);
INSERT INTO MenuDish(idMenu, idDish) VALUES(5, 13);
INSERT INTO MenuDish(idMenu, idDish) VALUES(5, 18);
INSERT INTO MenuDish(idMenu, idDish) VALUES(6, 15);
INSERT INTO MenuDish(idMenu, idDish) VALUES(6, 17);
INSERT INTO MenuDish(idMenu, idDish) VALUES(7, 19);
INSERT INTO MenuDish(idMenu, idDish) VALUES(7, 23);
INSERT INTO MenuDish(idMenu, idDish) VALUES(8, 20);
INSERT INTO MenuDish(idMenu, idDish) VALUES(8, 24);
INSERT INTO MenuDish(idMenu, idDish) VALUES(9, 25);
INSERT INTO MenuDish(idMenu, idDish) VALUES(9, 30);
INSERT INTO MenuDish(idMenu, idDish) VALUES(10, 26);
INSERT INTO MenuDish(idMenu, idDish) VALUES(10, 28);
INSERT INTO MenuDish(idMenu, idDish) VALUES(11, 31);
INSERT INTO MenuDish(idMenu, idDish) VALUES(11, 35);
INSERT INTO MenuDish(idMenu, idDish) VALUES(12, 32);
INSERT INTO MenuDish(idMenu, idDish) VALUES(12, 36);
INSERT INTO MenuDish(idMenu, idDish) VALUES(13, 39);
INSERT INTO MenuDish(idMenu, idDish) VALUES(13, 41);
INSERT INTO MenuDish(idMenu, idDish) VALUES(14, 40);
INSERT INTO MenuDish(idMenu, idDish) VALUES(14, 42);
INSERT INTO MenuDish(idMenu, idDish) VALUES(15, 43);
INSERT INTO MenuDish(idMenu, idDish) VALUES(15, 46);
INSERT INTO MenuDish(idMenu, idDish) VALUES(16, 47);
INSERT INTO MenuDish(idMenu, idDish) VALUES(16, 46);
INSERT INTO MenuDish(idMenu, idDish) VALUES(17, 49);
INSERT INTO MenuDish(idMenu, idDish) VALUES(17, 54);
INSERT INTO MenuDish(idMenu, idDish) VALUES(18, 54);
INSERT INTO MenuDish(idMenu, idDish) VALUES(18, 53);
INSERT INTO MenuDish(idMenu, idDish) VALUES(19, 55);
INSERT INTO MenuDish(idMenu, idDish) VALUES(19, 59);
INSERT INTO MenuDish(idMenu, idDish) VALUES(20, 57);
INSERT INTO MenuDish(idMenu, idDish) VALUES(20, 56);
INSERT INTO MenuDish(idMenu, idDish) VALUES(21, 61);
INSERT INTO MenuDish(idMenu, idDish) VALUES(21, 65);
INSERT INTO MenuDish(idMenu, idDish) VALUES(22, 62);
INSERT INTO MenuDish(idMenu, idDish) VALUES(22, 64);
INSERT INTO MenuDish(idMenu, idDish) VALUES(23, 67);
INSERT INTO MenuDish(idMenu, idDish) VALUES(23, 70);
INSERT INTO MenuDish(idMenu, idDish) VALUES(24, 68);
INSERT INTO MenuDish(idMenu, idDish) VALUES(24, 73);
INSERT INTO MenuDish(idMenu, idDish) VALUES(25, 75);
INSERT INTO MenuDish(idMenu, idDish) VALUES(25, 78);
INSERT INTO MenuDish(idMenu, idDish) VALUES(26, 77);
INSERT INTO MenuDish(idMenu, idDish) VALUES(26, 74);
INSERT INTO MenuDish(idMenu, idDish) VALUES(27, 79);
INSERT INTO MenuDish(idMenu, idDish) VALUES(27, 80);
INSERT INTO MenuDish(idMenu, idDish) VALUES(28, 82);
INSERT INTO MenuDish(idMenu, idDish) VALUES(28, 83);
INSERT INTO MenuDish(idMenu, idDish) VALUES(29, 87);
INSERT INTO MenuDish(idMenu, idDish) VALUES(29, 88);
INSERT INTO MenuDish(idMenu, idDish) VALUES(30, 86);
INSERT INTO MenuDish(idMenu, idDish) VALUES(30, 90);

INSERT INTO Allergen (idAllergen, name) VALUES (1, 'Celery');
INSERT INTO Allergen (idAllergen, name) VALUES (2, 'Crustaceans');
INSERT INTO Allergen (idAllergen, name) VALUES (3, 'Dairy');
INSERT INTO Allergen (idAllergen, name) VALUES (4, 'Eggs');
INSERT INTO Allergen (idAllergen, name) VALUES (5, 'Fish');
INSERT INTO Allergen (idAllergen, name) VALUES (6, 'Gluten');
INSERT INTO Allergen (idAllergen, name) VALUES (7, 'Lupin');
INSERT INTO Allergen (idAllergen, name) VALUES (8, 'Molluscs');
INSERT INTO Allergen (idAllergen, name) VALUES (9, 'Mustard');
INSERT INTO Allergen (idAllergen, name) VALUES (10, 'Peanuts');
INSERT INTO Allergen (idAllergen, name) VALUES (11, 'Sesame');
INSERT INTO Allergen (idAllergen, name) VALUES (12, 'Soy');
INSERT INTO Allergen (idAllergen, name) VALUES (13, 'Sulphur dioxide and sulphites');
INSERT INTO Allergen (idAllergen, name) VALUES (14, 'Nuts');

INSERT INTO DishAllergen(idDish, idAllergen) VALUES(1, 4);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(1, 6);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(2, 4);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(2, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(2, 14);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(7, 14);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(8, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(9, 5);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(9, 4);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(11, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(13, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(14, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(14, 14);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(15, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(16, 6);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(17, 6);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(18, 6);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(19, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(19, 4);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(20, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(22, 6);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(22, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(22, 4);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(25, 6);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(25, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(25, 4);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(26, 4);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(26, 5);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(27, 4);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(27, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(28, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(31, 12);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(31, 9);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(31, 6);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(32, 6);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(33, 6);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(42, 14);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(43, 6);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(44, 14);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(45, 6);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(46, 6);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(46, 14);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(48, 14);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(49, 14);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(50, 6);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(50, 4);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(51, 14);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(51, 1);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(53, 6);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(53, 14);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(54, 10);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(55, 5);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(56, 5);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(58, 5);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(60, 5);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(61, 5);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(62, 5);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(63, 5);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(67, 12);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(67, 4);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(68, 12);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(68, 4);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(69, 12);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(69, 4);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(69, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(70, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(71, 11);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(71, 6);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(73, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(73, 6);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(74, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(74, 6);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(74, 9);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(75, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(75, 6);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(76, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(76, 6);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(77, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(78, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(78, 6);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(79, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(86, 2);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(86, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(87, 4);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(88, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(89, 2);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(89, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(91, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(92, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(93, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(95, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(96, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(98, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(99, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(101, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(104, 2);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(107, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(109, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(109, 4);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(110, 9);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(111, 3); 
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(115, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(115, 2);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(116, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(117, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(117, 9);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(118, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(121, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(122, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(123, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(124, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(125, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(126, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(127, 4);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(127, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(128, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(128, 5);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(128, 4);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(128, 7);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(129, 5);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(131, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(131, 4);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(131, 14);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(133, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(133, 4);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(136, 5);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(138, 8);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(139, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(140, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(140, 4);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(141, 9);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(143, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(143, 4);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(145, 14);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(146, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(146, 14);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(147, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(147, 14);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(148, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(149, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(149, 14);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(150, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(151, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(152, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(153, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(154, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(156, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(157, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(157, 4);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(158, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(158, 4);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(159, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(159, 4);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(160, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(160, 4);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(162, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(163, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(163, 4);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(164, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(164, 4);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(166, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(167, 4);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(168, 3);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(168, 4);
INSERT INTO DishAllergen(idDish, idAllergen) VALUES(184, 3);

INSERT INTO DishCategory(idDish, idCategory) VALUES(1, 1);
INSERT INTO DishCategory(idDish, idCategory) VALUES(2, 1);
INSERT INTO DishCategory(idDish, idCategory) VALUES(3, 1);
INSERT INTO DishCategory(idDish, idCategory) VALUES(4, 1);
INSERT INTO DishCategory(idDish, idCategory) VALUES(5, 1);
INSERT INTO DishCategory(idDish, idCategory) VALUES(6, 1);

INSERT INTO DishCategory(idDish, idCategory) VALUES(7, 1);
INSERT INTO DishCategory(idDish, idCategory) VALUES(8, 1);
INSERT INTO DishCategory(idDish, idCategory) VALUES(9, 1);
INSERT INTO DishCategory(idDish, idCategory) VALUES(10, 1);
INSERT INTO DishCategory(idDish, idCategory) VALUES(11, 1);
INSERT INTO DishCategory(idDish, idCategory) VALUES(12, 1);

INSERT INTO DishCategory(idDish, idCategory) VALUES(13, 1);
INSERT INTO DishCategory(idDish, idCategory) VALUES(14, 1);
INSERT INTO DishCategory(idDish, idCategory) VALUES(15, 1);
INSERT INTO DishCategory(idDish, idCategory) VALUES(16, 1);
INSERT INTO DishCategory(idDish, idCategory) VALUES(17, 1);
INSERT INTO DishCategory(idDish, idCategory) VALUES(18, 1);
INSERT INTO DishCategory(idDish, idCategory) VALUES(13, 12);
INSERT INTO DishCategory(idDish, idCategory) VALUES(14, 12);
INSERT INTO DishCategory(idDish, idCategory) VALUES(15, 12);
INSERT INTO DishCategory(idDish, idCategory) VALUES(16, 12);
INSERT INTO DishCategory(idDish, idCategory) VALUES(17, 12);
INSERT INTO DishCategory(idDish, idCategory) VALUES(18, 12);

INSERT INTO DishCategory(idDish, idCategory) VALUES(19, 2);
INSERT INTO DishCategory(idDish, idCategory) VALUES(20, 2);
INSERT INTO DishCategory(idDish, idCategory) VALUES(21, 2);
INSERT INTO DishCategory(idDish, idCategory) VALUES(22, 2);
INSERT INTO DishCategory(idDish, idCategory) VALUES(23, 2);
INSERT INTO DishCategory(idDish, idCategory) VALUES(24, 2);
INSERT INTO DishCategory(idDish, idCategory) VALUES(19, 9);
INSERT INTO DishCategory(idDish, idCategory) VALUES(20, 9);
INSERT INTO DishCategory(idDish, idCategory) VALUES(21, 9);
INSERT INTO DishCategory(idDish, idCategory) VALUES(22, 9);
INSERT INTO DishCategory(idDish, idCategory) VALUES(23, 9);
INSERT INTO DishCategory(idDish, idCategory) VALUES(24, 9);

INSERT INTO DishCategory(idDish, idCategory) VALUES(25, 2);
INSERT INTO DishCategory(idDish, idCategory) VALUES(26, 2);
INSERT INTO DishCategory(idDish, idCategory) VALUES(27, 2);
INSERT INTO DishCategory(idDish, idCategory) VALUES(28, 2);
INSERT INTO DishCategory(idDish, idCategory) VALUES(29, 2);
INSERT INTO DishCategory(idDish, idCategory) VALUES(30, 2);
INSERT INTO DishCategory(idDish, idCategory) VALUES(25, 10);
INSERT INTO DishCategory(idDish, idCategory) VALUES(26, 10);
INSERT INTO DishCategory(idDish, idCategory) VALUES(27, 10);
INSERT INTO DishCategory(idDish, idCategory) VALUES(28, 10);
INSERT INTO DishCategory(idDish, idCategory) VALUES(29, 10);
INSERT INTO DishCategory(idDish, idCategory) VALUES(30, 10);

INSERT INTO DishCategory(idDish, idCategory) VALUES(31, 2);
INSERT INTO DishCategory(idDish, idCategory) VALUES(32, 2);
INSERT INTO DishCategory(idDish, idCategory) VALUES(33, 2);
INSERT INTO DishCategory(idDish, idCategory) VALUES(34, 2);
INSERT INTO DishCategory(idDish, idCategory) VALUES(35, 2);
INSERT INTO DishCategory(idDish, idCategory) VALUES(36, 2);
INSERT INTO DishCategory(idDish, idCategory) VALUES(31, 9);
INSERT INTO DishCategory(idDish, idCategory) VALUES(32, 9);
INSERT INTO DishCategory(idDish, idCategory) VALUES(33, 9);
INSERT INTO DishCategory(idDish, idCategory) VALUES(34, 9);
INSERT INTO DishCategory(idDish, idCategory) VALUES(35, 9);
INSERT INTO DishCategory(idDish, idCategory) VALUES(36, 9);

INSERT INTO DishCategory(idDish, idCategory) VALUES(37, 3);
INSERT INTO DishCategory(idDish, idCategory) VALUES(38, 3);
INSERT INTO DishCategory(idDish, idCategory) VALUES(39, 3);
INSERT INTO DishCategory(idDish, idCategory) VALUES(40, 3);
INSERT INTO DishCategory(idDish, idCategory) VALUES(41, 3);
INSERT INTO DishCategory(idDish, idCategory) VALUES(42, 3);
INSERT INTO DishCategory(idDish, idCategory) VALUES(37, 10);
INSERT INTO DishCategory(idDish, idCategory) VALUES(38, 10);
INSERT INTO DishCategory(idDish, idCategory) VALUES(39, 10);
INSERT INTO DishCategory(idDish, idCategory) VALUES(40, 10);
INSERT INTO DishCategory(idDish, idCategory) VALUES(41, 10);
INSERT INTO DishCategory(idDish, idCategory) VALUES(42, 10);

INSERT INTO DishCategory(idDish, idCategory) VALUES(43, 3);
INSERT INTO DishCategory(idDish, idCategory) VALUES(44, 3);
INSERT INTO DishCategory(idDish, idCategory) VALUES(45, 3);
INSERT INTO DishCategory(idDish, idCategory) VALUES(46, 3);
INSERT INTO DishCategory(idDish, idCategory) VALUES(47, 3);
INSERT INTO DishCategory(idDish, idCategory) VALUES(48, 3);

INSERT INTO DishCategory(idDish, idCategory) VALUES(49, 3);
INSERT INTO DishCategory(idDish, idCategory) VALUES(50, 3);
INSERT INTO DishCategory(idDish, idCategory) VALUES(51, 3);
INSERT INTO DishCategory(idDish, idCategory) VALUES(52, 3);
INSERT INTO DishCategory(idDish, idCategory) VALUES(53, 3);
INSERT INTO DishCategory(idDish, idCategory) VALUES(54, 3);

INSERT INTO DishCategory(idDish, idCategory) VALUES(55, 4);
INSERT INTO DishCategory(idDish, idCategory) VALUES(56, 4);
INSERT INTO DishCategory(idDish, idCategory) VALUES(57, 4);
INSERT INTO DishCategory(idDish, idCategory) VALUES(58, 4);
INSERT INTO DishCategory(idDish, idCategory) VALUES(59, 4);
INSERT INTO DishCategory(idDish, idCategory) VALUES(60, 4);

INSERT INTO DishCategory(idDish, idCategory) VALUES(61, 4);
INSERT INTO DishCategory(idDish, idCategory) VALUES(62, 4);
INSERT INTO DishCategory(idDish, idCategory) VALUES(63, 4);
INSERT INTO DishCategory(idDish, idCategory) VALUES(64, 4);
INSERT INTO DishCategory(idDish, idCategory) VALUES(65, 4);
INSERT INTO DishCategory(idDish, idCategory) VALUES(66, 4);

INSERT INTO DishCategory(idDish, idCategory) VALUES(67, 4);
INSERT INTO DishCategory(idDish, idCategory) VALUES(68, 4);
INSERT INTO DishCategory(idDish, idCategory) VALUES(69, 4);
INSERT INTO DishCategory(idDish, idCategory) VALUES(70, 4);
INSERT INTO DishCategory(idDish, idCategory) VALUES(71, 4);
INSERT INTO DishCategory(idDish, idCategory) VALUES(72, 4);

INSERT INTO DishCategory(idDish, idCategory) VALUES(73, 5);
INSERT INTO DishCategory(idDish, idCategory) VALUES(74, 5);
INSERT INTO DishCategory(idDish, idCategory) VALUES(75, 5);
INSERT INTO DishCategory(idDish, idCategory) VALUES(76, 5);
INSERT INTO DishCategory(idDish, idCategory) VALUES(77, 5);
INSERT INTO DishCategory(idDish, idCategory) VALUES(78, 5);
INSERT INTO DishCategory(idDish, idCategory) VALUES(73, 9);
INSERT INTO DishCategory(idDish, idCategory) VALUES(74, 9);
INSERT INTO DishCategory(idDish, idCategory) VALUES(75, 9);
INSERT INTO DishCategory(idDish, idCategory) VALUES(76, 9);
INSERT INTO DishCategory(idDish, idCategory) VALUES(77, 9);
INSERT INTO DishCategory(idDish, idCategory) VALUES(78, 9);

INSERT INTO DishCategory(idDish, idCategory) VALUES(79, 5);
INSERT INTO DishCategory(idDish, idCategory) VALUES(80, 5);
INSERT INTO DishCategory(idDish, idCategory) VALUES(81, 5);
INSERT INTO DishCategory(idDish, idCategory) VALUES(82, 5);
INSERT INTO DishCategory(idDish, idCategory) VALUES(83, 5);
INSERT INTO DishCategory(idDish, idCategory) VALUES(84, 5);

INSERT INTO DishCategory(idDish, idCategory) VALUES(85, 5);
INSERT INTO DishCategory(idDish, idCategory) VALUES(86, 5);
INSERT INTO DishCategory(idDish, idCategory) VALUES(87, 5);
INSERT INTO DishCategory(idDish, idCategory) VALUES(88, 5);
INSERT INTO DishCategory(idDish, idCategory) VALUES(89, 5);
INSERT INTO DishCategory(idDish, idCategory) VALUES(90, 5);

INSERT INTO DishCategory(idDish, idCategory) VALUES(91, 6);
INSERT INTO DishCategory(idDish, idCategory) VALUES(92, 6);
INSERT INTO DishCategory(idDish, idCategory) VALUES(93, 6);
INSERT INTO DishCategory(idDish, idCategory) VALUES(94, 6);
INSERT INTO DishCategory(idDish, idCategory) VALUES(95, 6);
INSERT INTO DishCategory(idDish, idCategory) VALUES(96, 6);

INSERT INTO DishCategory(idDish, idCategory) VALUES(97, 6);
INSERT INTO DishCategory(idDish, idCategory) VALUES(98, 6);
INSERT INTO DishCategory(idDish, idCategory) VALUES(99, 6);
INSERT INTO DishCategory(idDish, idCategory) VALUES(100, 6);
INSERT INTO DishCategory(idDish, idCategory) VALUES(101, 6);
INSERT INTO DishCategory(idDish, idCategory) VALUES(102, 6);

INSERT INTO DishCategory(idDish, idCategory) VALUES(103, 6);
INSERT INTO DishCategory(idDish, idCategory) VALUES(104, 6);
INSERT INTO DishCategory(idDish, idCategory) VALUES(105, 6);
INSERT INTO DishCategory(idDish, idCategory) VALUES(106, 6);
INSERT INTO DishCategory(idDish, idCategory) VALUES(107, 6);
INSERT INTO DishCategory(idDish, idCategory) VALUES(108, 6);

INSERT INTO DishCategory(idDish, idCategory) VALUES(109, 7);
INSERT INTO DishCategory(idDish, idCategory) VALUES(110, 7);
INSERT INTO DishCategory(idDish, idCategory) VALUES(111, 7);
INSERT INTO DishCategory(idDish, idCategory) VALUES(112, 7);
INSERT INTO DishCategory(idDish, idCategory) VALUES(113, 7);
INSERT INTO DishCategory(idDish, idCategory) VALUES(114, 7);

INSERT INTO DishCategory(idDish, idCategory) VALUES(115, 7);
INSERT INTO DishCategory(idDish, idCategory) VALUES(116, 7);
INSERT INTO DishCategory(idDish, idCategory) VALUES(117, 7);
INSERT INTO DishCategory(idDish, idCategory) VALUES(118, 7);
INSERT INTO DishCategory(idDish, idCategory) VALUES(119, 7);
INSERT INTO DishCategory(idDish, idCategory) VALUES(120, 7);

INSERT INTO DishCategory(idDish, idCategory) VALUES(121, 7);
INSERT INTO DishCategory(idDish, idCategory) VALUES(122, 7);
INSERT INTO DishCategory(idDish, idCategory) VALUES(123, 7);
INSERT INTO DishCategory(idDish, idCategory) VALUES(124, 7);
INSERT INTO DishCategory(idDish, idCategory) VALUES(125, 7);
INSERT INTO DishCategory(idDish, idCategory) VALUES(126, 7);
INSERT INTO DishCategory(idDish, idCategory) VALUES(121, 11);
INSERT INTO DishCategory(idDish, idCategory) VALUES(122, 11);
INSERT INTO DishCategory(idDish, idCategory) VALUES(123, 11);
INSERT INTO DishCategory(idDish, idCategory) VALUES(124, 11);
INSERT INTO DishCategory(idDish, idCategory) VALUES(125, 11);
INSERT INTO DishCategory(idDish, idCategory) VALUES(126, 11);

INSERT INTO DishCategory(idDish, idCategory) VALUES(127, 8);
INSERT INTO DishCategory(idDish, idCategory) VALUES(128, 8);
INSERT INTO DishCategory(idDish, idCategory) VALUES(129, 8);
INSERT INTO DishCategory(idDish, idCategory) VALUES(130, 8);
INSERT INTO DishCategory(idDish, idCategory) VALUES(131, 8);
INSERT INTO DishCategory(idDish, idCategory) VALUES(132, 8);

INSERT INTO DishCategory(idDish, idCategory) VALUES(133, 8);
INSERT INTO DishCategory(idDish, idCategory) VALUES(134, 8);
INSERT INTO DishCategory(idDish, idCategory) VALUES(135, 8);
INSERT INTO DishCategory(idDish, idCategory) VALUES(136, 8);
INSERT INTO DishCategory(idDish, idCategory) VALUES(137, 8);
INSERT INTO DishCategory(idDish, idCategory) VALUES(138, 8);

INSERT INTO DishCategory(idDish, idCategory) VALUES(139, 8);
INSERT INTO DishCategory(idDish, idCategory) VALUES(140, 8);
INSERT INTO DishCategory(idDish, idCategory) VALUES(141, 8);
INSERT INTO DishCategory(idDish, idCategory) VALUES(142, 8);
INSERT INTO DishCategory(idDish, idCategory) VALUES(143, 8);
INSERT INTO DishCategory(idDish, idCategory) VALUES(144, 8);

INSERT INTO DishCategory(idDish, idCategory) VALUES(145, 10);
INSERT INTO DishCategory(idDish, idCategory) VALUES(146, 10);
INSERT INTO DishCategory(idDish, idCategory) VALUES(147, 10);
INSERT INTO DishCategory(idDish, idCategory) VALUES(148, 10);
INSERT INTO DishCategory(idDish, idCategory) VALUES(149, 10);
INSERT INTO DishCategory(idDish, idCategory) VALUES(150, 10);
INSERT INTO DishCategory(idDish, idCategory) VALUES(145, 11);
INSERT INTO DishCategory(idDish, idCategory) VALUES(146, 11);
INSERT INTO DishCategory(idDish, idCategory) VALUES(147, 11);
INSERT INTO DishCategory(idDish, idCategory) VALUES(148, 11);
INSERT INTO DishCategory(idDish, idCategory) VALUES(149, 11);
INSERT INTO DishCategory(idDish, idCategory) VALUES(150, 11);

INSERT INTO DishCategory(idDish, idCategory) VALUES(151, 11);
INSERT INTO DishCategory(idDish, idCategory) VALUES(152, 11);
INSERT INTO DishCategory(idDish, idCategory) VALUES(153, 11);
INSERT INTO DishCategory(idDish, idCategory) VALUES(154, 11);
INSERT INTO DishCategory(idDish, idCategory) VALUES(155, 11);
INSERT INTO DishCategory(idDish, idCategory) VALUES(156, 11);

INSERT INTO DishCategory(idDish, idCategory) VALUES(157, 12);
INSERT INTO DishCategory(idDish, idCategory) VALUES(158, 12);
INSERT INTO DishCategory(idDish, idCategory) VALUES(159, 12);
INSERT INTO DishCategory(idDish, idCategory) VALUES(160, 12);
INSERT INTO DishCategory(idDish, idCategory) VALUES(161, 12);
INSERT INTO DishCategory(idDish, idCategory) VALUES(162, 12);

INSERT INTO DishCategory(idDish, idCategory) VALUES(163, 12);
INSERT INTO DishCategory(idDish, idCategory) VALUES(164, 12);
INSERT INTO DishCategory(idDish, idCategory) VALUES(165, 12);
INSERT INTO DishCategory(idDish, idCategory) VALUES(166, 12);
INSERT INTO DishCategory(idDish, idCategory) VALUES(167, 12);
INSERT INTO DishCategory(idDish, idCategory) VALUES(168, 12);

INSERT INTO DishCategory(idDish, idCategory) VALUES(169, 13);
INSERT INTO DishCategory(idDish, idCategory) VALUES(170, 13);
INSERT INTO DishCategory(idDish, idCategory) VALUES(171, 13);
INSERT INTO DishCategory(idDish, idCategory) VALUES(172, 13);
INSERT INTO DishCategory(idDish, idCategory) VALUES(173, 13);
INSERT INTO DishCategory(idDish, idCategory) VALUES(174, 13);
INSERT INTO DishCategory(idDish, idCategory) VALUES(175, 13);
INSERT INTO DishCategory(idDish, idCategory) VALUES(176, 13);
INSERT INTO DishCategory(idDish, idCategory) VALUES(177, 13);
INSERT INTO DishCategory(idDish, idCategory) VALUES(178, 13);
INSERT INTO DishCategory(idDish, idCategory) VALUES(179, 13);
INSERT INTO DishCategory(idDish, idCategory) VALUES(180, 13);
INSERT INTO DishCategory(idDish, idCategory) VALUES(181, 13);
INSERT INTO DishCategory(idDish, idCategory) VALUES(182, 13);
INSERT INTO DishCategory(idDish, idCategory) VALUES(183, 13);
INSERT INTO DishCategory(idDish, idCategory) VALUES(184, 13);
INSERT INTO DishCategory(idDish, idCategory) VALUES(185, 13);
INSERT INTO DishCategory(idDish, idCategory) VALUES(186, 13);