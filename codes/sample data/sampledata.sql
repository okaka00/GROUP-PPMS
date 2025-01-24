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
