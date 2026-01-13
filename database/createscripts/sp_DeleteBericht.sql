USE SmilePro;

DROP PROCEDURE IF EXISTS sp_DeleteBericht;

DELIMITER $$

CREATE PROCEDURE sp_DeleteBericht (
    IN CommunicatieId INT
)

BEGIN
    DELETE FROM Communicatie c 
    WHERE Id = CommunicatieId;
END$$

DELIMITER ;

