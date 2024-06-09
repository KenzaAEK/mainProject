<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id('idNotification');
            $table->string('contenu'); 
            $table->boolean('statut')->default(false);
            $table->unsignedBigInteger('idUser');
            $table->timestamp('read_at')->nullable();
            $table->foreign('idUser')->references('idUser')->on('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('horaires', function (Blueprint $table) {
            $table->id('idHoraire');
            $table->string('jour', 50);
            $table->time('heureDebut');
            $table->time('heureFin');
        });


        Schema::create('packs', function (Blueprint $table) {
            $table->id('idPack');
            $table->string('type');
            $table->decimal('remise', 5, 2)->nullable();;
            $table->date('limite')->nullable();
        });

        Schema::create('factures', function (Blueprint $table) {
            $table->id('idFacture');
            $table->decimal('totalHT', 15, 5);
            $table->decimal('totalTTC', 15, 5);
            $table->date('dateFacture')->default(now());
            $table->text('facturePdf')->nullable();
            $table->unsignedBigInteger('idNotification')->unique();
            $table->foreign('idNotification')->references('idNotification')->on('notifications')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('tuteurs', function (Blueprint $table) {
            $table->id('idTuteur');
            $table->string('fonction', 50)->nullable();
            $table->unsignedBigInteger('idUser')->unique();
            $table->foreign('idUser')->references('idUser')->on('users')->onDelete('cascade');
            $table->timestamps();
        });

         Schema::create('typeactivites', function (Blueprint $table) {
             $table->id('idTypeActivite');
             $table->string('type', 50)->unique();
             $table->string('domaine', 50);
         });


        Schema::create('competences', function (Blueprint $table) {
            $table->id('idCompetence');
            $table->string('nom_competence', 50);
        });

        Schema::create('administrateurs', function (Blueprint $table) {
            $table->id('idAdmin');
            $table->unsignedBigInteger('idUser')->unique();
            $table->foreign('idUser')->references('idUser')->on('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('animateurs', function (Blueprint $table) {
            $table->id('idAnimateur');
            $table->unsignedBigInteger('idUser')->unique();
            $table->foreign('idUser')->references('idUser')->on('users');
            $table->timestamps();
        });

        Schema::create('demande_inscriptions', function (Blueprint $table) {
            $table->id('idDemande');
            $table->enum('optionsPaiement', ['mois', 'trimestre', 'semestre', 'annee']);
            $table->enum('status', ['en attente', 'acceptée', 'refusée'])->default('en attente');
            $table->date('dateDemande')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->unsignedBigInteger('idPack');
            $table->unsignedBigInteger('idTuteur');
            $table->foreign('idPack')->references('idPack')->on('packs');
            $table->foreign('idTuteur')->references('idTuteur')->on('tuteurs');
            
        });

        Schema::create('activites', function (Blueprint $table) {
            $table->id('idActivite');
            $table->string('titre', 100);
            $table->text('description');
            $table->text('objectif');
            $table->string('imagePub', 255)->nullable();
            $table->string('lienYtb',255);
            $table->longText('programmePdf',255);
            $table->unsignedBigInteger('idTypeActivite');
            $table->foreign('idTypeActivite')->references('idTypeActivite')->on('typeactivites');
            $table->timestamps();
        }); 

        Schema::create('enfants', function (Blueprint $table) {
            $table->unsignedBigInteger('idTuteur');
            $table->unsignedBigInteger('idEnfant');
            $table->string('prenom', 100);
            $table->date('dateNaissance');
            $table->string('niveauEtude', 50);
            $table->string('nom', 100);
            $table->primary(['idTuteur', 'idEnfant']);
            $table->foreign('idTuteur')->references('idTuteur')->on('tuteurs');
          
        });

        Schema::create('devis', function (Blueprint $table) {
            $table->id('idDevis');
            $table->decimal('totalHT', 10, 3);
            $table->date('dateDevis')->default(DB::raw('CURRENT_DATE'));;
            $table->decimal('totalTTC', 10, 3);
            $table->decimal('TVA', 10, 3);
            $table->text('devisPdf')->nullable();
            $table->unsignedBigInteger('idNotification');
            $table->unsignedBigInteger('idFacture');
            $table->unsignedBigInteger('idDemande');
            $table->enum('status', ['en_attente', 'accepté', 'refusé'])->default('en_attente');
            $table->text('rejection_reason')->nullable();
            $table->unique('idNotification');
            $table->unique('idDemande');
            $table->foreign('idNotification')->references('idNotification')->on('notifications');
            $table->foreign('idFacture')->references('idFacture')->on('factures');
            $table->foreign('idDemande')->references('idDemande')->on('demande_inscriptions');
        });

         Schema::create('offres', function (Blueprint $table) {
             $table->id('idOffre');
             $table->string('titre', 50);
             $table->decimal('remise', 5, 2)->nullable();
             $table->date('dateDebutOffre')->nullable();
             $table->date('dateFinOffre')->nullable();
             $table->text('description')->nullable();
             $table->unsignedBigInteger('idAdmin');

            $table->foreign('idAdmin')->references('idAdmin')->on('administrateurs')->nullable(); // pour tester sinon il faut enlever nullable !!!
        });

        Schema::create('offreactivites', function (Blueprint $table) {
            $table->unsignedBigInteger('idOffre');
            $table->unsignedBigInteger('idActivite');
            $table->decimal('tarif', 15, 5);
            $table->integer('effmax');
            $table->integer('effmin');
            $table->integer('age_min');
            $table->integer('age_max');
            $table->integer('nbrSeance');
            $table->integer('Duree_en_heure');
            $table->primary(['idOffre', 'idActivite']);
            $table->foreign('idOffre')->references('idOffre')->on('offres');
            $table->foreign('idActivite')->references('idActivite')->on('activites');
           
        });
        

         Schema::create('groupes', function (Blueprint $table) {
             $table->id('idGroupe');
             $table->string('Nomgrp', 50);
             $table->unsignedBigInteger('idOffre');
             $table->unsignedBigInteger('idActivite');
             $table->unsignedBigInteger('idAnimateur');

             $table->unique(['idOffre', 'idActivite']);
             $table->foreign(['idOffre', 'idActivite'])->references(['idOffre', 'idActivite'])->on('offreactivites');
             $table->foreign('idAnimateur')->references('idAnimateur')->on('animateurs');
         });

         Schema::create('admin_traiter', function (Blueprint $table) {
             $table->unsignedBigInteger('idAdmin');
             $table->unsignedBigInteger('idDemande');
             $table->dateTime('dateTraitement');
             $table->text('motifRefus')->nullable();
             $table->enum('statut', ['en cours de traitement', 'accepter', 'refuser']);

             $table->primary(['idAdmin', 'idDemande']);
             $table->foreign('idAdmin')->references('idAdmin')->on('administrateurs');
             $table->foreign('idDemande')->references('idDemande')->on('demande_inscriptions');
         });

         Schema::create('disponibilite_offreactivite', function (Blueprint $table) {
             $table->unsignedBigInteger('idHoraire');
             $table->unsignedBigInteger('idOffre');
             $table->unsignedBigInteger('idActivite');

             $table->primary(['idHoraire', 'idOffre', 'idActivite']);
             $table->foreign('idHoraire')->references('idHoraire')->on('horaires');
             $table->foreign(['idOffre', 'idActivite'])->references(['idOffre', 'idActivite'])->on('offreactivites');
         });

        Schema::create('disponibilite_animateur', function (Blueprint $table) {
            $table->integer('idAnimateur');
            $table->integer('idHoraire');
            $table->primary(['idAnimateur', 'idHoraire']);
             $table->foreign('idAnimateur')->references('idAnimateur')->on('animateurs');
             $table->foreign('idHoraire')->references('idHoraire')->on('horaires');
         });

         Schema::create('planning_enfant', function (Blueprint $table) {
            $table->integer('idTuteur');
            $table->integer('idEnfant');
            $table->integer('idOffre');
            $table->integer('idActivite');
            $table->integer('idH2');
            $table->integer('idH1');
            $table->primary(['idTuteur', 'idEnfant', 'idOffre', 'idActivite']);

            $table->foreign(['idTuteur', 'idEnfant'])->references(['idTuteur', 'idEnfant'])->on('enfants');
            $table->foreign(['idOffre', 'idActivite'])->references(['idOffre', 'idActivite'])->on('offreactivites');
        });

         Schema::create('enfant_groupe', function (Blueprint $table) {
             $table->unsignedBigInteger('idTuteur');
             $table->unsignedBigInteger('idEnfant');
             $table->unsignedBigInteger('idGroupe');
             $table->primary(['idTuteur', 'idEnfant', 'idGroupe']);

             $table->foreign(['idTuteur', 'idEnfant'])->references(['idTuteur', 'idEnfant'])->on('enfants');
             $table->foreign('idGroupe')->references('idGroupe')->on('groupes');
         });

         Schema::create('animateur_competence', function (Blueprint $table) {
             $table->unsignedBigInteger('idAnimateur');
             $table->unsignedBigInteger('idCompetence');
             $table->string('Maitrise');
             $table->primary(['idAnimateur', 'idCompetence']);

             $table->foreign('idAnimateur')->references('idAnimateur')->on('animateurs');
             $table->foreign('idCompetence')->references('idCompetence')->on('competences');
         });

         Schema::create('competance_activite', function (Blueprint $table) {
             $table->integer('idTypeActivite');
             $table->integer('idCompetence');
             $table->string('Niveau_requis', 50);
             $table->primary(['idTypeActivite', 'idCompetence']);

            $table->foreign('idTypeActivite')->references('idTypeActivite')->on('typeactivites');
            $table->foreign('idCompetence')->references('idCompetence')->on('competences');
        });

        Schema::create('inscriptionEnfant_offre_Activite', function (Blueprint $table) {
            $table->integer('idDemande');
            $table->integer('idTuteur');
            $table->integer('idEnfant');
            $table->integer('idOffre');
            $table->integer('idActivite');
            $table->decimal('PixtotalRemise', 10, 3);
            $table->decimal('Prixbrute', 10, 3);
            $table->primary(['idDemande', 'idTuteur', 'idEnfant', 'idOffre', 'idActivite']);

            $table->foreign('idDemande')->references('idDemande')->on('demande_inscriptions');
            $table->foreign(['idTuteur', 'idEnfant'])->references(['idTuteur', 'idEnfant'])->on('enfants');
            $table->foreign(['idOffre', 'idActivite'])->references(['idOffre', 'idActivite'])->on('offreactivites');


        });
    }

        
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::dropIfExists('inscriptionEnfant_offre_Activite');
        Schema::dropIfExists('competance_activite');
        Schema::dropIfExists('animateur_competence');
        Schema::dropIfExists('enfant_groupe');
        Schema::dropIfExists('planning_enfant');
        Schema::dropIfExists('disponibilite_animateur');
        Schema::dropIfExists('admin_traiter');
        Schema::dropIfExists('groupes');
        Schema::dropIfExists('enfants');
        Schema::dropIfExists('disponibilite_offreactivite');
        Schema::dropIfExists('animateurs');
        Schema::dropIfExists('devis');
        Schema::dropIfExists('factures');
        Schema::dropIfExists('competences');
        Schema::dropIfExists('demande_inscriptions');
        Schema::dropIfExists('packs');
        Schema::dropIfExists('tuteurs');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('offreactivites');
        Schema::dropIfExists('paiement_gateway');
        Schema::dropIfExists('offres');
        Schema::dropIfExists('horaires');
        Schema::dropIfExists('administrateurs');
        Schema::dropIfExists('activites');
        Schema::dropIfExists('typeactivites');

        
    }
};