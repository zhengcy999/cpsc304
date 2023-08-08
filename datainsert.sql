drop table Purchase;

drop table Vendors;

drop table Chemical_Waste_Dispose;

drop table LabManager;

drop table Involve;

drop table Lab;

drop table Use;

drop table LabMembers;

drop table Keep;

drop table Cabinet_In;

drop table Room;

drop table Equipments;

drop table Chemicals;

drop table ItemUnit;

drop table Items;

CREATE TABLE Items (
    CatalogNumber INTEGER PRIMARY KEY,
    FullName CHAR(20),
    Description CHAR(100),
    Quantity INTEGER,
    Type CHAR(20)
);

grant
select
    on Items to public;

CREATE TABLE ItemUnit (FullName CHAR(20) PRIMARY KEY, Units CHAR(20));

grant
select
    on ItemUnit to public;

CREATE TABLE Chemicals (
    CatalogNumber INTEGER PRIMARY KEY,
    ExpiryDate DATE,
    FOREIGN KEY (CatalogNumber) REFERENCES Items
);

grant
select
    on Chemicals to public;

CREATE TABLE Equipments (
    CatalogNumber INTEGER PRIMARY KEY,
    MaintenanceFrequency CHAR(20),
    FOREIGN KEY (CatalogNumber) REFERENCES Items
);

grant
select
    on Equipments to public;

CREATE TABLE Room (
    RoomNumber INTEGER,
    BuildingName char(20),
    PRIMARY KEY (RoomNumber, BuildingName)
);

grant
select
    on Room to public;

CREATE TABLE Cabinet_In (
    ShelfID INTEGER,
    RoomNumber INTEGER,
    BuildingName char(20),
    PRIMARY KEY (ShelfID, RoomNumber, BuildingName),
    FOREIGN KEY (RoomNumber, BuildingName) REFERENCES Room(RoomNumber, BuildingName)
);

grant
select
    on Cabinet_In to public;

CREATE TABLE Keep (
    ShelfID INTEGER,
    RoomNumber INTEGER,
    BuildingName CHAR(20),
    CatalogNumber INTEGER,
    UseDate DATE,
    PRIMARY KEY (ShelfID, RoomNumber, BuildingName, CatalogNumber),
    FOREIGN KEY (ShelfID, RoomNumber, BuildingName) REFERENCES Cabinet_In(ShelfID, RoomNumber, BuildingName),
    FOREIGN KEY (CatalogNumber) REFERENCES Items(CatalogNumber)
);

grant
select
    on Keep to public;

CREATE TABLE LabMembers (
    UserID char(20) PRIMARY KEY,
    Name char(20),
    Email char(50),
    Phone char(20)
);

grant
select
    on LabMembers to public;

CREATE TABLE Use (
    CatalogNumber INTEGER,
    UserID char(20),
    UseDate DATE,
    PRIMARY KEY (CatalogNumber, UserID),
    FOREIGN KEY (CatalogNumber) REFERENCES Items(CatalogNumber),
    FOREIGN KEY (UserID) REFERENCES LabMembers(UserID)
);

grant
select
    on Use to public;

CREATE TABLE Lab (
    ID INTEGER PRIMARY KEY,
    Name char(20),
    Address char(50)
);

grant
select
    on Lab to public;

CREATE TABLE Involve (
    UserID char(20),
    ID INTEGER,
    EnrollDate DATE,
    PRIMARY KEY (UserID, ID),
    FOREIGN KEY (UserID) REFERENCES LabMembers(UserID),
    FOREIGN KEY (ID) REFERENCES Lab(ID)
);

grant
select
    on Involve to public;

CREATE TABLE LabManager (
    AdminID char(20) PRIMARY KEY,
    Name char(20),
    Email char(50),
    Phone char(20),
    ID INTEGER,
    FOREIGN KEY (ID) REFERENCES Lab(ID)
);

grant
select
    on LabManager to public;

CREATE TABLE Chemical_Waste_Dispose(
    ID INTEGER PRIMARY KEY,
    Name char(20),
    Description char(200),
    AdminID char(20),
    UseDate DATE,
    FOREIGN KEY (AdminID) REFERENCES LabManager(AdminID)
);

