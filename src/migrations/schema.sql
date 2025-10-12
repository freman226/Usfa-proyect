CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    image VARCHAR(255) DEFAULT 'default.jpg',
    description TEXT NOT NULL,
    price DECIMAL(10,2) NOT NULL
);