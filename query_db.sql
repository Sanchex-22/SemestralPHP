create database inventario;
use inventario;
Create Table Products(
	id INT not null auto_increment,
    name CHAR(20) not null,
    description VARCHAR(100),
    category VARCHAR(50),
    quantity INT,
    create_date DATETIME not null,
    modified_date DATETIME not null,
	primary key (id)
);

use inventario;
Create Table User(
	id int not null auto_increment,
    user_name char(20) not null,
    password varchar(20) not null,
    primary key (id)
);

 insert into User (user_name, password) values ("carlos","1234");
 
 use inventario;
 select*from products;
  select*from user;