grant
select
    on Chemical_Waste_Dispose to public;

CREATE TABLE Vendors (
    Name char(20),
    Email char(50),
    Address char(50),
    Phone char(20),
    PRIMARY KEY (Name, Address)
);

grant
select
    on Vendors to public;

CREATE TABLE Purchase (
    CatalogNumber INTEGER,
    AdminID char(20),
    Name char(20),
    Address char(50),
    PurchaseDate DATE,
    UnitPrice INTEGER,
    PRIMARY KEY (CatalogNumber, AdminID, Name, Address),
    FOREIGN KEY (CatalogNumber) REFERENCES Items(CatalogNumber),
    FOREIGN KEY (AdminID) REFERENCES LabManager(AdminID),
    FOREIGN KEY (Name, Address) REFERENCES Vendors(Name, Address) ON DELETE CASCADE
);

grant
select
    on Purchase to public;

INSERT INTO
    Items (
        CatalogNumber,
        FullName,
        Description,
        Quantity,
        Type
    )
VALUES
    (
        1001,
        'Chemical A',
        'Organic compound used for experiments',
        20,
        'Chemical'
    );

INSERT INTO
    Items (
        CatalogNumber,
        FullName,
        Description,
        Quantity,
        Type
    )
VALUES
    (
        1002,
        'Chemical B',
        'Inorganic salt for laboratory use',
        50,
        'Chemical'
    );

INSERT INTO
    Items (
        CatalogNumber,
        FullName,
        Description,
        Quantity,
        Type
    )
VALUES
    (
        1003,
        'Equipment A',
        'Microscope with high-resolution optics',
        5,
        'Equipment'
    );

INSERT INTO
    Items (
        CatalogNumber,
        FullName,
        Description,
        Quantity,
        Type
    )
VALUES
    (
        1004,
        'Equipment B',
        'Centrifuge for sample separation',
        2,
        'Equipment'
    );

INSERT INTO
    Items (
        CatalogNumber,
        FullName,
        Description,
        Quantity,
        Type
    )
VALUES
    (
        1005,
        'Glassware A',
        'Glass beakers for various volumes',
        30,
        'Equipment'
    );

INSERT INTO
    ItemUnit (FullName, Units)
VALUES
    ('Chemical A', 'grams');

INSERT INTO
    ItemUnit (FullName, Units)
VALUES
    ('Chemical B', 'grams');

INSERT INTO
    ItemUnit (FullName, Units)
VALUES
    ('Equipment A', 'units');

INSERT INTO
    ItemUnit (FullName, Units)
VALUES
    ('Equipment B', 'units');

INSERT INTO
    ItemUnit (FullName, Units)
VALUES
    ('Glassware A', 'pieces');

INSERT INTO
    Chemicals (CatalogNumber, ExpiryDate)
VALUES
    (1001, TO_DATE('2024-12-31', 'YYYY-MM-DD'));

INSERT INTO
    Chemicals (CatalogNumber, ExpiryDate)
VALUES
    (1002, TO_DATE('2023-12-31', 'YYYY-MM-DD'));

INSERT INTO
    Equipments (CatalogNumber, MaintenanceFrequency)
VALUES
    (1003, 'Monthly');

INSERT INTO
    Equipments (CatalogNumber, MaintenanceFrequency)
VALUES
    (1004, 'Quarterly');

INSERT INTO
    Equipments (CatalogNumber, MaintenanceFrequency)
VALUES
    (1005, 'Annual');

INSERT INTO
    Room (RoomNumber, BuildingName)
VALUES
    (1, 'Building A');

INSERT INTO
    Room (RoomNumber, BuildingName)
VALUES
    (2, 'Building B');

INSERT INTO
    Room (RoomNumber, BuildingName)
VALUES
    (3, 'Building C');

INSERT INTO
    Room (RoomNumber, BuildingName)
VALUES
    (4, 'Building D');

INSERT INTO
    Room (RoomNumber, BuildingName)
