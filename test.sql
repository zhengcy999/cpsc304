drop table Registers;
drop table TeachClass;
drop table WorksFor;
drop table ManageEquipment;
drop table Receptionist;
drop table Janitor;
drop table Instructor;
drop table Employee;
drop table IceRink;
drop table TennisCourt;
drop table SwimmingPool;
drop table Contains;
drop table Facility;
drop table Rents;
drop table HasEquipment;
drop table Reserves;
drop table SportsCenter;
drop table Reservation;
drop table FamilyMemberAddedTo;
drop table Member;


CREATE TABLE Member(
    MemberID CHAR(5) PRIMARY KEY,
    Address VARCHAR(80),
    PhoneNumber CHAR(10),
    MFirstName CHAR(30) NOT NULL,
    MLastName CHAR(30) NOT NULL, 
    MBirthDate DATE,
    MEmail CHAR(50) UNIQUE
);

CREATE TABLE FamilyMemberAddedTo(
    MemberID CHAR(5),
    FMFirstName CHAR(30) NOT NULL,
    FMLastName CHAR(30) NOT NULL,
    FMBirthDate DATE,
    PRIMARY KEY (MemberID, FMLastName, FMFirstName),
    FOREIGN KEY (MemberID) REFERENCES Member ON DELETE CASCADE
);

CREATE TABLE SportsCenter(
    SportsCenterLocation VARCHAR(30) PRIMARY KEY ,
    ContactNumber CHAR(10), 
    Hours CHAR(20),
    PRICE REAL, 
    Address VARCHAR(80), 
    Capacity INTEGER
);

CREATE TABLE Reservation(
    ReservationID CHAR(5) PRIMARY KEY,
    Time CHAR(20),
    ReservationDate DATE
);

CREATE TABLE Reserves( 
    MemberID CHAR(5), 
    SportsCenterLocation VARCHAR(30), 
    ReservationID CHAR(5),
    PRIMARY KEY (MemberID, SportsCenterLocation, ReservationID), 
    FOREIGN KEY (MemberID) REFERENCES Member ON DELETE CASCADE,
        -- ON UPDATE CASCADE,
    FOREIGN KEY (SportsCenterLocation) REFERENCES SportsCenter ON DELETE CASCADE,
        -- ON UPDATE CASCADE,
    FOREIGN KEY (ReservationID) REFERENCES Reservation ON DELETE CASCADE
        -- ON UPDATE CASCADE
);

create table HasEquipment(
	HasEquipmentID CHAR(5),
	SportsCenterLocation VARCHAR(30),
	HasEquipmentType VARCHAR(20),
	PRIMARY KEY (HasEquipmentID),
	FOREIGN KEY (SportsCenterLocation) REFERENCES SportsCenter ON DELETE CASCADE
        -- ON UPDATE CASCADE
);

CREATE TABLE Rents(
    ReservationID CHAR(5),
    HasEquipmentID CHAR(5),
    PRIMARY KEY (ReservationID, HasEquipmentID), -- Equipment?
    FOREIGN KEY (ReservationID) REFERENCES Reservation
        ON DELETE CASCADE,
    FOREIGN KEY (HasEquipmentID) REFERENCES HasEquipment -- Equipment/HasEquipment/ManageEquipment?
        ON DELETE CASCADE 
);

CREATE TABLE Facility(
	FacilityID CHAR(5) PRIMARY KEY,
	Sqft INT
);

CREATE TABLE Contains(
	SportsCenterLocation VARCHAR(30),
	FacilityID CHAR(5),
	PRIMARY KEY (SportsCenterLocation, facilityID),
	FOREIGN KEY (SportsCenterLocation) REFERENCES SportsCenter ON DELETE CASCADE,
		-- ON UPDATE CASCADE
	FOREIGN KEY (FacilityID) REFERENCES Facility ON DELETE CASCADE
		-- ON UPDATE CASCADE
);

CREATE TABLE SwimmingPool(
	FacilityID CHAR(5),
	WaterLevel VARCHAR(5),
	PRIMARY KEY (FacilityID),
	FOREIGN KEY (FacilityID) REFERENCES Facility ON DELETE CASCADE
);

CREATE TABLE TennisCourt(
	FacilityID CHAR(5),
	CourtType VARCHAR(10),
	PRIMARY KEY (FacilityID),
	FOREIGN KEY (FacilityID) REFERENCES Facility ON DELETE CASCADE
);

CREATE TABLE IceRink(
	FacilityID CHAR(5),
	Temperature VARCHAR(5),
	PRIMARY KEY (FacilityID),
	FOREIGN KEY (FacilityID) REFERENCES Facility ON DELETE CASCADE
);

