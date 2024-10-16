

CREATE TABLE users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') NOT NULL
);

-- Insert some test data
INSERT INTO users (username, password, role) VALUES ('admin', 'adminpass', 'admin');
INSERT INTO users (username, password, role) VALUES ('user1', 'userpass1', 'user');
INSERT INTO users (username, password, role) VALUES ('user2', 'userpass2', 'user');



-- Table to store villager profiles
CREATE TABLE villagers (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    village_id VARCHAR(20) UNIQUE,
    name VARCHAR(30),
    age INT(3),
    address VARCHAR(50),
    occupation VARCHAR(20)
);




CREATE TABLE residents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    village_id VARCHAR(20) UNIQUE NOT NULL,
    full_name VARCHAR(20) NOT NULL,
    gender VARCHAR(10) NOT NULL,
    dob DATE NOT NULL,
    marital_status VARCHAR(10) NOT NULL,
    contact_no VARCHAR(10) NOT NULL,
    email VARCHAR(25) NOT NULL,
    vemail VARCHAR(25) NOT NULL,
    password VARCHAR(25) NOT NULL,
    aadhar_no VARCHAR(12) NOT NULL,
    voter_id VARCHAR(10),
    ration_card VARCHAR(20) NOT NULL,
    pan_card VARCHAR(10),
    house_no VARCHAR(20) NOT NULL,
    street VARCHAR(25) NOT NULL,
    pincode VARCHAR(6) NOT NULL,
    district VARCHAR(20) NOT NULL,
    state VARCHAR(20) NOT NULL,
    household_head VARCHAR(20) NOT NULL,
    family_members INT NOT NULL,
    education_level VARCHAR(20),
    occupation VARCHAR(20),
    monthly_income VARCHAR(20),
    employment_type VARCHAR(25),
    land_ownership VARCHAR(20),
    land_size VARCHAR(40),
    land_type VARCHAR(40),
    livestock_ownership VARCHAR(25),
    health_condition VARCHAR(20),
    disability_status VARCHAR(20),
    health_scheme VARCHAR(20),
    welfare_beneficiary VARCHAR(25),
    electricity_conn VARCHAR(20),
    water_conn VARCHAR(25),
    sanitation_facility VARCHAR(50),
    cooking_fuel VARCHAR(25),
    internet_connectivity VARCHAR(5),
    emergency_name VARCHAR(25) NOT NULL,
    emergency_relation VARCHAR(25) NOT NULL,
    emergency_phone VARCHAR(10) NOT NULL,
    photo VARCHAR(50) NOT NULL,
    signature VARCHAR(55) NOT NULL,
    aadhar_card VARCHAR(55) NOT NULL,
    income_cast VARCHAR(55) NOT NULL,
    link VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);



CREATE TABLE complaints (
    complaint_id INT AUTO_INCREMENT PRIMARY KEY,
    village_id INT,
    complaint_text TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (village_id) REFERENCES residents(village_id)
);


CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    image_url VARCHAR(255)
);




CREATE TABLE cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    product_id INT,
    quantity INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);


CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    address VARCHAR(255) NOT NULL,
    pincode VARCHAR(10) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    total_amount DECIMAL(10, 2) NOT NULL,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);




CREATE TABLE order_details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    product_id INT,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

INSERT INTO products (name, description, price, image_url) VALUES 
('Desi Ghee', 'Pure, homemade ghee from village cows.', 500, 'images/desi_ghee.jpg'),
('Organic Honey', 'Fresh, organic honey harvested locally.', 300, 'images/organic_honey.jpg'),
('Handmade Clothing', 'Traditional, handwoven garments.', 750, 'images/handmade_clothes.jpg'),
('Bamboo Crafts', 'Beautiful, hand-carved bamboo items.', 200, 'images/bamboo_crafts.jpg'),
('Herbal Tea', 'Locally grown herbal tea for health benefits.', 250, 'images/herbal_tea.jpg');



ALTER TABLE complaints ADD COLUMN resolved TINYINT(1) DEFAULT 0;

ALTER TABLE `complaints`
ADD `proof_document` VARCHAR(50) NULL;