VALUES
    (5, 'Building E');

INSERT INTO
    Cabinet_In (ShelfID, RoomNumber, BuildingName)
VALUES
    (1, 1, 'Building A');

INSERT INTO
    Cabinet_In (ShelfID, RoomNumber, BuildingName)
VALUES
    (2, 2, 'Building B');

INSERT INTO
    Cabinet_In (ShelfID, RoomNumber, BuildingName)
VALUES
    (3, 3, 'Building C');

INSERT INTO
    Cabinet_In (ShelfID, RoomNumber, BuildingName)
VALUES
    (4, 2, 'Building B');

INSERT INTO
    Cabinet_In (ShelfID, RoomNumber, BuildingName)
VALUES
    (5, 1, 'Building A');

INSERT INTO
    Keep (
        ShelfID,
        RoomNumber,
        BuildingName,
        CatalogNumber,
        UseDate
    )
VALUES
    (
        1,
        1,
        'Building A',
        1001,
        TO_DATE('2023-05-30', 'YYYY-MM-DD')
    );

INSERT INTO
    Keep (
        ShelfID,
        RoomNumber,
        BuildingName,
        CatalogNumber,
        UseDate
    )
VALUES
    (
        2,
        2,
        'Building B',
        1002,
        TO_DATE('2023-07-31', 'YYYY-MM-DD')
    );

INSERT INTO
    LabMembers (UserID, Name, Email, Phone)
VALUES
    (
        'user1',
        'John Smith',
        'john.smith@example.com',
        '123-456-7890'
    );

INSERT INTO
    LabMembers (UserID, Name, Email, Phone)
VALUES
    (
        'user2',
        'Sam Doe',
        'sam.doe@example.com',
        '234-567-8901'
    );

INSERT INTO
    LabMembers (UserID, Name, Email, Phone)
VALUES
    (
        'user3',
        'Robert Johnson',
        'robert.johnson@example.com',
        '345-678-9012'
    );

INSERT INTO
    LabMembers (UserID, Name, Email, Phone)
VALUES
    (
        'user4',
        'Emily Wilson',
        'emily.wilson@example.com',
        '456-789-0123'
    );

INSERT INTO
    LabMembers (UserID, Name, Email, Phone)
VALUES
    (
        'user5',
        'Michael Brown',
        'michael.brown@example.com',
        '567-890-1234'
    );

INSERT INTO
    Use (CatalogNumber, UserID, UseDate)
VALUES
    (
        1001,
        'user1',
        TO_DATE('2023-01-31', 'YYYY-MM-DD')
    );

INSERT INTO
    Use (CatalogNumber, UserID, UseDate)
VALUES
    (
        1002,
        'user2',
        TO_DATE('2023-02-03', 'YYYY-MM-DD')
    );

INSERT INTO
    Use (CatalogNumber, UserID, UseDate)
VALUES
    (
        1003,
        'user3',
        TO_DATE('2023-04-30', 'YYYY-MM-DD')
    );

INSERT INTO
    Use (CatalogNumber, UserID, UseDate)
VALUES
    (
        1004,
        'user4',
        TO_DATE('2023-05-31', 'YYYY-MM-DD')
    );

INSERT INTO
    Use (CatalogNumber, UserID, UseDate)
VALUES
    (
        1005,
        'user5',
        TO_DATE('2023-03-28', 'YYYY-MM-DD')
    );

INSERT INTO
    Lab (ID, Name, Address)
VALUES
    (1, 'Lab 1', 'Building A, Floor 1');

INSERT INTO
    Lab (ID, Name, Address)
VALUES
    (2, 'Lab 2', 'Building B, Floor 2');

INSERT INTO
    Lab (ID, Name, Address)
VALUES
    (3, 'Lab 3', 'Building C, Floor 3');

INSERT INTO
    Lab (ID, Name, Address)
VALUES
    (4, 'Lab 4', 'Building D, Floor 4');

INSERT INTO
    Lab (ID, Name, Address)
VALUES
    (5, 'Lab 5', 'Building E, Floor 5');

