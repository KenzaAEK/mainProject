-- Functions :


-- FUNCTION: public.deleteoffreactivitesbyid(bigint, bigint)

-- DROP FUNCTION IF EXISTS public.deleteoffreactivitesbyid(bigint, bigint);

CREATE OR REPLACE FUNCTION public.deleteoffreactivitesbyid(
	p_id_offre bigint,
	p_id_activite bigint)
    RETURNS text
    LANGUAGE 'plpgsql'
    COST 100
    VOLATILE PARALLEL UNSAFE
AS $BODY$
BEGIN
    -- Supprimer les enregistrements de groupes (dependent records)
    DELETE FROM groupes
    WHERE "idOffre" = p_id_offre AND "idActivite" = p_id_activite;
    
	  -- Supprimer les enregistrements de disponibilite_offreactivite
    DELETE FROM disponibilite_offreactivite
    WHERE "idOffre" = p_id_offre AND "idActivite" = p_id_activite;

    -- Supprimer les enregistrements de offreactivites (parent records)
    DELETE FROM offreactivites
    WHERE "idOffre" = p_id_offre AND "idActivite" = p_id_activite;

  
    IF FOUND THEN
        RETURN 'Record successfully deleted.';
    ELSE
        RETURN 'No record found to delete.';
    END IF;
EXCEPTION
    WHEN OTHERS THEN
        RAISE NOTICE 'Error during deletion: %', SQLERRM;
        RETURN 'Error during deletion: ' || SQLERRM;
END;
$BODY$;

ALTER FUNCTION public.deleteoffreactivitesbyid(bigint, bigint)
    OWNER TO postgres;
	
-- FUNCTION: public.deleteoffreactivitesbyidoffre(bigint)

-- DROP FUNCTION IF EXISTS public.deleteoffreactivitesbyidoffre(bigint);

CREATE OR REPLACE FUNCTION public.deleteoffreactivitesbyidoffre(
	p_id_offre bigint)
    RETURNS text
    LANGUAGE 'plpgsql'
    COST 100
    VOLATILE PARALLEL UNSAFE
AS $BODY$
BEGIN
    -- Supprimer les enregistrements de disponibilite_offreactivite
    DELETE FROM disponibilite_offreactivite
    WHERE "idOffre" = p_id_offre;

    -- Supprimer les enregistrements de offreactivites
    DELETE FROM offreactivites
    WHERE "idOffre" = p_id_offre;

    -- Supprimer les enregistrements de offres
    DELETE FROM offres
    WHERE "idOffre" = p_id_offre;

    IF FOUND THEN
        RETURN 'Records successfully deleted.';
    ELSE
        RETURN 'No records found to delete.';
    END IF;
EXCEPTION
    WHEN OTHERS THEN
        RAISE NOTICE 'Error during deletion: %', SQLERRM;
        RETURN 'Error during deletion: ' || SQLERRM;
END;
$BODY$;

ALTER FUNCTION public.deleteoffreactivitesbyidoffre(bigint)
    OWNER TO postgres;
	
	-- FUNCTION: public.getenfantactivitesnom(integer, text, text)

-- DROP FUNCTION IF EXISTS public.getenfantactivitesnom(integer, text, text);

CREATE OR REPLACE FUNCTION public.getenfantactivitesnom(
	animateur_id integer,
	prenom_search text DEFAULT NULL::text,
	nom_search text DEFAULT NULL::text)
    RETURNS TABLE(prenom_enfant text, nom_enfant text, titre_activite text, jour_activite text, description_atelier text, heure_debut time without time zone, heure_fin time without time zone) 
    LANGUAGE 'plpgsql'
    COST 100
    VOLATILE PARALLEL UNSAFE
    ROWS 1000

AS $BODY$
BEGIN
    RETURN QUERY
    SELECT 
        enfants."prenom"::text, 
        enfants."nom"::text, 
        activites."titre"::text,
        horaires."jour"::text,
        activites."description"::text,
        horaires."heureDebut",
        horaires."heureFin"
    FROM 
        enfants
    JOIN 
        planning_enfant ON enfants."idEnfant" = planning_enfant."idEnfant"
    JOIN 
        offreactivites ON planning_enfant."idOffre" = offreactivites."idOffre"
    JOIN 
        activites ON offreactivites."idActivite" = activites."idActivite"
    JOIN 
        groupes ON groupes."idOffre" = offreactivites."idOffre" AND groupes."idActivite" = offreactivites."idActivite"
    JOIN 
        disponibilite_offreactivite ON offreactivites."idOffre" = disponibilite_offreactivite."idOffre" AND offreactivites."idActivite" = disponibilite_offreactivite."idActivite"
    JOIN 
        horaires ON disponibilite_offreactivite."idHoraire" = horaires."idHoraire"
    WHERE 
         groupes."idAnimateur" = animateur_id
        AND horaires."idHoraire" IN (SELECT "idHoraire" FROM disponibilite_animateur WHERE "idAnimateur" = animateur_id)
        AND (prenom_search IS NULL OR enfants."prenom" ILIKE '%' || prenom_search || '%')
        AND (nom_search IS NULL OR enfants."nom" ILIKE '%' || nom_search || '%');
