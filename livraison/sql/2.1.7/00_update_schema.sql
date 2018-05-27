CREATE SEQUENCE crep_mj01formation_envisagee_i START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE SEQUENCE crep_mj01_competence_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE SEQUENCE crep_mj01formation_suivie_id_s START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE SEQUENCE crep_mj01formation_sollicitee_ START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE TABLE crep_mj01formation_envisagee (id NUMBER(10) NOT NULL, crep_id NUMBER(10) NOT NULL, cree_par_id NUMBER(10) DEFAULT NULL NULL, modifie_par_id NUMBER(10) DEFAULT NULL NULL, libelle VARCHAR2(255) NOT NULL, origine NUMBER(10) NOT NULL, date_creation TIMESTAMP(0) NOT NULL, date_modification TIMESTAMP(0) NOT NULL, PRIMARY KEY(id));
CREATE INDEX IDX_F1FA4692C235614F ON crep_mj01formation_envisagee (crep_id);
CREATE INDEX IDX_F1FA4692FC29C013 ON crep_mj01formation_envisagee (cree_par_id);
CREATE INDEX IDX_F1FA4692553B2554 ON crep_mj01formation_envisagee (modifie_par_id);
CREATE TABLE crep_mj01_competence (id NUMBER(10) NOT NULL, cree_par_id NUMBER(10) DEFAULT NULL NULL, modifie_par_id NUMBER(10) DEFAULT NULL NULL, crep_id NUMBER(10) NOT NULL, libelle CLOB NOT NULL, niveau NUMBER(10) DEFAULT NULL NULL, date_creation TIMESTAMP(0) NOT NULL, date_modification TIMESTAMP(0) NOT NULL, dtype VARCHAR2(255) NOT NULL, PRIMARY KEY(id));
CREATE INDEX IDX_560395F5FC29C013 ON crep_mj01_competence (cree_par_id);
CREATE INDEX IDX_560395F5553B2554 ON crep_mj01_competence (modifie_par_id);
CREATE INDEX IDX_560395F5C235614F ON crep_mj01_competence (crep_id);
CREATE TABLE crep_mj01formation_suivie (id NUMBER(10) NOT NULL, crep_id NUMBER(10) NOT NULL, cree_par_id NUMBER(10) DEFAULT NULL NULL, modifie_par_id NUMBER(10) DEFAULT NULL NULL, libelle VARCHAR2(255) NOT NULL, duree VARCHAR2(255) DEFAULT NULL NULL, date_creation TIMESTAMP(0) NOT NULL, date_modification TIMESTAMP(0) NOT NULL, PRIMARY KEY(id));
CREATE INDEX IDX_316141D0C235614F ON crep_mj01formation_suivie (crep_id);
CREATE INDEX IDX_316141D0FC29C013 ON crep_mj01formation_suivie (cree_par_id);
CREATE INDEX IDX_316141D0553B2554 ON crep_mj01formation_suivie (modifie_par_id);
CREATE TABLE crep_mj01formation_sollicitee (id NUMBER(10) NOT NULL, crep_id NUMBER(10) NOT NULL, cree_par_id NUMBER(10) DEFAULT NULL NULL, modifie_par_id NUMBER(10) DEFAULT NULL NULL, libelle VARCHAR2(255) NOT NULL, origine NUMBER(10) NOT NULL, date_creation TIMESTAMP(0) NOT NULL, date_modification TIMESTAMP(0) NOT NULL, PRIMARY KEY(id));
CREATE INDEX IDX_56145935C235614F ON crep_mj01formation_sollicitee (crep_id);
CREATE INDEX IDX_56145935FC29C013 ON crep_mj01formation_sollicitee (cree_par_id);
CREATE INDEX IDX_56145935553B2554 ON crep_mj01formation_sollicitee (modifie_par_id);
ALTER TABLE crep_mj01formation_envisagee ADD CONSTRAINT FK_F1FA4692C235614F FOREIGN KEY (crep_id) REFERENCES crep (id);
ALTER TABLE crep_mj01formation_envisagee ADD CONSTRAINT FK_F1FA4692FC29C013 FOREIGN KEY (cree_par_id) REFERENCES utilisateur (id);
ALTER TABLE crep_mj01formation_envisagee ADD CONSTRAINT FK_F1FA4692553B2554 FOREIGN KEY (modifie_par_id) REFERENCES utilisateur (id);
ALTER TABLE crep_mj01_competence ADD CONSTRAINT FK_560395F5FC29C013 FOREIGN KEY (cree_par_id) REFERENCES utilisateur (id);
ALTER TABLE crep_mj01_competence ADD CONSTRAINT FK_560395F5553B2554 FOREIGN KEY (modifie_par_id) REFERENCES utilisateur (id);
ALTER TABLE crep_mj01_competence ADD CONSTRAINT FK_560395F5C235614F FOREIGN KEY (crep_id) REFERENCES crep (id);
ALTER TABLE crep_mj01formation_suivie ADD CONSTRAINT FK_316141D0C235614F FOREIGN KEY (crep_id) REFERENCES crep (id);
ALTER TABLE crep_mj01formation_suivie ADD CONSTRAINT FK_316141D0FC29C013 FOREIGN KEY (cree_par_id) REFERENCES utilisateur (id);
ALTER TABLE crep_mj01formation_suivie ADD CONSTRAINT FK_316141D0553B2554 FOREIGN KEY (modifie_par_id) REFERENCES utilisateur (id);
ALTER TABLE crep_mj01formation_sollicitee ADD CONSTRAINT FK_56145935C235614F FOREIGN KEY (crep_id) REFERENCES crep (id);
ALTER TABLE crep_mj01formation_sollicitee ADD CONSTRAINT FK_56145935FC29C013 FOREIGN KEY (cree_par_id) REFERENCES utilisateur (id);
ALTER TABLE crep_mj01formation_sollicitee ADD CONSTRAINT FK_56145935553B2554 FOREIGN KEY (modifie_par_id) REFERENCES utilisateur (id);
ALTER TABLE CREP ADD (service_shd VARCHAR2(255) DEFAULT NULL NULL, obs_agent_objectifs_evalues CLOB DEFAULT NULL NULL, marge_evol_comp_pro NUMBER(10) DEFAULT NULL NULL, marge_evol_aptitudes_pro NUMBER(10) DEFAULT NULL NULL, marge_evol_qualites_pro NUMBER(10) DEFAULT NULL NULL, marge_evol_capacite_encad NUMBER(10) DEFAULT NULL NULL, marge_evolution_globale NUMBER(10) DEFAULT NULL NULL, niveau_performance_globale NUMBER(10) DEFAULT NULL NULL, obs_competences_pro CLOB DEFAULT NULL NULL, obs_aptitudes_pro CLOB DEFAULT NULL NULL, obs_qualites_relationnelles CLOB DEFAULT NULL NULL, obs_capacites_encadrement CLOB DEFAULT NULL NULL, observations_globale CLOB DEFAULT NULL NULL, note_agent NUMBER(10) DEFAULT NULL NULL, observations_shd CLOB DEFAULT NULL NULL, perspectives_evol_service CLOB DEFAULT NULL NULL, perspectives_evol_fonction CLOB DEFAULT NULL NULL, observations_shd_formation CLOB DEFAULT NULL NULL, connaissances_institution CLOB DEFAULT NULL NULL, connaissances_professionnelles CLOB DEFAULT NULL NULL, experience_encadrement CLOB DEFAULT NULL NULL, capacites_decisions CLOB DEFAULT NULL NULL, obs_agent_deroul_entretien CLOB DEFAULT NULL NULL, obs_agent_apprec_portees CLOB DEFAULT NULL NULL, motif_absence_entretien CLOB DEFAULT NULL NULL);
ALTER TABLE CREP MODIFY (nom_usage_shd VARCHAR2(255) DEFAULT NULL, prenom_shd VARCHAR2(255) DEFAULT NULL);

commit;
exit;