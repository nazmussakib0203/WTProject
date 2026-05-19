-- Users table
CREATE TABLE `users` (
  `ID` int(20) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Role` varchar(30) NOT NULL DEFAULT 'customer',
  `ProfilePicture` varchar(250) DEFAULT NULL,
  `Address` varchar(200) DEFAULT NULL,
  `Phone` varchar(20) DEFAULT NULL,
  `CreatedAt` date NOT NULL,
  PRIMARY KEY (`ID`)
);

-- Categories table
CREATE TABLE `categories` (
  `ID` int(20) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
);

-- Books table
CREATE TABLE `books` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `Title` varchar(100) NOT NULL,
  `Author` varchar(100) NOT NULL,
  `Description` varchar(200) NOT NULL,
  `Price` decimal(10,2) NOT NULL,
  `CategoryID` int(20) NOT NULL,
  `Image` varchar(100) DEFAULT NULL,
  `Stock` int(10) NOT NULL DEFAULT 0,
  `CreatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  FOREIGN KEY (`CategoryID`) REFERENCES `categories`(`ID`)
);

-- Cart table
CREATE TABLE `cart` (
  `ID` int(20) NOT NULL AUTO_INCREMENT,
  `UserID` int(20) NOT NULL,
  `BookID` int(20) NOT NULL,
  `Quantity` int(10) NOT NULL DEFAULT 1,
  `AddedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  FOREIGN KEY (`UserID`) REFERENCES `users`(`ID`),
  FOREIGN KEY (`BookID`) REFERENCES `books`(`ID`)
);

-- Orders table
CREATE TABLE `orders` (
  `ID` int(20) NOT NULL AUTO_INCREMENT,
  `UserID` int(20) NOT NULL,
  `TotalAmount` decimal(10,2) NOT NULL,
  `Status` varchar(20) NOT NULL DEFAULT 'pending',
  `PaymentMethod` varchar(20) NOT NULL,
  `OrderDate` date NOT NULL,
  PRIMARY KEY (`ID`),
  FOREIGN KEY (`UserID`) REFERENCES `users`(`ID`)
);

-- Order items table
CREATE TABLE `order_items` (
  `ID` int(20) NOT NULL AUTO_INCREMENT,
  `OrderID` int(20) NOT NULL,
  `BookID` int(20) NOT NULL,
  `Quantity` int(10) NOT NULL,
  `UnitPrice` decimal(10,2) NOT NULL,
  PRIMARY KEY (`ID`),
  FOREIGN KEY (`OrderID`) REFERENCES `orders`(`ID`),
  FOREIGN KEY (`BookID`) REFERENCES `books`(`ID`)
);

-- Payments table
CREATE TABLE `payments` (
  `ID` int(20) NOT NULL AUTO_INCREMENT,
  `OrderID` int(20) NOT NULL,
  `Amount` decimal(10,2) NOT NULL,
  `PaymentMethod` varchar(20) NOT NULL,
  `TransactionID` varchar(100) DEFAULT NULL,
  `PaymentDate` date NOT NULL,
  PRIMARY KEY (`ID`),
  FOREIGN KEY (`OrderID`) REFERENCES `orders`(`ID`)
);
