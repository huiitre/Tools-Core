PROMPT "07/06/2023 : Procédure de création d'un utilisateur"
DELIMITER //
CREATE PROCEDURE CreateUser(
    IN p_email VARCHAR(255),
    IN p_nickname VARCHAR(255),
    IN p_password VARCHAR(255),
    IN p_is_active INT,
    in p_type INT,
    IN p_roles JSON
)
BEGIN
    INSERT INTO `user` (email, nickname, password, is_active, type, roles)
    VALUES (p_email, p_nickname, p_password, p_is_active, p_type, p_roles);
END //
DELIMITER ;
/* CREATE PROCEDURE CreateUser(
    IN p_email VARCHAR(255),
    IN p_nickname VARCHAR(255),
    IN p_password VARCHAR(255),
    IN p_is_active INT,
    in p_type INT,
    IN p_roles JSON
)
BEGIN
    INSERT INTO `user` (email, nickname, password, is_active, type, roles)
    VALUES (p_email, p_nickname, p_password, p_is_active, p_type, p_roles);
END; */