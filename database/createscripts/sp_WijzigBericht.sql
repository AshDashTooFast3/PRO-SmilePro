USE SmilePro;

DROP PROCEDURE IF EXISTS sp_WijzigBericht;

DELIMITER $$

CREATE PROCEDURE sp_WijzigBericht(
    IN p_Id INT,
    IN p_PatientId INT,
    IN p_MedewerkerId INT,
    IN p_Bericht VARCHAR(255)

)
BEGIN
    UPDATE Communicatie
    
    SET PatientId = p_PatientId,
        MedewerkerId = p_MedewerkerId,
        Bericht = p_Bericht,
        VerzondenDatum = NULL
        
    WHERE Id = p_Id;

END$$

DELIMITER ;

