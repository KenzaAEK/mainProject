<template>
        <div class="modal-box flex flex-col gap-3">
          <h3 class="font-bold text-lg">Motif de refus</h3>
          <select class="grow input input-bordered flex items-center gap-2" name="Niveau d'études" >
            <option value="" disabled selected>Pourquoi vous avez refuse</option>
            <option value="primaire">Coût Élevé</option>
            <option value="collège">Expérience Passée Négative</option>
            <option value="secondaire">Autres</option>
          </select>
          <div class="modal-action">
              <form method="dialog" class="inline-flex justify-end gap-4">
                  <button class="btn1 btn btn-info " >Envoyer</button>
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