CREATE TABLE Employee(
	EmployeeID CHAR(5) PRIMARY KEY,
	FirstDayOfWork DATE,
	EFirstName VARCHAR(30) NOT NULL,
	ElastName VARCHAR(30) NOT NULL,
	HourlyRate INT,
	Eemail VARCHAR(50) UNIQUE
);

CREATE TABLE Instructor(
	EmployeeID CHAR(5),
	TeachingLevel VARCHAR(15),
	PRIMARY KEY (EmployeeID),
	FOREIGN KEY (EmployeeID) REFERENCES Employee ON DELETE CASCADE
);

CREATE TABLE Janitor(
	EmployeeID CHAR(5),
	AssignedArea varchar(10),
	PRIMARY KEY (EmployeeID),
	FOREIGN KEY (EmployeeID) REFERENCES Employee ON DELETE CASCADE
);

CREATE TABLE Receptionist(
	EmployeeID CHAR(5),
	WorkType CHAR(9),
	PRIMARY KEY (EmployeeID),
	FOREIGN KEY (EmployeeID) REFERENCES Employee ON DELETE CASCADE
);

CREATE TABLE ManageEquipment (
	EquipmentID CHAR(5),
	EmployeeJanitorID CHAR(5),
	EuqipmentType VARCHAR(20),
	PRIMARY KEY (EquipmentID),
	FOREIGN KEY (EmployeeJanitorID) REFERENCES Janitor ON DELETE CASCADE
);

CREATE TABLE WorksFor (
	SportsCenterLocation VARCHAR(30),
	EmployeeID CHAR(5),
	PRIMARY KEY (SportsCenterLocation, EmployeeID),
	FOREIGN KEY (SportsCenterLocation) REFERENCES SportsCenter ON DELETE CASCADE,
		-- ON UPDATE CASCADE
	FOREIGN KEY (EmployeeID) REFERENCES Employee ON DELETE CASCADE
);

CREATE TABLE TeachClass (
	EmployeeInstructorID CHAR(5),
	SectionNumber INT,
	ClassName VARCHAR(20),
	StartDate DATE,
	EndDate DATE,
	PRIMARY KEY (SectionNumber, ClassName, StartDate, EndDate),
	FOREIGN KEY (EmployeeInstructorID) REFERENCES Instructor ON DELETE CASCADE
		-- ON UPDATE CASCADE
);

CREATE TABLE Registers (
	MemberID CHAR(5),
	SectionNumber INT,
	ClassName VARCHAR(20),
	StartDate DATE,
	EndDate DATE,
	cost VARCHAR(5),
	PRIMARY KEY (MemberID, SectionNumber, ClassName, StartDate, EndDate),
	FOREIGN KEY (MemberID) REFERENCES member ON DELETE CASCADE,
		-- ON UPDATE CASCADE
	FOREIGN KEY (SectionNumber, ClassName, StartDate, EndDate) REFERENCES TeachClass ON DELETE CASCADE
		-- ON UPDATE CASCADE
);


-- Member
INSERT INTO Member
VALUES('M0001', '0000 W 1th ave, Vancouver', '0000000000', 'Michael', 'Jordan', 
		TO_DATE('1963/02/17', 'yyyy/mm/dd'), 'jordan.michael@gmail.com');

INSERT INTO Member
VALUES('M0002', '1111 W 2th ave, Vancouver', '1111111111', 'Lionel', 'Messi', 
		TO_DATE('1987/06/24','yyyy/mm/dd'), 'messi.lionel@gmail.com');

INSERT INTO Member
VALUES('M0003', '2222 W 3th ave, Vancouver', '2222222222', 'Seri', 'Park', 
		TO_DATE('1977/09/28','yyyy/mm/dd'), 'prak.seri@gmail.com');	

INSERT INTO Member
VALUES('M0004', '3333 W 4th ave, Vancouver', '3333333333', 'Kathleen', 'Ledecky', 
		TO_DATE('1997/03/17','yyyy/mm/dd'), 'ledecky.kethleen@gmail.com');

INSERT INTO Member
VALUES('M0005', '4444 W 5th ave, Vancouver', '4444444444', 'Conner', 'McDavid', 
		TO_DATE('1997/01/13','yyyy/mm/dd'), 'mcdavid.conner@gmail.com');	 	

-- FamiliyMemberAddedTo
INSERT INTO FamilyMemberAddedTo
VALUES('M0001', 'Marcus', 'Jordan', TO_DATE('1983/04/15','yyyy/mm/dd'));