INSERT INTO
    Involve (UserID, ID, EnrollDate)
VALUES
    ('user1', 1, TO_DATE('2022-01-01', 'YYYY-MM-DD'));

INSERT INTO
    Involve (UserID, ID, EnrollDate)
VALUES
    ('user2', 1, TO_DATE('2022-02-15', 'YYYY-MM-DD'));

INSERT INTO
    Involve (UserID, ID, EnrollDate)
VALUES
    ('user3', 2, TO_DATE('2022-03-10', 'YYYY-MM-DD'));

INSERT INTO
    Involve (UserID, ID, EnrollDate)
VALUES
    ('user4', 2, TO_DATE('2022-04-20', 'YYYY-MM-DD'));

INSERT INTO
    Involve (UserID, ID, EnrollDate)
VALUES
    ('user5', 3, TO_DATE('2022-05-05', 'YYYY-MM-DD'));

INSERT INTO
    LabManager (AdminID, Name, Email, Phone, ID)
VALUES
    (
        'admin1',
        'Jane Doe',
        'jane.doe@example.com',
        '987-654-3210',
        1
    );

INSERT INTO
    LabManager (AdminID, Name, Email, Phone, ID)
VALUES
    (
        'admin2',
        'Mark Johnson',
        'mark.johnson@example.com',
        '456-789-1230',
        2
    );

INSERT INTO
    LabManager (AdminID, Name, Email, Phone, ID)
VALUES
    (
        'admin3',
        'Emily Smith',
        'emily.smith@example.com',
        '789-123-4560',
        3
    );

INSERT INTO
    LabManager (AdminID, Name, Email, Phone, ID)
VALUES
    (
        'admin4',
        'Michael Brown',
        'michael.brown@example.com',
        '321-654-9870',
        4
    );

INSERT INTO
    LabManager (AdminID, Name, Email, Phone, ID)
VALUES
    (
        'admin5',
        'Sophia Davis',
        'sophia.davis@example.com',
        '654-321-9870',
        5
    );

INSERT INTO
    Chemical_Waste_Dispose (Name, ID, Description, AdminID, UseDate)
VALUES
    (
        'Waste A',
        1,
        'Hazardous waste from experiments',
        'admin1',
        TO_DATE('2023-06-04', 'YYYY-MM-DD')
    );

INSERT INTO
    Chemical_Waste_Dispose (Name, ID, Description, AdminID, UseDate)
VALUES
    (
        'Waste B',
        2,
        'Chemical waste for proper disposal',
        'admin2',
        TO_DATE('2023-06-05', 'YYYY-MM-DD')
    );

INSERT INTO
    Chemical_Waste_Dispose (Name, ID, Description, AdminID, UseDate)
VALUES
    (
        'Waste C',
        3,
        'Expired chemicals for safe disposal',
        'admin3',
        TO_DATE('2023-06-06', 'YYYY-MM-DD')
    );

INSERT INTO
    Chemical_Waste_Dispose (Name, ID, Description, AdminID, UseDate)
VALUES
    (
        'Waste D',
        4,
        'Biohazard waste from biological experiments',
        'admin4',
        TO_DATE('2023-06-07', 'YYYY-MM-DD')
    );

INSERT INTO
    Chemical_Waste_Dispose (Name, ID, Description, AdminID, UseDate)
VALUES
    (
        'Waste E',
        5,
        'Toxic waste for specialized treatment',
        'admin5',
        TO_DATE('2023-06-08', 'YYYY-MM-DD')
    );

INSERT INTO
    Vendors (Name, Email, Address, Phone)
VALUES
    (
        'QIAGEN',
        'vendorA@example.com',
        '123 Main Street',
        '111-111-1111'
    );

INSERT INTO
    Vendors (Name, Email, Address, Phone)
VALUES
    (
        'SIGMA',
        'vendorB@example.com',
        '456 Elm Street',
        '222-222-2222'
    );

INSERT INTO
    Vendors (Name, Email, Address, Phone)
VALUES
    (
        'VWR',
        'vendorC@example.com',
        '789 Oak Street',
        '333-333-3333'
    );

