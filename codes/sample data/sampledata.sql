sample goes here

/* Zone Sample Data*/
INSERT INTO `zone`(`zoneID`, `zoneDesc`, `zoneImg`) 
VALUES 
('A', 'Located on the left side of the hill', 'uploads/A.png'),
('B', 'Located in the middle side of the hill', 'uploads/B.png'),
('C', 'Located on the right side of the hill', 'uploads/C.png');

/* Campsite Sample Data */
INSERT INTO `campsite`(`campsiteID`, `campsitePrice`, `zoneID`) VALUES 
('A1','10.00','A'),
('A2','10.00','A'),
('A3','10.00','A'),
('A4','10.00','A'),
('A5','10.00','A'),
('B1','15.00','B'),
('B2','15.00','B'),
('B3','15.00','B'),
('B4','15.00','B'),
('B5','15.00','B'),
('C1','20.00','C'),
('C2','20.00','C'),
('C3','20.00','C'),
('C4','20.00','C'),
('C5','20.00','C');

/* Category sample data */
INSERT INTO toolCategory (categoryName, categoryDesc)
VALUES
('Shelter & Sleeping Tools', 'Essential gear for providing protection from the elements and ensuring comfort during sleep, including tents, sleeping bags, mats, and tarps.'),
('Cooking Tools', 'Compact, portable cooking equipment designed for outdoor meals, such as stoves, cookware, coolers, and fire starters.'),
('Comfort & Utility Tools', 'Items designed for added convenience and comfort while camping, like foldable chairs, camping tables, water filters, and backpacks.');

/* Tool Sample Data */
INSERT INTO tool (toolName, toolDesc, categoryID, pricePerDay, toolImg)
VALUES
-- Shelter & Sleeping Tools
('Tent', 'Durable and weather-resistant tent for 2-4 people.', 1, 20.00, 'images/tent.jpg'),
('Sleeping Bag', 'Insulated sleeping bag suitable for all seasons.', 1, 8.00, 'images/sleepingbag.jpg'),
('Sleeping Mat', 'Lightweight foam mat for added sleeping comfort.', 1, 5.00, 'images/sleepingmat.jpg'),

-- Cooking Tools
('Portable Stove', 'Compact gas stove for outdoor cooking.', 2, 15.00, 'images/portableStove.jpg'),
('Cooler Box', 'Keeps food and drinks fresh during camping trips.', 2, 10.00, 'images/coolerBox.jpg'),
('Fire Starter Kit', 'Easy-to-use kit for igniting campfires.', 2, 3.00, 'images/firestarterkit.jpg'),
  
-- Comfort & Utility Tools
('Foldable Chair', 'Comfortable and portable camping chair.', 3, 7.00, 'images/foldablechair.jpg'),
('Camping Table', 'Sturdy foldable table for meals and activities.', 3, 10.00, 'images/campingtable.jpg'),
('Water Filter', 'Portable filter for purifying drinking water.', 3, 8.00, 'images/waterfilter.jpg'),

