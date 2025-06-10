CREATE TABLE jewels (
    id INT AUTO_INCREMENT PRIMARY KEY,
    jewel_name VARCHAR(255) NOT NULL,
    type ENUM('ring','necklace','earring','bracelet') NOT NULL,
    material VARCHAR(255),
    purity VARCHAR(50),
    weight FLOAT,
    price FLOAT,
    description TEXT,
    supplier VARCHAR(255),
    date_acquired DATE,
    status ENUM('in_stock','sold','display','retired') DEFAULT 'in_stock',
    image_path VARCHAR(255)
);

CREATE TABLE custom_orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(255),
    size VARCHAR(50),
    material VARCHAR(255),
    design_notes TEXT,
    quote FLOAT,
    progress ENUM('received','in_production','completed','delivered') DEFAULT 'received',
    payment_status ENUM('pending','paid','refunded') DEFAULT 'pending',
    delivery_status ENUM('not_delivered','delivered') DEFAULT 'not_delivered'
);

CREATE TABLE sales (
    id INT AUTO_INCREMENT PRIMARY KEY,
    jewel_id INT NOT NULL,
    customer_name VARCHAR(255),
    sale_date DATE,
    price FLOAT,
    payment_method ENUM('cash','credit_card','online') NOT NULL,
    FOREIGN KEY (jewel_id) REFERENCES jewels(id)
);
