-- tables
-- Table: client
CREATE TABLE client (
    client_id INT NOT NULL AUTO_INCREMENT,
    email VARCHAR(30) NOT NULL UNIQUE,
    password VARCHAR(30) NOT NULL,
    first_name VARCHAR(30) NOT NULL,
    last_name VARCHAR(30) NOT NULL,
    patronymic VARCHAR(30) NOT NULL,
    birthday date NOT NULL CHECK (birthday < CURRENT_DATE),
    phone VARCHAR(12) NOT NULL,
    CONSTRAINT client_pk PRIMARY KEY (client_id)
);

DELIMITER //
    CREATE TRIGGER birthday_check BEFORE 
    INSERT ON client 
    FOR EACH ROW 
    BEGIN 
        IF New.birthday > curdate() THEN 
            signal sqlstate '45000' set message_text = 'My Error Message';
        END IF;          
    END //
DELIMITER ;


-- Table: client_service
CREATE TABLE client_service (
    id INT NOT NULL AUTO_INCREMENT,
    client_id INT NOT NULL,
    process_id INT NOT NULL,
    service_id INT NOT NULL,
    status_id INT NOT NULL,
    shed_empl_id INT NOT NULL,
    comment VARCHAR(100) NULL,
    CONSTRAINT client_service_pk PRIMARY KEY (id)
);

-- Table: document
CREATE TABLE document (
    doc_id INT NOT NULL AUTO_INCREMENT,
    date_doc date NOT NULL,
    type_id INT NOT NULL,
    client_service_id INT NOT NULL,
    CONSTRAINT document_pk PRIMARY KEY (doc_id)
);

-- Table: employee
CREATE TABLE employee (
    emp_id INT NOT NULL AUTO_INCREMENT,
    password VARCHAR(30) NOT NULL,
    name_emp VARCHAR(90) NOT NULL,
    login VARCHAR(40) NOT NULL UNIQUE,
    phone VARCHAR(12) NOT NULL,
    job_id INT NOT NULL,
    CONSTRAINT employee_pk PRIMARY KEY (emp_id)
);

-- Table: job
CREATE TABLE job (
    job_id INT NOT NULL AUTO_INCREMENT,
    name_job VARCHAR(100) NOT NULL,
    CONSTRAINT job_pk PRIMARY KEY (job_id)
);

-- Table: process
CREATE TABLE process (
    process_id INT NOT NULL AUTO_INCREMENT,
    name_proc VARCHAR(100) NOT NULL,
    CONSTRAINT process_pk PRIMARY KEY (process_id)
);

-- Table: review
CREATE TABLE review (
    review_id INT NOT NULL AUTO_INCREMENT,
    rate INT NOT NULL,
    content VARCHAR(200) NOT NULL,
    client_id INT NOT NULL,
    day date NOT NULL CHECK (day <= CURRENT_DATE),
    CONSTRAINT review_pk PRIMARY KEY (review_id)
);

-- Table: service
CREATE TABLE service (
    id INT NOT NULL AUTO_INCREMENT,
    name_serv VARCHAR(150) NOT NULL,
    tariff VARCHAR(200) NOT NULL,
    payment_UPTH VARCHAR(200) NOT NULL,
    CONSTRAINT service_pk PRIMARY KEY (id)
);

-- Table: shed_empl
CREATE TABLE shed_empl (
    shed_id INT NOT NULL AUTO_INCREMENT,
    emp_id INT NOT NULL,
    day date NOT NULL,
    is_free BOOLEAN NOT NULL DEFAULT true,
    CONSTRAINT shed_empl_pk PRIMARY KEY (shed_id)
);

-- Table: status
CREATE TABLE status (
    status_id INT NOT NULL AUTO_INCREMENT,
    name_st VARCHAR(15) NOT NULL,
    CONSTRAINT status_pk PRIMARY KEY (status_id)
);