END;
$BODY$;

ALTER FUNCTION public.getenfantactivitesnom(integer, text, text)
    OWNER TO postgres;
	
	
	-- FUNCTION: public.getenfantactivitesss(integer)

-- DROP FUNCTION IF EXISTS public.getenfantactivitesss(integer);

CREATE OR REPLACE FUNCTION public.getenfantactivitesss(
	animateur_id integer)
    RETURNS TABLE(prenom_enfant text, nom_enfant text, niveau_etude text, date_naissance date, titre_activite text, image_pub text, jour_activite text, description_atelier text, heure_debut time without time zone, heure_fin time without time zone) 
    LANGUAGE 'plpgsql'
    COST 100
    VOLATILE PARALLEL UNSAFE
    ROWS 1000

AS $BODY$
BEGIN
    RETURN QUERY
    SELECT 
        enfants."prenom"::text, -- ici j'étais obligé de faire un cast
        enfants."nom"::text,
        enfants."niveauEtude"::text,
        enfants."dateNaissance"::date,
        activites."titre"::text, -- afin d'assurer un retour correct des valeurs
        activites."imagePub"::text,
        horaires."jour"::text,
        activites."description"::text,
        horaires."heureDebut",
        horaires."heureFin"
    FROM 
        enfants
    JOIN 
        planning_enfant ON enfants."idEnfant" = planning_enfant."idEnfant"
    JOIN 
        offreactivites ON planning_enfant."idOffre" = offreactivites."idOffre"
    JOIN 
        activites ON offreactivites."idActivite" = activites."idActivite"
    JOIN 
        groupes ON groupes."idOffre" = offreactivites."idOffre" AND groupes."idActivite" = offreactivites."idActivite"
    JOIN 
        disponibilite_offreactivite ON offreactivites."idOffre" = disponibilite_offreactivite."idOffre" AND offreactivites."idActivite" = disponibilite_offreactivite."idActivite"
    JOIN 
        horaires ON disponibilite_offreactivite."idHoraire" = horaires."idHoraire"
    WHERE 
        groupes."idAnimateur" = animateur_id
        AND horaires."idHoraire" IN (SELECT "idHoraire" FROM disponibilite_animateur WHERE "idAnimateur" = animateur_id);
END;
$BODY$;

ALTER FUNCTION public.getenfantactivitesss(integer)
    OWNER TO postgres;
	
	
	-- FUNCTION: public.updateoffreactivites(integer, text, date, text, json)

-- DROP FUNCTION IF EXISTS public.updateoffreactivites(integer, text, date, text, json);

CREATE OR REPLACE FUNCTION public.updateoffreactivites(
	p_id_offre integer,
	p_titre text,
	p_datefinoffre date,
	p_description text,
	p_activites json)
    RETURNS text
    LANGUAGE 'plpgsql'
    COST 100
    VOLATILE PARALLEL UNSAFE
AS $BODY$
DECLARE
    activiteData JSON;
    jourData JSON;
    idActiviteData INT;
    tarifData NUMERIC;
    effmaxData INT;
    effminData INT;
    ageMinData INT;
    ageMaxData INT;
    nbrSeanceData INT;
    totalDuree NUMERIC;
    heureDebut TIME;
    heureFin TIME;
    interval INTERVAL;
    dureeEnHeures NUMERIC;
    idHoraire INT;
