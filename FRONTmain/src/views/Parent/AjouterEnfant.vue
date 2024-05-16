<template>
  <div class="modal-box flex flex-col gap-3">
    <h3 class="font-bold text-lg">Ajouter Enfant</h3>
    <label class="flex items-center gap-2">
      Nom :
    </label>
    <input type="text" class="grow input input-bordered flex items-center gap-2" placeholder="Entrez le nom"  required />
    <label class="flex items-center gap-2">
      Prénom :
    </label>
    <input type="text" class="grow input input-bordered flex items-center gap-2" placeholder="Entrez le prénom"  required />
    <label class="flex items-center gap-2">
      Niveau d'études :
    </label>
    <select class="grow input input-bordered flex items-center gap-2" name="Niveau d'études"  required>
      <option value="" disabled selected>Niveau d'études --</option>
      <option value="primaire">primaire</option>
      <option value="collège">collège</option>
      <option value="secondaire">secondaire</option>
    </select>
    <label class="flex items-center gap-2" type="date">
      Date de naissance :
    </label>
    <input type="date" class="grow input input-bordered flex items-center gap-2" pattern="\d{2}/\d{2}/\d{4}" placeholder="DD/MM/YYYY"  required />
    
    


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
</style>