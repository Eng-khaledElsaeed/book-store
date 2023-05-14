from faker import Faker
import mysql.connector
n = 1000
# create a new Faker instance
fake = Faker()

# create a connection to the MySQL database
cnx = mysql.connector.connect(user='root', password='',port=3306,
                              host='127.0.0.1', database='book_store')
cursor = cnx.cursor()

# table_user: str = """
# create table users (id int not null AUTO_INCREMENT primary key ,first_name varchar(100),last_name varchar(10), email varchar(100));
# """
# cursor.execute(table_user)

# generate and insert fake data into the database
for i in range(1000):
    # user_name = fake.prefix_male()+fake.name()
    # status = fake.word(ext_word_list=['accept', 'reject'])
    # image =fake.image_url() #fake.image(size=(2, 2), hue='purple', luminosity='bright', image_format='jpg')
    # phone = fake.phone_number()
    # email = fake.email()
    # user_pass = fake.password(length=12)
    # address = fake.address()
    # city = fake.city()
    # user_role = fake.word(ext_word_list=['user'])
    # connection_status = fake.word(ext_word_list=['offline'])
    # last_seen = fake.date_time()
    
    # query = "INSERT INTO users (user_name, status, image, phone, email, user_pass, address, city, user_role,connection_status,last_seen) VALUES (%s, %s, %s,%s, %s, %s,%s, %s, %s,%s, %s)"
    # cursor.execute(query, (user_name, status, image, phone, email, user_pass, address, city, user_role,connection_status,last_seen))
    
    
    
    # stock_name = fake.prefix_male()+fake.name()
    # manager_name=fake.prefix_male()+fake.name()
    # phone = fake.phone_number()
    # email = fake.email()
    # location = fake.address()
    
    # query = "INSERT INTO stock (stock_name, phone, manager_name, email, location) VALUES (%s, %s, %s,%s, %s)"
    # cursor.execute(query, (stock_name, phone, manager_name, email, location))
    
    # category_name = fake.job()
    # category_desc=fake.paragraph(nb_sentences=5)
    # category_status = fake.word(ext_word_list=['available','unavailable'])
    
    # query = "INSERT INTO category (category_name, category_desc, category_status) VALUES (%s, %s, %s)"
    # cursor.execute(query, (category_name, category_desc, category_status))
    
    # users_query="SELECT * FROM users"
    # users=cursor.execute(users_query)
    
    # stock_query="SELECT * FROM stock"
    # stock=cursor.execute(stock_query)
    
    
    # category_query="SELECT * FROM category"
    # category=cursor.execute(category_query)
    
    
    # prod_name = fake.job()
    # prod_desc=fake.paragraph(nb_sentences=3)
    # prod_quant=fake.random_number(digits=1)
    # price=fake.random_number(digits=3)
    # status=fake.word(ext_word_list=['accept','pending','reject'])
    # category_id=fake.random_element(elements=[cat['category_id'] for cat in category])
    # user_id=fake.random_element(elements=[user['user_id']for user in users])
    # stock_id=fake.random_element(elements=[stock['stock_id']for stock in stock])
    # prod_imag_url=fake.image_url()
    
    # query = "INSERT INTO products (prod_name, prod_desc, prod_quant,status,category_id,user_id,stock_id,prod_imag_url) VALUES (%s, %s, %s,%s, %s, %s,%s, %s)"
    # cursor.execute(query, (prod_name, prod_desc, prod_quant,status,category_id,user_id,stock_id,prod_imag_url))
    
    
    
cnx.commit()

# close the database connection
cnx.close()