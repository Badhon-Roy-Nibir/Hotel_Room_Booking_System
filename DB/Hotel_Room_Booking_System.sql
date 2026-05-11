-- Hotel_Room_Booking_System.sql

CREATE DATABASE IF NOT EXISTS Hotel_Room_Booking_System;
USE hotel_room_booking_system;

-- =========================
-- USERS TABLE
-- =========================
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    nationality VARCHAR(100),
    id_number VARCHAR(100),
    role ENUM('guest','receptionist','housekeeping','admin') DEFAULT 'guest',
    profile_pic VARCHAR(255),
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =========================
-- ROOM TYPES TABLE
-- =========================
CREATE TABLE room_types (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name ENUM('Standard','Deluxe','Suite') NOT NULL,
    description TEXT,
    price_per_night DECIMAL(10,2) NOT NULL,
    max_capacity INT NOT NULL,
    thumbnail_path VARCHAR(255),
    amenities JSON
);

-- =========================
-- ROOMS TABLE
-- =========================
CREATE TABLE rooms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    room_type_id INT NOT NULL,
    room_number VARCHAR(20) UNIQUE NOT NULL,
    floor INT,
    status ENUM('available','occupied','dirty','maintenance','blocked') DEFAULT 'available',
    notes TEXT,

    FOREIGN KEY (room_type_id) REFERENCES room_types(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- =========================
-- BOOKINGS TABLE
-- =========================
CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    guest_id INT NOT NULL,
    room_id INT NOT NULL,
    room_type_id INT NOT NULL,
    checkin_date DATE NOT NULL,
    checkout_date DATE NOT NULL,
    num_guests INT NOT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    status ENUM(
        'pending',
        'confirmed',
        'checked_in',
        'checked_out',
        'cancelled'
    ) DEFAULT 'pending',

    source ENUM('online','walk_in') DEFAULT 'online',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (guest_id) REFERENCES users(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    FOREIGN KEY (room_id) REFERENCES rooms(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    FOREIGN KEY (room_type_id) REFERENCES room_types(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- =========================
-- BILLING TABLE
-- =========================
CREATE TABLE billing (
    id INT AUTO_INCREMENT PRIMARY KEY,
    booking_id INT NOT NULL,
    guest_id INT NOT NULL,
    base_amount DECIMAL(10,2) DEFAULT 0.00,
    extras_amount DECIMAL(10,2) DEFAULT 0.00,
    discount_amount DECIMAL(10,2) DEFAULT 0.00,
    total_amount DECIMAL(10,2) NOT NULL,

    payment_method VARCHAR(50),

    payment_status ENUM('pending','paid') DEFAULT 'pending',

    paid_at TIMESTAMP NULL,
    receipt_path VARCHAR(255),

    FOREIGN KEY (booking_id) REFERENCES bookings(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    FOREIGN KEY (guest_id) REFERENCES users(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- =========================
-- SERVICE REQUESTS TABLE
-- =========================
CREATE TABLE service_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    booking_id INT NOT NULL,
    guest_id INT NOT NULL,
    room_id INT NOT NULL,

    service_type ENUM(
        'extra_bed',
        'toiletries',
        'laundry',
        'room_service',
        'other'
    ) NOT NULL,

    description TEXT,

    status ENUM(
        'pending',
        'in_progress',
        'completed'
    ) DEFAULT 'pending',

    requested_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (booking_id) REFERENCES bookings(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    FOREIGN KEY (guest_id) REFERENCES users(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    FOREIGN KEY (room_id) REFERENCES rooms(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- =========================
-- HOUSEKEEPING TASKS TABLE
-- =========================
CREATE TABLE housekeeping_tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    room_id INT NOT NULL,
    assigned_to INT NOT NULL,

    task_type ENUM(
        'cleaning',
        'inspection',
        'maintenance'
    ) NOT NULL,

    priority ENUM('normal','urgent') DEFAULT 'normal',

    status ENUM(
        'pending',
        'in_progress',
        'done'
    ) DEFAULT 'pending',

    notes TEXT,
    scheduled_date DATE,
    completed_at TIMESTAMP NULL,

    FOREIGN KEY (room_id) REFERENCES rooms(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    FOREIGN KEY (assigned_to) REFERENCES users(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- =========================
-- MAINTENANCE REPORTS TABLE
-- =========================
CREATE TABLE maintenance_reports (
    id INT AUTO_INCREMENT PRIMARY KEY,
    room_id INT NOT NULL,
    reported_by INT NOT NULL,

    description TEXT NOT NULL,

    severity ENUM(
        'low',
        'medium',
        'high'
    ) DEFAULT 'low',

    status ENUM(
        'open',
        'in_progress',
        'resolved'
    ) DEFAULT 'open',

    reported_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    resolved_at TIMESTAMP NULL,

    FOREIGN KEY (room_id) REFERENCES rooms(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    FOREIGN KEY (reported_by) REFERENCES users(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- =========================
-- SEASONAL PRICING TABLE
-- =========================
CREATE TABLE seasonal_pricing (
    id INT AUTO_INCREMENT PRIMARY KEY,
    room_type_id INT NOT NULL,

    label VARCHAR(150) NOT NULL,

    start_date DATE NOT NULL,
    end_date DATE NOT NULL,

    price_per_night DECIMAL(10,2) NOT NULL,

    FOREIGN KEY (room_type_id) REFERENCES room_types(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- =========================
-- REVIEWS TABLE
-- =========================
CREATE TABLE reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    booking_id INT NOT NULL,
    guest_id INT NOT NULL,

    overall_rating INT CHECK (overall_rating BETWEEN 1 AND 5),
    cleanliness_rating INT CHECK (cleanliness_rating BETWEEN 1 AND 5),
    service_rating INT CHECK (service_rating BETWEEN 1 AND 5),

    review_text TEXT,
    admin_reply TEXT,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (booking_id) REFERENCES bookings(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    FOREIGN KEY (guest_id) REFERENCES users(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- =========================
-- LOYALTY POINTS TABLE
-- =========================
CREATE TABLE loyalty_points (
    id INT AUTO_INCREMENT PRIMARY KEY,
    guest_id INT NOT NULL,
    booking_id INT NOT NULL,

    points_earned INT DEFAULT 0,
    points_used INT DEFAULT 0,
    balance INT DEFAULT 0,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (guest_id) REFERENCES users(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    FOREIGN KEY (booking_id) REFERENCES bookings(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);