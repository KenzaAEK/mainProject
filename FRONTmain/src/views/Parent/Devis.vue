<template>
  <div class="modal-box" style="background-color: #F6F5F4 ;">
    <div class="navbar ">
      <div class="flex-1">
        <a class="btn btn-ghost text-xl">LOGO</a>
      </div>
      <div class="flex-none">
        <ul class="menu menu-horizontal px-1">
          <h4 style="cursor: text;">Devis N ° </h4>
        </ul>
      </div>
      
    </div>
    <div class="modal-action">
      <form method="dialog">
        <!-- if there is a button in form, it will close the modal -->
        <div class="overflow-x-auto">
          <div class="recu">
            <h2>Nom de client </h2>
            <h2>num de telephone </h2>
            <h2>email </h2>
          </div>
          <table class="table">
            <!-- head -->
            <thead>
              <tr>
                <th>Name</th>
                <th>Job</th>
                <th>Favorite Color</th>
              </tr>
            </thead>
            <tbody>
              <!-- row 1 -->
              <tr>
                <td>Cy Ganderton</td>
                <td>Quality Control Specialist</td>
                <td>Blue</td>
              </tr>
              <!-- row 2 -->
              <tr>
                <td>Hart Hagerty</td>
                <td>Desktop Support Technician</td>
                <td>Purple</td>
              </tr>
            </tbody>
          </table>
        </div>
        
        <div class="recu1">
          <h2>Total HT </h2>
          <h2>TVA  </h2>
          <h2>Total TTC </h2>
        </div>
        <div class="btns">
          <h4 class="valable">Offre valable jusq’au ..../..../.....</h4>
          <a class="btn btn-success" style="border-radius: 1.2rem; margin-right:.2rem">accepter</a>
          <a class="btn btn-error" style="margin-right: -18rem;border-radius: 1.2rem;">refuser</a> 
        </div>
        <a class="btn" style="background-color:#3A5A40; border-radius: 1.2rem;margin-right: 17rem;margin-top: 2rem;">Devis PDF</a>
        <button class="btn" style="margin-top:2rem; background-color:black; color:antiquewhite;border-radius: 1.2rem;">Close</button>
      </form>
    </div>
    
  </div>
</template>
<style scoped>
.valable{
  margin-top: -5rem;
  margin-left: -15rem;
  padding-bottom: 4rem;
}
.table {
  border-collapse: collapse; /* Ensure borders are collapsed */
  border: 1px solid rgb(164, 154, 154); /* Set the border color and width */
}

.table th, .table td {
  border: 1px solid rgb(164, 154, 154); /* Set the border color and width for table cells */
  padding: 8px; /* Add padding for better spacing */
}

.table th {
  background-color: #A3B18A; /* Optional: Set background color for table header */
}
.recu1{
  padding: 1rem;
  background-color: #A3B18A;
  text-align: left;
  width: 8rem;
  border-radius: .5rem;
  margin-left: 20rem;
  margin-bottom: 3rem;
  margin-top: 2rem;
}
.recu{
  padding: 1rem;
  background-color: #eaebe9;
  text-align: left;
  width: 8rem;
  margin-left: 20rem;
  margin-bottom: 1rem;

}
</style>

<script>
import axios from 'axios';

export default {
  methods: {
    async downloadPDF() {
      try {
        // Send a request to the server to generate the PDF
        const response = await axios.get('/generate-pdf', {
          responseType: 'blob' // Specify the response type as a blob
        });

        // Create a blob URL for the PDF response
        const blob = new Blob([response.data], { type: 'application/pdf' });
        const url = window.URL.createObjectURL(blob);

        // Create a link element and trigger the download
        const link = document.createElement('a');
        link.href = url;
        link.setAttribute('download', 'download.pdf');
        document.body.appendChild(link);
        link.click();

        // Clean up
        window.URL.revokeObjectURL(url);
        document.body.removeChild(link);
      } catch (error) {
        console.error('Error downloading PDF:', error);
      }
    },
  },
};
</script>
