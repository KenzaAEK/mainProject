<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nom', 50);
            $table->string('prenom', 50);
            $table->string('password');
            $table->integer('tel')->nullable();
            $table->string('email')->unique();
            $table->string('photo')->nullable();
            $table->string('role');
            $table->timestamps();
        });

        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->text('contenu'); // Change to text for longer content
            $table->boolean('statut');
            $table->unsignedBigInteger('idUser');
            $table->foreign('idUser')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('horaire', function (Blueprint $table) {
            $table->id();
            $table->string('jour', 50);
            $table->time('heureDebut');
            $table->time('heureFin');
            $table->timestamps();
        });

        Schema::create('paiement_gateway', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        Schema::create('packs', function (Blueprint $table) {
            $table->id();
            $table->string('type', 50);
            $table->integer('remise');
            $table->string('limite');
            $table->timestamps();
        });

        Schema::create('factures', function (Blueprint $table) {
            $table->id();
            $table->integer('totalHT');
            $table->date('dateFacture');
            $table->integer('totalTTC');
            $table->string('facturePdf')->nullable();
            $table->unsignedBigInteger('idNotification');
            $table->foreign('idNotification')->references('id')->on('notifications')->onDelete('cascade');
            $table->unique('idNotification');
            $table->timestamps();
        });

        Schema::create('tuteurs', function (Blueprint $table) {
            $table->id();
            $table->string('fonction', 50);
            $table->unsignedBigInteger('idUser');
            $table->foreign('idUser')->references('id')->on('users')->onDelete('cascade');
            $table->unique('idUser');
            $table->timestamps();
        });

        Schema::create('type_activites', function (Blueprint $table) {
            $table->id();
            $table->string('type', 50);
            $table->string('domaine', 50);
            $table->timestamps();
        });

        Schema::create('competences', function (Blueprint $table) {
            $table->id();
            $table->string('nom_competence', 50);
            $table->timestamps();
        });

        Schema::create('administrateurs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idUser');
            $table->foreign('idUser')->references('id')->on('users')->onDelete('cascade');
            $table->unique('idUser');
            $table->timestamps();
        });

        Schema::create('Animateurs', function (Blueprint $table) {
            $table->id('idAnimateur');
            $table->unsignedBigInteger('idUser');
            $table->unique('idUser');
            $table->foreign('idUser')->references('idUser')->on('Users');
            $table->primary(['idAnimateur']);
        });

        Schema::create('demande_inscription', function (Blueprint $table) {
            $table->id('idDemande');
            $table->string('optionsPaiement', 50);
            $table->string('status', 50);
            $table->date('dateDemande');
            $table->unsignedBigInteger('idPack');
            $table->unsignedBigInteger('idTuteur');
            $table->foreign('idPack')->references('idPack')->on('pack');
            $table->foreign('idTuteur')->references('idTuteur')->on('Tuteurs');
            $table->primary(['idDemande']);
        });

        Schema::create('activite', function (Blueprint $table) {
            $table->id('idActivite');
            $table->string('titre', 50);
            $table->string('description', 50);
            $table->string('objectif', 50);
            $table->string('imagePub', 50);
            $table->string('lienYtb', 50);
            $table->string('programmePdf', 50);
            $table->unsignedBigInteger('id_Activit');
            $table->foreign('id_Activit')->references('id_Activit')->on('Type_Activit');
            $table->primary(['idActivite']);
        });

        Schema::create('enfant', function (Blueprint $table) {
            $table->unsignedBigInteger('idTuteur');
            $table->unsignedBigInteger('idEnfant');
            $table->string('prenom_', 50);
            $table->date('dateNaissance');
            $table->string('niveauEtude', 50);
            $table->string('nom', 50);
            $table->primary(['idTuteur', 'idEnfant']);
            $table->foreign('idTuteur')->references('idTuteur')->on('Tuteurs');
        });

        Schema::create('devis', function (Blueprint $table) {
            $table->id('idDevis');
            $table->integer('totalHT');
            $table->date('dateDevis')->notNull();
            $table->integer('totalTTC');
            $table->integer('TVA');
            $table->string('devisPdf', 50);
            $table->unsignedBigInteger('IdNotification');
            $table->unsignedBigInteger('idFacture');
            $table->unsignedBigInteger('idDemande');
            $table->unique('IdNotification');
            $table->unique('idDemande');
            $table->foreign('IdNotification')->references('IdNotification')->on('notifications');
            $table->foreign('idFacture')->references('idFacture')->on('facture');
            $table->foreign('idDemande')->references('idDemande')->on('demande_inscription');
            $table->primary(['idDevis']);
        });

        Schema::create('offre', function (Blueprint $table) {
            $table->id('idOffre');
            $table->string('titre', 50);
            $table->string('remise', 50);
            $table->date('dateUpdate');
            $table->date('dateCreation');
            $table->date('dateDebutOffre');
            $table->date('dateFinOffre');
            $table->text('description');
            $table->unsignedBigInteger('idAdmin');

            $table->primary('idOffre');
            $table->foreign('idAdmin')->references('idAdmin')->on('administrateur');
        });

        Schema::create('offre_activite', function (Blueprint $table) {
            $table->id('id_offreActivite');
            $table->string('idOffre');
            $table->unsignedBigInteger('idActivite');
            $table->integer('tarif');
            $table->integer('effmax');
            $table->integer('effmin');
            $table->string('age_min', 50);
            $table->string('age_max', 50);
            $table->integer('nbrSeance');
            $table->time('Duree');
            $table->unsignedBigInteger('idPaiment');

            $table->primary(['idOffre', 'idActivite']);
            $table->foreign('idOffre')->references('idOffre')->on('offre');
            $table->foreign('idActivite')->references('idActivite')->on('activite');
            $table->foreign('idPaiment')->references('idPaiment')->on('paymnetGatway');
        });

        Schema::create('Groupe', function (Blueprint $table) {
            $table->id('id_grp');
            $table->string('Nomgrp', 50);
            $table->string('idOffre');
            $table->unsignedBigInteger('idActivite');

            $table->primary('id_grp');
            $table->unique(['idOffre', 'idActivite']);
            $table->foreign(['idOffre', 'idActivite'])->references(['idOffre', 'idActivite'])->on('offre_activite');
        });

        Schema::create('admin_traiter_', function (Blueprint $table) {
            $table->unsignedBigInteger('idAdmin');
            $table->unsignedBigInteger('idDemande');
            $table->dateTime('dateTraitement_');
            $table->string('motifRefus', 100);
            $table->string('statut', 50);

            $table->primary(['idAdmin', 'idDemande']);
            $table->foreign('idAdmin')->references('idAdmin')->on('administrateur');
            $table->foreign('idDemande')->references('idDemande')->on('demande_inscription');
        });

        Schema::create('disponibilite_offreactivite', function (Blueprint $table) {
            $table->unsignedBigInteger('idHoraire');
            $table->string('idOffre');
            $table->unsignedBigInteger('idActivite');
            $table->unsignedBigInteger('id_offreActivite');

            $table->primary(['idHoraire', 'idOffre', 'idActivite', 'id_offreActivite']);
            $table->foreign('idHoraire')->references('idHoraire')->on('horaire');
            $table->foreign(['idOffre', 'idActivite', 'id_offreActivite'])->references(['idOffre', 'idActivite', 'id_offreActivite'])->on('offre_activite');
        });

        Schema::create('disponibilite_animateur', function (Blueprint $table) {
            $table->integer('idAnimateur');
            $table->integer('idHoraire');
            $table->primary(['idAnimateur', 'idHoraire']);

            $table->foreign('idAnimateur')->references('idAnimateur')->on('Animateurs');
            $table->foreign('idHoraire')->references('idHoraire')->on('horaire');
        });

        Schema::create('planning_enfant', function (Blueprint $table) {
            $table->integer('idTuteur');
            $table->integer('idEnfant');
            $table->string('idOffre', 50);
            $table->integer('idActivite');
            $table->integer('id_offreActivite');
            $table->integer('idH2');
            $table->integer('idH1');
            $table->primary(['idTuteur', 'idEnfant', 'idOffre', 'idActivite', 'id_offreActivite']);

            $table->foreign(['idTuteur', 'idEnfant'])->references(['idTuteur', 'idEnfant'])->on('enfant');
            $table->foreign(['idOffre', 'idActivite', 'id_offreActivite'])->references(['idOffre', 'idActivite', 'id_offreActivite'])->on('offre_activite');
        });

        Schema::create('Enfant_groupe', function (Blueprint $table) {
            $table->integer('idTuteur');
            $table->integer('idEnfant');
            $table->integer('id_grp');
            $table->primary(['idTuteur', 'idEnfant', 'id_grp']);

            $table->foreign(['idTuteur', 'idEnfant'])->references(['idTuteur', 'idEnfant'])->on('enfant');
            $table->foreign('id_grp')->references('id_grp')->on('Groupe');
        });

        Schema::create('Animateur_competence', function (Blueprint $table) {
            $table->integer('idAnimateur');
            $table->integer('Id_competence');
            $table->string('Maitrise', 50);
            $table->primary(['idAnimateur', 'Id_competence']);

            $table->foreign('idAnimateur')->references('idAnimateur')->on('Animateurs');
            $table->foreign('Id_competence')->references('Id_competence')->on('Competence');
        });

        Schema::create('Animateur_groupes', function (Blueprint $table) {
            $table->integer('idAnimateur');
            $table->integer('id_grp');
            $table->primary(['idAnimateur', 'id_grp']);

            $table->foreign('idAnimateur')->references('idAnimateur')->on('Animateurs');
            $table->foreign('id_grp')->references('id_grp')->on('Groupe');
        });

        Schema::create('Competance_activite', function (Blueprint $table) {
            $table->integer('id_Activit');
            $table->integer('Id_competence');
            $table->string('Niveau_requis', 50);
            $table->primary(['id_Activit', 'Id_competence']);

            $table->foreign('id_Activit')->references('id_Activit')->on('Type_Activit');
            $table->foreign('Id_competence')->references('Id_competence')->on('Competence');
        });

        Schema::create('inscriptionEnfant_offre_Activite', function (Blueprint $table) {
            $table->integer('idDemande');
            $table->integer('idTuteur');
            $table->integer('idEnfant');
            $table->string('idOffre', 50);
            $table->integer('idActivite');
            $table->integer('id_offreActivite');
            $table->primary(['idDemande', 'idTuteur', 'idEnfant', 'idOffre', 'idActivite', 'id_offreActivite']);

            $table->foreign('idDemande')->references('idDemande')->on('demande_inscription');
            $table->foreign(['idTuteur', 'idEnfant'])->references(['idTuteur', 'idEnfant'])->on('enfant');
            $table->foreign(['idOffre', 'idActivite', 'id_offreActivite'])->references(['idOffre', 'idActivite', 'id_offreActivite'])->on('offre_activite');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('administrateurs');
        Schema::dropIfExists('competences');
        Schema::dropIfExists('type_activites');
        Schema::dropIfExists('tuteurs');
        Schema::dropIfExists('factures');
        Schema::dropIfExists('packs');
        Schema::dropIfExists('paiement_gateway');
        Schema::dropIfExists('horaire');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('users');
        Schema::dropIfExists('devis');
        Schema::dropIfExists('enfant');
        Schema::dropIfExists('activite');
        Schema::dropIfExists('demande_inscription');
        Schema::dropIfExists('Animateurs');
        Schema::dropIfExists('disponibilite_offreactivite');
        Schema::dropIfExists('admin_traiter_');
        Schema::dropIfExists('Groupe');
        Schema::dropIfExists('offre_activite');
        Schema::dropIfExists('offre');
        Schema::dropIfExists('disponibilite_animateur');
        Schema::dropIfExists('planning_enfant');
        Schema::dropIfExists('Enfant_groupe');
        Schema::dropIfExists('Animateur_competence');
        Schema::dropIfExists('Animateur_groupes');
        Schema::dropIfExists('Competance_activite');
        Schema::dropIfExists('inscriptionEnfant_offre_Activite');
    }
}


