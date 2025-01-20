-- Table structure for table `userRole`
CREATE TABLE `userRole` (
  `roleID` int PRIMARY KEY,
  `roleName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `user`
CREATE TABLE `user` (
  `userID` int PRIMARY KEY,
  `userName` varchar(100) NOT NULL,
  `userEmail` varchar(100) NOT NULL,
  `userPassword` varchar(100) NOT NULL,
  `roleID` int NOT NULL,
  FOREIGN KEY (`roleID`) REFERENCES `userRole` (`roleID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `campsite`
CREATE TABLE `campsite` (
  `campsiteID` int PRIMARY KEY,
  `campsiteName` varchar(255) NOT NULL,
  `pricePerNight` decimal(10,2) NOT NULL,
  `campDesc` varchar(225) NOT NULL,
  `campsiteImg` varchar(225) NOT NULL,
  `availabilityStatus` boolean NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `reservation`
CREATE TABLE `reservation` (
  `reservationID` int PRIMARY KEY,
  `userID` int NOT NULL,
  `campsiteID` int NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `reservationAmt` decimal(10,2) NOT NULL,
  FOREIGN KEY (`userID`) REFERENCES `user` (`userID`),
  FOREIGN KEY (`campsiteID`) REFERENCES `campsite` (`campsiteID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `groupBooking`
CREATE TABLE `groupBooking` (
  `bookingID` int PRIMARY KEY,
  `groupCategory` varchar(100) NOT NULL,
  `bookingAmt` decimal(10,2) NOT NULL,
  `reservationID` int NOT NULL,
  `costSplit` json NOT NULL, -- Stores cost split among group members
  FOREIGN KEY (`reservationID`) REFERENCES `reservation` (`reservationID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Table structure for table `tool`
CREATE TABLE `tool` (
  `toolID` int PRIMARY KEY,
  `toolName` varchar(100) NOT NULL,
  `toolDesc` varchar(225) NOT NULL,
  `toolAvailability` boolean NOT NULL,
  `toolImg` varchar(225) NOT NULL,
  `pricePerDay` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `rental`
CREATE TABLE `rental` (
  `rentalID` int PRIMARY KEY,
  `toolID` int NOT NULL,
  `userID` int NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `rentalAmt` decimal(10,2) NOT NULL,
  FOREIGN KEY (`toolID`) REFERENCES `tool` (`toolID`),
  FOREIGN KEY (`userID`) REFERENCES `user` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `guidebook`
CREATE TABLE `guidebook` (
  `guidebookID` int PRIMARY KEY,
  `guidebookURL` varchar(255) NOT NULL,
  `userID` int NOT NULL,
  FOREIGN KEY (`userID`) REFERENCES `user` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `memories`
CREATE TABLE `memories` (
  `memoriesID` int PRIMARY KEY,
  `userID` int NOT NULL,
  `memoryImg` varchar(225) NOT NULL,
  `memoryDate` date NOT NULL,
  FOREIGN KEY (`userID`) REFERENCES `user` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



-- Table structure for table `review`
CREATE TABLE `review` (
  `reviewID` int PRIMARY KEY,
  `userID` int NOT NULL,
  `rating` int CHECK (rating BETWEEN 1 AND 5),
  `campsiteID` int NOT NULL,
  `comment` text,
  `reviewDate` date NOT NULL,
  FOREIGN KEY (`userID`) REFERENCES `user` (`userID`),
  FOREIGN KEY (`campsiteID`) REFERENCES `campsite` (`campsiteID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
