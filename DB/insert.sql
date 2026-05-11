-- Hotel_Room_Booking_System_Data.sql

USE hotel_room_booking_system;

-- =====================================
-- INSERT USERS
-- =====================================
INSERT INTO users
(name, email, password_hash, phone, nationality, id_number, role, profile_pic, is_active)
VALUES
('John Doe', 'john@example.com', 'hashedpass1', '01711111111', 'American', 'A12345', 'guest', 'john.jpg', 1),
('Sarah Khan', 'sarah@example.com', 'hashedpass2', '01822222222', 'Bangladeshi', 'B67890', 'receptionist', 'sarah.jpg', 1),
('Mike Wilson', 'mike@example.com', 'hashedpass3', '01933333333', 'Canadian', 'C98765', 'housekeeping', 'mike.jpg', 1),
('Admin User', 'admin@example.com', 'hashedpass4', '01644444444', 'Bangladeshi', 'D45678', 'admin', 'admin.jpg', 1);

-- =====================================
-- INSERT ROOM TYPES
-- =====================================
INSERT INTO room_types
(name, description, price_per_night, max_capacity, thumbnail_path, amenities)
VALUES
(
    'Standard',
    'Basic standard room',
    80.00,
    2,
    'standard.jpg',
    '["WiFi","AC","TV"]'
),
(
    'Deluxe',
    'Luxury deluxe room',
    150.00,
    3,
    'deluxe.jpg',
    '["WiFi","AC","TV","Mini Bar"]'
),
(
    'Suite',
    'Premium suite room',
    300.00,
    5,
    'suite.jpg',
    '["WiFi","AC","TV","Mini Bar","Jacuzzi"]'
);

-- =====================================
-- INSERT ROOMS
-- =====================================
INSERT INTO rooms
(room_type_id, room_number, floor, status, notes)
VALUES
(1, '101', 1, 'available', 'Near lobby'),
(1, '102', 1, 'occupied', 'Sea view'),
(2, '201', 2, 'dirty', 'Needs cleaning'),
(2, '202', 2, 'maintenance', 'AC issue'),
(3, '301', 3, 'available', 'VIP Suite');

-- =====================================
-- INSERT BOOKINGS
-- =====================================
INSERT INTO bookings
(guest_id, room_id, room_type_id, checkin_date, checkout_date, num_guests, total_price, status, source)
VALUES
(1, 1, 1, '2026-05-15', '2026-05-18', 2, 240.00, 'confirmed', 'online'),
(1, 2, 1, '2026-05-20', '2026-05-22', 1, 160.00, 'checked_in', 'walk_in');

-- =====================================
-- INSERT BILLING
-- =====================================
INSERT INTO billing
(booking_id, guest_id, base_amount, extras_amount, discount_amount, total_amount, payment_method, payment_status, paid_at, receipt_path)
VALUES
(1, 1, 240.00, 20.00, 10.00, 250.00, 'Credit Card', 'paid', NOW(), 'receipt1.pdf'),
(2, 1, 160.00, 15.00, 0.00, 175.00, 'Cash', 'pending', NULL, NULL);

-- =====================================
-- INSERT SERVICE REQUESTS
-- =====================================
INSERT INTO service_requests
(booking_id, guest_id, room_id, service_type, description, status)
VALUES
(1, 1, 1, 'toiletries', 'Need extra towels', 'pending'),
(2, 1, 2, 'room_service', 'Dinner request', 'in_progress');

-- =====================================
-- INSERT HOUSEKEEPING TASKS
-- =====================================
INSERT INTO housekeeping_tasks
(room_id, assigned_to, task_type, priority, status, notes, scheduled_date)
VALUES
(3, 3, 'cleaning', 'normal', 'pending', 'Clean room before check-in', '2026-05-12'),
(4, 3, 'maintenance', 'urgent', 'in_progress', 'Fix AC immediately', '2026-05-12');

-- =====================================
-- INSERT MAINTENANCE REPORTS
-- =====================================
INSERT INTO maintenance_reports
(room_id, reported_by, description, severity, status)
VALUES
(4, 3, 'Air conditioner not working', 'high', 'open'),
(3, 3, 'Bathroom light damaged', 'medium', 'in_progress');

-- =====================================
-- INSERT SEASONAL PRICING
-- =====================================
INSERT INTO seasonal_pricing
(room_type_id, label, start_date, end_date, price_per_night)
VALUES
(1, 'Eid Holiday', '2026-06-01', '2026-06-10', 100.00),
(2, 'Summer Offer', '2026-07-01', '2026-07-31', 130.00),
(3, 'New Year Special', '2026-12-25', '2027-01-05', 350.00);

-- =====================================
-- INSERT REVIEWS
-- =====================================
INSERT INTO reviews
(booking_id, guest_id, overall_rating, cleanliness_rating, service_rating, review_text, admin_reply)
VALUES
(
    1,
    1,
    5,
    5,
    4,
    'Excellent room and service.',
    'Thank you for your feedback!'
),
(
    2,
    1,
    4,
    4,
    5,
    'Very comfortable stay.',
    NULL
);

-- =====================================
-- INSERT LOYALTY POINTS
-- =====================================
INSERT INTO loyalty_points
(guest_id, booking_id, points_earned, points_used, balance)
VALUES
(1, 1, 120, 20, 100),
(1, 2, 80, 0, 180);