BEGIN
    -- Vérifier l'existence de l'offre
    IF NOT EXISTS (SELECT 1 FROM offres WHERE "idOffre" = p_id_offre) THEN
        RETURN 'Error: The specified offer does not exist';
    END IF;

    -- Mettre à jour l'offre
    UPDATE offres SET 
        "titre" = p_titre,
        "description" = p_description,
        "dateFinOffre" = p_datefinoffre
    WHERE "idOffre" = p_id_offre;

    FOR activiteData IN SELECT * FROM json_array_elements(p_activites)
    LOOP
        idActiviteData := (activiteData->>'idActivite')::INT;

        -- Vérifier l'existence de l'activité
        IF NOT EXISTS (SELECT 1 FROM activites WHERE "idActivite" = idActiviteData) THEN
            RETURN 'Error: The specified activity does not exist';
        END IF;

        tarifData := (activiteData->>'tarif')::NUMERIC;
        effmaxData := (activiteData->>'effmax')::INT;
        effminData := (activiteData->>'effmin')::INT;
        ageMinData := (activiteData->>'age_min')::INT;
        ageMaxData := (activiteData->>'age_max')::INT;

        totalDuree := 0;
        nbrSeanceData := 0;

        -- Supprimer les anciens horaires de disponibilite_offreactivite
        DELETE FROM disponibilite_offreactivite
        WHERE "idOffre" = p_id_offre AND "idActivite" = idActiviteData;

        FOR jourData IN SELECT * FROM json_array_elements(activiteData->'jours')
        LOOP
            heureDebut := (jourData->>'heureDebut')::TIME;
            heureFin := (jourData->>'heureFin')::TIME;
            interval := heureFin - heureDebut;
            dureeEnHeures := EXTRACT(EPOCH FROM interval) / 3600;
            totalDuree := totalDuree + dureeEnHeures;
            nbrSeanceData := nbrSeanceData + 1;

            -- Insérer le nouvel horaire dans la table horaires et récupérer idHoraire
            INSERT INTO horaires (jour, "heureDebut", "heureFin")
            VALUES (jourData->>'JourAtelier', heureDebut, heureFin)
            RETURNING "idHoraire" INTO idHoraire;

            -- Associer l'horaire avec l'activité de l'offre
            INSERT INTO disponibilite_offreactivite ("idHoraire", "idOffre", "idActivite")
            VALUES (idHoraire, p_id_offre, idActiviteData);
        END LOOP;

        -- Mettre à jour ou insérer les données dans offreactivites
        INSERT INTO offreactivites ("idOffre", "idActivite", tarif, effmax, effmin, age_min, age_max, "nbrSeance", "Duree_en_heure")
        VALUES (p_id_offre, idActiviteData, tarifData, effmaxData, effminData, ageMinData, ageMaxData, nbrSeanceData, totalDuree)
        ON CONFLICT ("idOffre", "idActivite") DO UPDATE
        SET tarif = EXCLUDED.tarif, 
            effmax = EXCLUDED.effmax, 
            effmin = EXCLUDED.effmin,
            age_min = EXCLUDED.age_min, 
            age_max = EXCLUDED.age_max,
            "nbrSeance" = EXCLUDED."nbrSeance", 
            "Duree_en_heure" = EXCLUDED."Duree_en_heure";
    END LOOP;

    RETURN 'Update successful';
EXCEPTION
    WHEN OTHERS THEN
        RAISE NOTICE 'Error during update: %', SQLERRM;
        RETURN 'Error during update: ' || SQLERRM;
END;
$BODY$;

ALTER FUNCTION public.updateoffreactivites(integer, text, date, text, json)
    OWNER TO postgres;
	
	
	-- Triggers : 
-- FUNCTION: public.insert_into_role_tables()

-- DROP FUNCTION IF EXISTS public.insert_into_role_tables();

CREATE OR REPLACE FUNCTION public.insert_into_role_tables()
    RETURNS trigger
    LANGUAGE 'plpgsql'
    COST 100
    VOLATILE NOT LEAKPROOF
AS $BODY$
BEGIN
    IF NEW.role = '1' THEN
        INSERT INTO tuteurs ("idUser", fonction) VALUES (NEW."idUser", NULL);
    ELSIF NEW.role = '2' THEN
        INSERT INTO administrateurs ("idUser") VALUES (NEW."idUser");
    ELSIF NEW.role = '3' THEN
        INSERT INTO animateurs ("idUser") VALUES (NEW."idUser");
    END IF;
    RETURN NEW;
END;
$BODY$;

ALTER FUNCTION public.insert_into_role_tables()
    OWNER TO postgres;


-- FUNCTION: public.set_new_demande_inscription_id()

-- DROP FUNCTION IF EXISTS public.set_new_demande_inscription_id();

CREATE OR REPLACE FUNCTION public.set_new_demande_inscription_id()
    RETURNS trigger
    LANGUAGE 'plpgsql'
    COST 100
    VOLATILE NOT LEAKPROOF
AS $BODY$
BEGIN
    NEW."idDemande" = COALESCE((SELECT MAX("idDemande") FROM "demande_inscriptions"), 0) + 1;
    RETURN NEW;
END;
$BODY$;

ALTER FUNCTION public.set_new_demande_inscription_id()
    OWNER TO postgres;