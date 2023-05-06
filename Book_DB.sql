
CREATE DATABASE Book_Store;
/*ON
(name=Book_Store_DB,
filename="C:\Program Files\Microsoft SQL Server\MSSQL15.MSSQLSERVER\MSSQL\DATA\Book_Store_DB.mdf",
size=20,maxsize=100,filegrowth=10)
LOG ON
(name=Book_Store_LOG,
filename="C:\Program Files\Microsoft SQL Server\MSSQL15.MSSQLSERVER\MSSQL\DATA\Book_Store_LOG.ldf",
size=15,maxsize=50,filegrowth=5);
GO
use Book_Store;
go*/

CREATE TABLE Users  (
user_id int primary key (user_id) IDENTITY(1,1),
user_name varchar(255),
user_add_date datetime,
phone varchar(12) not null,
email varchar(255) not null unique,
location varchar(255),
city varchar(255),
user_role varchar(100),
user_log varchar(255),
);
Go
CREATE TABLE Category(
category_id int IDENTITY(1,1),
category_name varchar(100),
constraint category_PK primary key(category_id)
)
GO

CREATE TABLE Stocks(
stock_id int identity(1,1),
stock_name varchar(255),
stock_location varchar(400),
city varchar(200),
phone varchar(15),
email varchar(100),
constraint stock_PK primary key(stock_id)
)
GO
CREATE TABLE Products (
prod_id int IDENTITY(1,1),
prod_name varchar(255),
prod_desc varchar(1000),
prod_quantity int,
prod_date DATETIME,
price numeric(5,2),
status varchar(100),
category_id int,
user_id int,
stock_id int,
constraint prod_PK primary key(prod_id),
constraint user_prod_FK foreign key(user_id) references Users(user_id),
constraint category_prod_FK foreign key(category_id) references Category(category_id),
constraint Stock_prod_FK foreign key(stock_id) references Stocks(stock_id)
)
GO


CREATE TABLE Orders(
order_id int IDENTITY(1,1),
order_date datetime,
order_status varchar(100),
order_location varchar(255),
shipped_date datetime,
user_id int,
prod_id int,
constraint orders_PK primary key(order_id),
constraint user_order_FK foreign key(user_id) references Users(user_id),
constraint product_order_FK foreign key(prod_id) references Products(prod_id)
)
GO
INSERT INTO Users (user_name,phone,email,location,city,user_role,user_log)
values ('khaled_admin','01018492229','khaledelsaied62@gmail.com','elslam-faisel','suez','admin','i am admin');

/*drop table Users;
drop table Category;
drop table Stocks;
drop table Products;
drop table Orders;*/