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

-- updated by Afiqah
-- Table structure for table `zone`
CREATE TABLE zone (
    zoneID VARCHAR(5) PRIMARY KEY,
    zoneDesc TEXT NOT NULL,        
    zoneImg VARCHAR(255)          
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- updated by Afiqah
-- Table structure for table `campsite`
CREATE TABLE campsite (
    campsiteID VARCHAR(10) PRIMARY KEY,       
    pricePerNight DECIMAL(10, 2) NOT NULL,   
    zoneID VARCHAR(5),                       
    FOREIGN KEY (zoneID) REFERENCES zone(zoneID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- updated by Afiqah
-- Table structure for table `toolCategory`
CREATE TABLE `toolCategory` (
  `categoryID` int PRIMARY KEY,
  `categoryName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- updated by Julia
-- Table structure for table `tool`
CREATE TABLE `tool` (
  `toolID` int PRIMARY KEY,
  `toolName` varchar(100) NOT NULL,
  `toolDesc` varchar(225) NOT NULL,
  `toolImg` varchar(225) NOT NULL,
  `categoryID` int NOT NULL,
  `pricePerDay` decimal(10,2) NOT NULL,
  FOREIGN KEY (`categoryID`) REFERENCES `toolCategory` (`categoryID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- updated by Afiqah
-- Table structure for table `rental`
CREATE TABLE `rental` (
  `rentalID` int PRIMARY KEY,
  `toolID` int NOT NULL,
  `campsiteID` VARCHAR(10) NOT NULL,
  `userID` int NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `rentalAmt` decimal(10,2) NOT NULL,
  `rentalStatus` ENUM('Pending', 'Completed', 'Cancelled') NOT NULL DEFAULT 'Pending',
  FOREIGN KEY (`campsiteID`) REFERENCES `campsite` (`campsiteID`),
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
  `rating` int,
  `campsiteID` VARCHAR(10) NOT NULL,
  `comment` text,
  `reviewDate` date NOT NULL,
  FOREIGN KEY (`userID`) REFERENCES `user` (`userID`),
  FOREIGN KEY (`campsiteID`) REFERENCES `campsite` (`campsiteID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
