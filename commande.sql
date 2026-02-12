-- 1) Database
CREATE DATABASE IF NOT EXISTS takalo
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE takalo;

-- 2) Tables
DROP TABLE IF EXISTS exchanges;
DROP TABLE IF EXISTS objects;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS admins;

CREATE TABLE admins (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(190) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(190) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE objects (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  description TEXT,
  value DECIMAL(12,2) NOT NULL DEFAULT 0,
  image VARCHAR(255),
  owner_id INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX (owner_id),
  CONSTRAINT fk_objects_owner
    FOREIGN KEY (owner_id) REFERENCES users(id)
    ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE exchanges (
  id INT AUTO_INCREMENT PRIMARY KEY,
  object_id INT NOT NULL,              -- objet demandé
  proposed_object_id INT NOT NULL,     -- objet proposé
  owner_id INT NOT NULL,               -- propriétaire de object_id
  new_owner_id INT NOT NULL,           -- propriétaire de proposed_object_id
  status ENUM('PENDING','ACCEPTED','REFUSED') NOT NULL DEFAULT 'PENDING',
  date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

  INDEX (object_id),
  INDEX (proposed_object_id),
  INDEX (owner_id),
  INDEX (new_owner_id),

  CONSTRAINT fk_ex_object
    FOREIGN KEY (object_id) REFERENCES objects(id)
    ON DELETE CASCADE,

  CONSTRAINT fk_ex_proposed_object
    FOREIGN KEY (proposed_object_id) REFERENCES objects(id)
    ON DELETE CASCADE,

  CONSTRAINT fk_ex_owner
    FOREIGN KEY (owner_id) REFERENCES users(id)
    ON DELETE CASCADE,

  CONSTRAINT fk_ex_new_owner
    FOREIGN KEY (new_owner_id) REFERENCES users(id)
    ON DELETE CASCADE
) ENGINE=InnoDB;

-- Admin (admin123)
INSERT INTO admins(name,email,password) VALUES
('Super Admin','admin@takalo.com','$2y$10$D4x7uWBxD0a7JtP2q.6M6O71O/PGJRXcE6o0o4dY1A4V4o1v3m0cS');

-- Users (123456)
INSERT INTO users(email,password) VALUES
('u1@takalo.com','$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcfl7p92ldGxad68LJZdL17lhWy'),
('u2@takalo.com','$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcfl7p92ldGxad68LJZdL17lhWy');

-- Objects
INSERT INTO objects(name,description,value,image,owner_id) VALUES
('Basket Nike','Pointure 42, bon état',120000,'nike.jpg',1),
('Téléphone Redmi','64GB, batterie ok',350000,'redmi.jpg',1),
('Montre Casio','Vintage',80000,'casio.jpg',2),
('Casque JBL','Bluetooth',150000,'jbl.jpg',2);

-- Exchange (u2 propose Casio contre Nike)
INSERT INTO exchanges(object_id, proposed_object_id, owner_id, new_owner_id, status)
VALUES (1, 3, 1, 2, 'PENDING');
