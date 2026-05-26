CREATE DATABASE IF NOT EXISTS environmental_store
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE environmental_store;

CREATE TABLE IF NOT EXISTS admins (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  pw VARCHAR(255) NOT NULL,
  google_auth VARCHAR(255) NULL,
  phone VARCHAR(30) NULL,
  rol VARCHAR(50) NOT NULL DEFAULT 'admin',
  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS users (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  pw VARCHAR(255) NOT NULL,
  google_auth VARCHAR(255) NULL,
  phone VARCHAR(30) NULL,
  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS addresses (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT UNSIGNED NOT NULL,
  address VARCHAR(255) NOT NULL,
  province VARCHAR(100) NULL,
  city VARCHAR(100) NOT NULL,
  post_code VARCHAR(20) NULL,
  country VARCHAR(100) NOT NULL,
  phone VARCHAR(30) NULL,
  name_destination VARCHAR(100) NULL,
  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_addresses_user
    FOREIGN KEY (user_id) REFERENCES users(id)
    ON UPDATE CASCADE
    ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS promotions (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  code VARCHAR(50) NOT NULL UNIQUE,
  discount DECIMAL(5,2) NOT NULL,
  is_active BOOLEAN NOT NULL DEFAULT TRUE,
  starts_at DATETIME NULL,
  ends_at DATETIME NULL,
  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS categories (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  description TEXT NULL,
  parent_id BIGINT UNSIGNED NULL,
  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_categories_parent
    FOREIGN KEY (parent_id) REFERENCES categories(id)
    ON UPDATE CASCADE
    ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS products (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  promotion_id BIGINT UNSIGNED NULL,
  name VARCHAR(150) NOT NULL,
  status VARCHAR(50) NOT NULL DEFAULT 'active',
  price DECIMAL(10,2) NOT NULL,
  stock INT UNSIGNED NOT NULL DEFAULT 0,
  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_products_promotion
    FOREIGN KEY (promotion_id) REFERENCES promotions(id)
    ON UPDATE CASCADE
    ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS product_category (
  product_id BIGINT UNSIGNED NOT NULL,
  category_id BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (product_id, category_id),
  CONSTRAINT fk_product_category_product
    FOREIGN KEY (product_id) REFERENCES products(id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  CONSTRAINT fk_product_category_category
    FOREIGN KEY (category_id) REFERENCES categories(id)
    ON UPDATE CASCADE
    ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS orders (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT UNSIGNED NOT NULL,
  total_price DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  order_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  status VARCHAR(50) NOT NULL DEFAULT 'pending',
  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_orders_user
    FOREIGN KEY (user_id) REFERENCES users(id)
    ON UPDATE CASCADE
    ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS payments (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  order_id BIGINT UNSIGNED NOT NULL UNIQUE,
  payment_details VARCHAR(255) NULL,
  payment_status VARCHAR(50) NOT NULL DEFAULT 'pending',
  reference VARCHAR(100) NULL UNIQUE,
  amount DECIMAL(10,2) NOT NULL,
  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_payments_order
    FOREIGN KEY (order_id) REFERENCES orders(id)
    ON UPDATE CASCADE
    ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS order_lines (
  order_id BIGINT UNSIGNED NOT NULL,
  num_linea INT UNSIGNED NOT NULL,
  product_id BIGINT UNSIGNED NOT NULL,
  unit INT UNSIGNED NOT NULL,
  price DECIMAL(10,2) NOT NULL,
  total_price DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (order_id, num_linea),
  CONSTRAINT fk_order_lines_order
    FOREIGN KEY (order_id) REFERENCES orders(id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  CONSTRAINT fk_order_lines_product
    FOREIGN KEY (product_id) REFERENCES products(id)
    ON UPDATE CASCADE
    ON DELETE RESTRICT
) ENGINE=InnoDB;

-- ==========================================
-- SCRIPT DE INSERCIÓN MASIVA (SEEDER EN SQL)
-- ==========================================

-- Inserts para Admins
INSERT INTO admins (name, email, pw, phone, rol) VALUES
('Admin Principal', 'admin@boticanatural.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '600123456', 'superadmin'),
('Admin Tienda', 'tienda@boticanatural.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '600123457', 'admin');

-- Inserts para Users
INSERT INTO users (name, email, pw, phone) VALUES
('Juan Pérez', 'juan@ejemplo.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '610222333'),
('María García', 'maria@ejemplo.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '610444555'),
('Carlos Ruiz', 'carlos@ejemplo.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '610666777');

-- Inserts para Addresses
INSERT INTO addresses (user_id, address, province, city, post_code, country, phone, name_destination) VALUES
(1, 'Calle Falsa 123', 'Madrid', 'Madrid', '28080', 'España', '610222333', 'Juan Pérez'),
(2, 'Avenida Principal 45', 'Barcelona', 'Barcelona', '08001', 'España', '610444555', 'María García');

-- Inserts para Promotions
INSERT INTO promotions (name, code, discount, is_active, starts_at, ends_at) VALUES
('Rebajas Verano', 'SUMMER20', 20.00, 1, '2026-06-01 00:00:00', '2026-08-31 23:59:59'),
('Bienvenida', 'WELCOME10', 10.00, 1, '2026-01-01 00:00:00', '2026-12-31 23:59:59');

-- Inserts para Categories
INSERT INTO categories (name, description, parent_id) VALUES
('Aceites', 'Aceites esenciales y naturales', NULL),
('Infusiones', 'Tés y mezclas botánicas', NULL),
('Cosmética', 'Cremas, tónicos y brumas', NULL),
('Aceites Faciales', 'Aceites específicos para la cara', 1),
('Tés Relax', 'Infusiones para dormir', 2);

-- Inserts para Products
INSERT INTO products (promotion_id, name, status, price, stock) VALUES
(NULL, 'Aceite de Eucalipto', 'active', 18.90, 50),
(NULL, 'Bruma de Rosas', 'active', 22.00, 30),
(1, 'Crema Facial de Algas', 'active', 28.00, 15),
(2, 'Infusión Manzanilla Eco', 'active', 6.50, 100),
(NULL, 'Aceite de Menta', 'active', 14.20, 45);

-- Inserts para Product_Category
INSERT INTO product_category (product_id, category_id) VALUES
(1, 1),
(2, 3),
(3, 3),
(4, 2),
(4, 5),
(5, 1);

-- Inserts para Orders
INSERT INTO orders (user_id, total_price, order_date, status) VALUES
(1, 40.90, '2026-05-18 10:30:00', 'completed'),
(2, 28.00, '2026-05-19 11:15:00', 'pending');

-- Inserts para Order_lines
INSERT INTO order_lines (order_id, num_linea, product_id, unit, price, total_price) VALUES
(1, 1, 1, 1, 18.90, 18.90),
(1, 2, 2, 1, 22.00, 22.00),
(2, 1, 3, 1, 28.00, 28.00);

-- Inserts para Payments
INSERT INTO payments (order_id, payment_details, payment_status, reference, amount) VALUES
(1, 'Tarjeta Visa ****1234', 'completed', 'REF-001', 40.90),
(2, 'PayPal', 'pending', 'REF-002', 28.00);