INSERT INTO
    Vendors (Name, Email, Address, Phone)
VALUES
    (
        'INVITROGEN',
        'vendorD@example.com',
        '321 Pine Street',
        '444-444-4444'
    );

INSERT INTO
    Purchase (
        CatalogNumber,
        AdminID,
        Name,
        Address,
        PurchaseDate,
        UnitPrice
    )
VALUES
    (
        1001,
        'admin1',
        'QIAGEN',
        '123 Main Street',
        TO_DATE('2023-06-01', 'YYYY-MM-DD'),
        10
    );

INSERT INTO
    Purchase (
        CatalogNumber,
        AdminID,
        Name,
        Address,
        PurchaseDate,
        UnitPrice
    )
VALUES
    (
        1001,
        'admin2',
        'SIGMA',
        '456 Elm Street',
        TO_DATE('2023-06-02', 'YYYY-MM-DD'),
        15
    );

INSERT INTO
    Purchase (
        CatalogNumber,
        AdminID,
        Name,
        Address,
        PurchaseDate,
        UnitPrice
    )
VALUES
    (
        1002,
        'admin3',
        'QIAGEN',
        '123 Main Street',
        TO_DATE('2023-06-03', 'YYYY-MM-DD'),
        20
    );

INSERT INTO
    Purchase (
        CatalogNumber,
        AdminID,
        Name,
        Address,
        PurchaseDate,
        UnitPrice
    )
VALUES
    (
        1002,
        'admin5',
        'SIGMA',
        '456 Elm Street',
        TO_DATE('2023-06-04', 'YYYY-MM-DD'),
        25
    );

INSERT INTO
    Purchase (
        CatalogNumber,
        AdminID,
        Name,
        Address,
        PurchaseDate,
        UnitPrice
    )
VALUES
    (
        1003,
        'admin4',
        'QIAGEN',
        '123 Main Street',
        TO_DATE('2023-06-05', 'YYYY-MM-DD'),
        30
    );

INSERT INTO
    Purchase (
        CatalogNumber,
        AdminID,
        Name,
        Address,
        PurchaseDate,
        UnitPrice
    )
VALUES
    (
        1004,
        'admin4',
        'QIAGEN',
        '123 Main Street',
        TO_DATE('2023-06-01', 'YYYY-MM-DD'),
        10
    );

INSERT INTO
    Purchase (
        CatalogNumber,
        AdminID,
        Name,
        Address,
        PurchaseDate,
        UnitPrice
    )
VALUES
    (
        1004,
        'admin5',
        'INVITROGEN',
        '321 Pine Street',
        TO_DATE('2023-06-02', 'YYYY-MM-DD'),
        15
    );

INSERT INTO
    Purchase (
        CatalogNumber,
        AdminID,
        Name,
        Address,
        PurchaseDate,
        UnitPrice
    )
VALUES
    (
        1005,
        'admin1',
        'QIAGEN',
        '123 Main Street',
        TO_DATE('2023-06-20', 'YYYY-MM-DD'),
        20
    );

INSERT INTO
    Purchase (
        CatalogNumber,
        AdminID,
        Name,
        Address,
        PurchaseDate,
        UnitPrice
    )
VALUES
    (
        1005,
        'admin2',
        'INVITROGEN',
        '321 Pine Street',
        TO_DATE('2023-06-20', 'YYYY-MM-DD'),
        25
    );

INSERT INTO
    Purchase (
        CatalogNumber,
        AdminID,
        Name,
        Address,
        PurchaseDate,
        UnitPrice
    )
VALUES
    (
        1005,
        'admin3',
        'VWR',
        '789 Oak Street',
        TO_DATE('2023-06-20', 'YYYY-MM-DD'),
        30
    );

INSERT INTO
    Purchase (
        CatalogNumber,
        AdminID,
        Name,
        Address,
        PurchaseDate,
        UnitPrice
    )
VALUES
    (
        1005,
        'admin1',
        'SIGMA',
        '456 Elm Street',
        TO_DATE('2023-06-20', 'YYYY-MM-DD'),
        20
    );