INSERT INTO FamilyMemberAddedTo
VALUES('M0001', 'Jasmine', 'Jordan', TO_DATE('1986/01/21','yyyy/mm/dd'));

INSERT INTO FamilyMemberAddedTo
VALUES('M0002', 'Mateo', 'Messi', TO_DATE('2015/09/11','yyyy/mm/dd'));

INSERT INTO FamilyMemberAddedTo
VALUES('M0004', 'Michael', 'Ledecky', TO_DATE('1994/05/09','yyyy/mm/dd'));

INSERT INTO FamilyMemberAddedTo
VALUES('M0005', 'Brian', 'McDavid', TO_DATE('1958/04/04','yyyy/mm/dd'));

-- SportsCenter
INSERT INTO SportsCenter
VALUES('UBC', '1234567890', '6 AM - 5 PM', '50', '6080 Student Union Blvd, Vancouver', '230');

INSERT INTO SportsCenter
VALUES('Kitsilano', '2345678901', '9 AM - 6 PM', '50', '2305 Cornwall Ave, Vancouver', '210');

INSERT INTO SportsCenter
VALUES('South Granville', '3456789012', '9 AM - 6 PM', '50', '1305 W 12th Ave, Vancouver', '110');

INSERT INTO SportsCenter
VALUES('Richmond', '4567890123', '9 AM - 6 PM', '50', '7191 Granville Ave, Richmond', '360');

INSERT INTO SportsCenter
VALUES('Sunset', '5678901234', '8 AM - 10 PM', '50', '5397 Victoria Dr, Vancouver', '70');

-- Reservation
INSERT INTO Reservation
VALUES('Rsv01', '1 PM - 2 PM', TO_DATE('2023/07/26','yyyy/mm/dd'));

INSERT INTO Reservation
VALUES('Rsv02', '1 PM - 2 PM', TO_DATE('2023/06/15','yyyy/mm/dd'));

INSERT INTO Reservation
VALUES('Rsv03', '10 PM - 11 PM', TO_DATE('2023/06/15','yyyy/mm/dd'));

INSERT INTO Reservation
VALUES('Rsv04', '5 PM - 6 PM', TO_DATE('2023/02/01','yyyy/mm/dd'));

INSERT INTO Reservation
VALUES('Rsv05', '2 PM - 3 PM', TO_DATE('2023/07/24','yyyy/mm/dd'));

-- Reserves
INSERT INTO Reserves 
VALUES ('M0001', 'UBC', 'Rsv01');

INSERT INTO Reserves 
VALUES ('M0002', 'UBC', 'Rsv02');

INSERT INTO Reserves 
VALUES ('M0003', 'Kitsilano', 'Rsv03');

INSERT INTO Reserves 
VALUES ('M0004', 'South Granville', 'Rsv04');

INSERT INTO Reserves 
VALUES ('M0005', 'Richmond', 'Rsv05');

-- Facility
INSERT INTO Facility VALUES('SW001', '5000');

INSERT INTO Facility VALUES('SW002', '6700');

INSERT INTO Facility VALUES('SW003', '5000');

INSERT INTO Facility VALUES('SW004', '6700');

INSERT INTO Facility VALUES('SW005', '6700');

INSERT INTO Facility VALUES('TC001', '4800');

INSERT INTO Facility VALUES('TC002', '4800');

INSERT INTO Facility VALUES('TC003', '4800');

INSERT INTO Facility VALUES('TC004', '4800');

INSERT INTO Facility VALUES('TC005', '4800');

INSERT INTO Facility VALUES('IR001', '3000');

INSERT INTO Facility VALUES('IR002', '3000');

INSERT INTO Facility VALUES('IR003', '3000');

INSERT INTO Facility VALUES('IR004', '3000');

INSERT INTO Facility VALUES('IR005', '3000');

INSERT INTO Facility VALUES('BK001', '2000');

-- SwimmingPool
INSERT INTO SwimmingPool VALUES('SW001', '1.2m');

INSERT INTO SwimmingPool VALUES('SW002', '3m');

INSERT INTO SwimmingPool VALUES('SW003', '5m');

INSERT INTO SwimmingPool VALUES('SW004', '1.2m');

INSERT INTO SwimmingPool VALUES('SW005', '2.5m');

-- TennisCourt
INSERT INTO TennisCourt VALUES('TC001', 'Indoor');

INSERT INTO TennisCourt VALUES('TC002', 'Indoor');

INSERT INTO TennisCourt VALUES('TC003', 'Outdoor');

INSERT INTO TennisCourt VALUES('TC004', 'Indoor');

