<template>
  <div class="modal-box flex flex-col gap-3">
    <h3 class="font-bold text-lg">Demande Insciption</h3>
    
    <label class="flex items-center gap-2 custom">
      Selectionnez vos enfants :
    </label>
      <select class="grow input input-bordered flex items-center gap-2" name="Enfants" required multiple >
        <option value="" disabled selected>vos enfants --</option>
        <option value="enfant1">Enfant 1</option>
        <option value="enfant2">Enfant 2</option>
        <option value="enfant3">Enfant 3</option>
      </select>
      
      <label class="flex items-center gap-2 custom">
        Sélectionnez vos ateliers  :
      </label>
        <select class="grow input input-bordered flex items-center gap-2" name="Ateliers" required multiple >
          <option value="" disabled selected>Vos ateliers --</option>
          <option value="enfant1">Atelier 1</option>
          <option value="enfant2">Atelier 2</option>
          <option value="enfant3">Atelier 3</option>
        </select>
    <label class="flex items-center gap-2 custom">
      Packs d’inscription  :
    </label>
    <select class="grow input input-bordered flex items-center gap-2" name="Packs"  required multiple>
      <option value="" disabled selected>Packs --</option>
      <option value="primaire">Pack 1</option>
      <option value="collège">Pack 2</option>
      <option value="secondaire">Pack 3</option>
    </select>
    <label class="flex items-center gap-2 custom">
      Options de paiement  :
    </label>
    <select class="grow input input-bordered flex items-center gap-2" name="Packs"  required multiple>
      <option value="" disabled selected>Packs --</option>
      <option value="primaire">mensuel</option>
      <option value="collège">trimestriel</option>
      <option value="secondaire">annuel</option>
    </select>
    <div class="modal-action">
        <form method="dialog" class="inline-flex justify-end gap-4">
            <button class="btn1 btn btn-info " >Ajouter</button>
            <button class="btn">Close</button>
        </form>
    </div>
</div>

</template>
<style scoped>
h3{
  color: #A3B18A;
  font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
  font-size: 1.7rem;
}
.btn1{
  background-color: #A3B18A;
  border: #A3B18A;
}
.custom{
  color: rgba(67, 65, 65, 0.874);
  font-weight: bold;
}
</style>