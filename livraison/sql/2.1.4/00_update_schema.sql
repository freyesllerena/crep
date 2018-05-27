CREATE SEQUENCE crep_mso3_competence_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE SEQUENCE crep_mso3_formation_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1;
CREATE TABLE crep_mso3_competence (id NUMBER(10) NOT NULL, cree_par_id NUMBER(10) DEFAULT NULL NULL, modifie_par_id NUMBER(10) DEFAULT NULL NULL, crep_id NUMBER(10) DEFAULT NULL NULL, libelle VARCHAR2(255) DEFAULT NULL NULL, niveau NUMBER(10) DEFAULT NULL NULL, appreciation CLOB DEFAULT NULL NULL, date_creation TIMESTAMP(0) NOT NULL, date_modification TIMESTAMP(0) NOT NULL, dtype VARCHAR2(255) NOT NULL, PRIMARY KEY(id));
CREATE INDEX IDX_5C262A02FC29C013 ON crep_mso3_competence (cree_par_id);
CREATE INDEX IDX_5C262A02553B2554 ON crep_mso3_competence (modifie_par_id);
CREATE INDEX IDX_5C262A02C235614F ON crep_mso3_competence (crep_id);
CREATE TABLE crep_mso3_formation (id NUMBER(10) NOT NULL, cree_par_id NUMBER(10) DEFAULT NULL NULL, modifie_par_id NUMBER(10) DEFAULT NULL NULL, crep_id NUMBER(10) DEFAULT NULL NULL, libelle VARCHAR2(255) DEFAULT NULL NULL, commentaires CLOB DEFAULT NULL NULL, formation_suivie NUMBER(1) DEFAULT NULL NULL, demandee_agent NUMBER(1) DEFAULT NULL NULL, avis_shd NUMBER(1) DEFAULT NULL NULL, proposition_ah NUMBER(1) DEFAULT NULL NULL, cpf NUMBER(1) DEFAULT NULL NULL, echeance NUMBER(10) DEFAULT NULL NULL, date_creation TIMESTAMP(0) NOT NULL, date_modification TIMESTAMP(0) NOT NULL, dtype VARCHAR2(255) NOT NULL, PRIMARY KEY(id));
CREATE INDEX IDX_6553DC8DFC29C013 ON crep_mso3_formation (cree_par_id);
CREATE INDEX IDX_6553DC8D553B2554 ON crep_mso3_formation (modifie_par_id);
CREATE INDEX IDX_6553DC8DC235614F ON crep_mso3_formation (crep_id);
ALTER TABLE crep_mso3_competence ADD CONSTRAINT FK_5C262A02FC29C013 FOREIGN KEY (cree_par_id) REFERENCES utilisateur (id);
ALTER TABLE crep_mso3_competence ADD CONSTRAINT FK_5C262A02553B2554 FOREIGN KEY (modifie_par_id) REFERENCES utilisateur (id);
ALTER TABLE crep_mso3_competence ADD CONSTRAINT FK_5C262A02C235614F FOREIGN KEY (crep_id) REFERENCES crep (id);
ALTER TABLE crep_mso3_formation ADD CONSTRAINT FK_6553DC8DFC29C013 FOREIGN KEY (cree_par_id) REFERENCES utilisateur (id);
ALTER TABLE crep_mso3_formation ADD CONSTRAINT FK_6553DC8D553B2554 FOREIGN KEY (modifie_par_id) REFERENCES utilisateur (id);
ALTER TABLE crep_mso3_formation ADD CONSTRAINT FK_6553DC8DC235614F FOREIGN KEY (crep_id) REFERENCES crep (id);
ALTER TABLE CREP ADD (categorie VARCHAR2(255) DEFAULT NULL NULL, shd_titulaire NUMBER(1) DEFAULT NULL NULL, fonction_exercee_shd VARCHAR2(255) DEFAULT NULL NULL, fonctions_exercees CLOB DEFAULT NULL NULL, cotation_poste VARCHAR2(255) DEFAULT NULL NULL, quotite_travail VARCHAR2(255) DEFAULT NULL NULL, fiche_poste_adaptee NUMBER(1) DEFAULT NULL NULL, appreciation_poste_agent CLOB DEFAULT NULL NULL, contexte_annee_ecoulee CLOB DEFAULT NULL NULL, nature_dossiers_travaux CLOB DEFAULT NULL NULL, resultats_obtenus_par_agent CLOB DEFAULT NULL NULL, contexte_resultats CLOB DEFAULT NULL NULL, appreciation_evaluateur CLOB DEFAULT NULL NULL, elements_particuliers CLOB DEFAULT NULL NULL, obs_agent_sur_son_activite CLOB DEFAULT NULL NULL, objectifs_service CLOB DEFAULT NULL NULL, agents_encadres CLOB DEFAULT NULL NULL, modification_fiche_de_poste CLOB DEFAULT NULL NULL, prise_de_responsabilites CLOB DEFAULT NULL NULL, projet_professionnel CLOB DEFAULT NULL NULL, obs_shd_perspectives_pro CLOB DEFAULT NULL NULL, avis_shd_avancement_grade CLOB DEFAULT NULL NULL, obs_agent_perspectives_pro CLOB DEFAULT NULL NULL, obs_apprec_portees_agent CLOB DEFAULT NULL NULL, obs_conduite_entretien_ah CLOB DEFAULT NULL NULL, obs_apprec_portees_ah CLOB DEFAULT NULL NULL, observations_eventuelles_ah CLOB DEFAULT NULL NULL, fonction_ah VARCHAR2(255) DEFAULT NULL NULL);
ALTER TABLE CREP MODIFY (date_entree_poste DATE DEFAULT NULL);
ALTER TABLE COMPETENCE_POSTE ADD (appreciation CLOB DEFAULT NULL NULL);

commit;
exit;