INSERT INTO TennisCourt VALUES('TC005', 'Outdoor');

-- IceRink
INSERT INTO IceRink VALUES('IR001', '25F');

INSERT INTO IceRink VALUES('IR002', '22F');

INSERT INTO IceRink VALUES('IR003', '24F');

INSERT INTO IceRink VALUES('IR004', '20F');

INSERT INTO IceRink VALUES('IR005', '22F');

-- CONTAINS
INSERT INTO CONTAINS VALUES('UBC', 'SW001');

INSERT INTO CONTAINS VALUES('Kitsilano', 'SW002');

INSERT INTO CONTAINS VALUES('South Granville', 'TC001');

INSERT INTO CONTAINS VALUES('Richmond', 'IR001');

INSERT INTO CONTAINS VALUES('Sunset', 'BK001');

-- Employee 
INSERT INTO Employee 
VALUES('I0001', TO_DATE('2003/06/13','yyyy/mm/dd'), 'George', 'Gittu', '50', 'gittu.george@gmail.com');

INSERT INTO Employee 
VALUES('I0002', TO_DATE('2023/03/01','yyyy/mm/dd'), 'Shirley', 'Zhang', '11', 'zhang.shirley@gmail.com');

INSERT INTO Employee 
VALUES('I0003', TO_DATE('2022/01/11','yyyy/mm/dd'), 'Alice', 'Kim', '40', 'alice.kim@gmail.com');

INSERT INTO Employee 
VALUES('I0004', TO_DATE('2021/12/17','yyyy/mm/dd'), 'Youjung', 'Kim', '17', 'kim.youjung@gmail.com');

INSERT INTO Employee 
VALUES('I0005', TO_DATE('2023/05/07','yyyy/mm/dd'), 'Thomas', 'Simpson', '31', 'thomas.simpson@gmail.com');

INSERT INTO Employee 
VALUES('J0001', TO_DATE('2021/02/23','yyyy/mm/dd'), 'Danny', 'Cho', '21', 'danny.cho@gmail.com');

INSERT INTO Employee 
VALUES('J0002', TO_DATE('2021/05/12','yyyy/mm/dd'), 'David', 'Doe', '55', 'david.doe@gmail.com');

INSERT INTO Employee 
VALUES('J0003', TO_DATE('2021/12/16','yyyy/mm/dd'), 'Lawrence', 'Jennifer', '62', 'lawrence.jennifer@gmail.com');

INSERT INTO Employee 
VALUES('J0004', TO_DATE('2021/02/18','yyyy/mm/dd'), 'Brad', 'Cooper', '38', 'bard.cooper@gmail.com');

INSERT INTO Employee 
VALUES('J0005', TO_DATE('2021/06/11','yyyy/mm/dd'), 'Benny', 'Thompson', '22', 'benny.thompson@gmail.com');

INSERT INTO Employee 
VALUES('R0001', TO_DATE('2012/03/03','yyyy/mm/dd'), 'Minkyung', 'Yun', '25', 'yun.minkyung@gmail.com');

INSERT INTO Employee 
VALUES('R0002', TO_DATE('2017/06/13','yyyy/mm/dd'), 'Alex', 'Tran', '26', 'alex.tran@gmail.com');

INSERT INTO Employee 
VALUES('R0003', TO_DATE('2015/09/23','yyyy/mm/dd'), 'Bryan', 'Nichole', '36', 'bryan.nichole@gmail.com');

INSERT INTO Employee 
VALUES('R0004', TO_DATE('2016/10/14','yyyy/mm/dd'), 'Chloe', 'Park', '17', 'chloe.park@gmail.com');

INSERT INTO Employee 
VALUES('R0005', TO_DATE('2020/12/31','yyyy/mm/dd'), 'Johnny', 'Lee', '49', 'johnny.lee@gmail.com');

INSERT INTO Employee 
VALUES('LG001', TO_DATE('2016/08/02','yyyy/mm/dd'), 'Chuyi', 'Zheng', '20', 'chuyi.zheng@gmail.com');


-- Instructor
INSERT INTO Instructor VALUES('I0001', 'Advanced');

INSERT INTO Instructor VALUES('I0002', 'Advanced');

INSERT INTO Instructor VALUES('I0003', 'Intermediate');

INSERT INTO Instructor VALUES('I0004', 'Intermediate');

INSERT INTO Instructor VALUES('I0005', 'Elementary');

-- Janitor
INSERT INTO Janitor VALUES('J0001', 'Floor 1');

INSERT INTO Janitor VALUES('J0002', 'Floor 2');

