USE SmilePro;

DROP PROCEDURE IF EXISTS sp_GetAllCommunicatie;

DELIMITER $$

CREATE PROCEDURE sp_GetAllCommunicatie()
BEGIN
    SELECT COM.Id
            , COM.PatientId
            , COM.MedewerkerId
            , COM.Bericht
            , COM.VerzondenDatum
            , COM.Isactief
            , PAT.Nummer AS PatientNummer
            , MED.Nummer AS MedewerkerNummer
            , PER.Voornaam 
            , PER.Achternaam
    FROM Communicatie COM
    INNER JOIN Medewerker MED ON COM.MedewerkerId = MED.Id
    INNER JOIN Patient PAT ON COM.PatientId = PAT.Id
    INNER JOIN Persoon PER ON PAT.PersoonId = PER.Id;
END$$

DELIMITER ;