-- Table: type_doc
CREATE TABLE type_doc (
    type_id INT NOT NULL AUTO_INCREMENT,
    type VARCHAR(100) NOT NULL,
    CONSTRAINT type_doc_pk PRIMARY KEY (type_id)
);

-- foreign keys
-- Reference: client_service_service (table: client_service)
ALTER TABLE client_service ADD CONSTRAINT client_service_service FOREIGN KEY client_service_service (service_id)
    REFERENCES service (id)
    ON DELETE CASCADE
    ON UPDATE CASCADE;

-- Reference: client_service_shed_empl (table: client_service)
ALTER TABLE client_service ADD CONSTRAINT client_service_shed_empl FOREIGN KEY client_service_shed_empl (shed_empl_id)
    REFERENCES shed_empl (shed_id)
    ON DELETE CASCADE
    ON UPDATE CASCADE;

-- Reference: client_service_status (table: client_service)
ALTER TABLE client_service ADD CONSTRAINT client_service_status FOREIGN KEY client_service_status (status_id)
    REFERENCES status (status_id)
    ON DELETE CASCADE
    ON UPDATE CASCADE;

-- Reference: document_client_service (table: document)
ALTER TABLE document ADD CONSTRAINT document_client_service FOREIGN KEY document_client_service (client_service_id)
    REFERENCES client_service (id)
    ON DELETE CASCADE
    ON UPDATE CASCADE;

-- Reference: document_type_doc (table: document)
ALTER TABLE document ADD CONSTRAINT document_type_doc FOREIGN KEY document_type_doc (type_id)
    REFERENCES type_doc (type_id)
    ON DELETE CASCADE
    ON UPDATE CASCADE;

-- Reference: employee_job (table: employee)
ALTER TABLE employee ADD CONSTRAINT employee_job FOREIGN KEY employee_job (job_id)
    REFERENCES job (job_id)
    ON DELETE CASCADE
    ON UPDATE CASCADE;

-- Reference: review_client (table: review)
ALTER TABLE review ADD CONSTRAINT review_client FOREIGN KEY review_client (client_id)
    REFERENCES client (client_id)
    ON DELETE CASCADE
    ON UPDATE CASCADE;

-- Reference: schedule_client (table: client_service)
ALTER TABLE client_service ADD CONSTRAINT schedule_client FOREIGN KEY schedule_client (client_id)
    REFERENCES client (client_id)
    ON DELETE CASCADE
    ON UPDATE CASCADE;

-- Reference: shed_empl_employee (table: shed_empl)
ALTER TABLE shed_empl ADD CONSTRAINT shed_empl_employee FOREIGN KEY shed_empl_employee (emp_id)
    REFERENCES employee (emp_id)
    ON DELETE CASCADE
    ON UPDATE CASCADE;

-- Reference: visit_process (table: client_service)
ALTER TABLE client_service ADD CONSTRAINT visit_process FOREIGN KEY visit_process (process_id)
    REFERENCES process (process_id)
    ON DELETE CASCADE
    ON UPDATE CASCADE;
    
DELIMITER //
    CREATE TRIGGER busy_day BEFORE 
    INSERT ON client_service 
    FOR EACH ROW 
    BEGIN 
        SELECT COUNT(*) INTO @isbusy 
        FROM shed_empl 
            WHERE shed_empl.shed_id = New.shed_empl_id AND shed_empl.is_free = 0; 
        IF @isbusy = 0 THEN 
            signal sqlstate '45000' set message_text = 'My Error Message';
        ELSE 
            SELECT COUNT(*) INTO @cnt 
            FROM client_service 
                WHERE shed_empl_id = New.shed_empl_id;  
            IF @cnt = 5 THEN 
                UPDATE shed_empl SET is_free = 1 WHERE shed_empl.shed_id = New.shed_empl_id; 
            END IF;            
        END IF;          
    END //
DELIMITER ;

-- End of file.