INSERT INTO Janitor VALUES('J0003', 'Floor 3');

INSERT INTO Janitor VALUES('J0004', 'West');

INSERT INTO Janitor VALUES('J0005', 'East');

-- Receptionist
INSERT INTO Receptionist VALUES('R0001', 'Full-Time');

INSERT INTO Receptionist VALUES('R0002', 'Full-Time');

INSERT INTO Receptionist VALUES('R0003', 'Part-Time');

INSERT INTO Receptionist VALUES('R0004', 'Part-Time');

INSERT INTO Receptionist VALUES('R0005', 'Part-Time');

-- HasEquipment
INSERT INTO HasEquipment VALUES('E0001', 'UBC', 'Swimming Goggles');

INSERT INTO HasEquipment VALUES('E0002', 'Kitsilano', 'Helmet');

INSERT INTO HasEquipment VALUES('E0003', 'South Granville', 'Skates');

INSERT INTO HasEquipment VALUES('E0004', 'Richmond', 'Racket');

INSERT INTO HasEquipment VALUES('E0005', 'Sunset', 'Tennis Ball');

-- ManageEquipment
INSERT INTO ManageEquipment VALUES('E0001', 'J0001', 'Swimming Goggles');

INSERT INTO ManageEquipment VALUES('E0002', 'J0002', 'Helmet');

INSERT INTO ManageEquipment VALUES('E0003', 'J0003', 'Skates');

INSERT INTO ManageEquipment VALUES('E0004', 'J0004', 'Racket');

INSERT INTO ManageEquipment VALUES('E0005', 'J0005', 'Tennis Ball');

-- Rents
INSERT INTO Rents VALUES('Rsv01', 'E0001');

INSERT INTO Rents VALUES('Rsv02', 'E0002');

INSERT INTO Rents VALUES('Rsv03', 'E0003');

INSERT INTO Rents VALUES('Rsv04', 'E0004');

INSERT INTO Rents VALUES('Rsv05', 'E0005');

-- WorksFor
INSERT INTO WorksFor VALUES('UBC', 'I0001');

INSERT INTO WorksFor VALUES('Kitsilano', 'I0002');

INSERT INTO WorksFor VALUES('South Granville', 'J0001');

INSERT INTO WorksFor VALUES('Richmond', 'R0001');

INSERT INTO WorksFor VALUES('Sunset', 'LG001');

-- TeachClass
INSERT INTO TeachClass 
VALUES('I0001', '100', 'Beginner', TO_DATE('2023/08/10','yyyy/mm/dd'), TO_DATE('2023/09/09','yyyy/mm/dd'));

INSERT INTO TeachClass 
VALUES('I0002', '200', 'Beginner', TO_DATE('2023/07/10','yyyy/mm/dd'), TO_DATE('2023/08/09','yyyy/mm/dd'));

INSERT INTO TeachClass 
VALUES('I0003', '300', 'Intermediate', TO_DATE('2023/06/01','yyyy/mm/dd'), TO_DATE('2023/09/30','yyyy/mm/dd'));

INSERT INTO TeachClass 
VALUES('I0004', '400', 'Intermediate', TO_DATE('2023/06/01','yyyy/mm/dd'), TO_DATE('2023/09/30','yyyy/mm/dd'));

INSERT INTO TeachClass 
VALUES('I0005', '500', 'Advanced', TO_DATE('2023/08/10','yyyy/mm/dd'), TO_DATE('2023/09/09','yyyy/mm/dd'));

-- Registers
INSERT INTO Registers
VALUES('M0001', '100', 'Beginner', TO_DATE('2023/08/10','yyyy/mm/dd'), TO_DATE('2023/09/09','yyyy/mm/dd'), 100);

INSERT INTO Registers
VALUES('M0002', '200', 'Beginner', TO_DATE('2023/07/10','yyyy/mm/dd'), TO_DATE('2023/08/09','yyyy/mm/dd'), 100);

INSERT INTO Registers
VALUES('M0003', '300', 'Intermediate', TO_DATE('2023/06/01','yyyy/mm/dd'), TO_DATE('2023/09/30','yyyy/mm/dd'), 400);

INSERT INTO Registers
VALUES('M0004', '400', 'Intermediate', TO_DATE('2023/06/01','yyyy/mm/dd'), TO_DATE('2023/09/30','yyyy/mm/dd'), 400);

INSERT INTO Registers
VALUES('M0005', '500', 'Advanced', TO_DATE('2023/08/10','yyyy/mm/dd'), TO_DATE('2023/09/09','yyyy/mm/dd'), 150);