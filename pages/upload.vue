<template>
  <div>
    <div v-if="batchId">
      <h6 class="mb-3">Upload is in progress <span>({{ progress }})%</span></h6>
      <div class="progress">
        <div class="progress-bar progress-bar-striped progress-bar-animated" 
        role="progressbar" 
        aria-valuenow="progress" 
        aria-valuemin="0" 
        aria-valuemax="100" 
        :style="`width: ${progress}%`"></div>
      </div>
    </div>
    <div v-else>
      <h3 class="mb-3">Choose a file to upload</h3>
      <form @submit.prevent="uploadCSV" enctype="multipart/form-data" method="post">
        <div class="form-group">
          <input type="file" @change="handleFileChange" name="myfile">
          <button class="btn btn-dark" type="submit">Upload</button>
        </div>
      </form>
    </div>
  </div>
</template>
  
<script setup>
definePageMeta({
  layout: 'default'
});
const file = ref();
const batchId = ref();
const progress = ref(0);
const axios = useNuxtApp().$axios

function handleFileChange(event) {
  file.value = event.target.files[0];
}

async function uploadCSV() {
  const formData = new FormData();
  formData.append('myfile', file.value)
  await axios.post('/upload', formData).then((res) => {
    batchId.value = res.data.batch.id;
    localStorage.setItem('batchId' , batchId.value)
    getBatchDetail()
  }).catch((err) => {
    console.log(err)
  });
}

function getBatchDetail() {
  let progressResponse = setInterval(() => {
    axios.get(`/batch?id=${batchId.value}`).then((res) => {
      progress.value = res.data.progress
      if(progress.value === 100) {
        clearInterval(progressResponse);
        batchId.value = null
        localStorage.removeItem('batchId');
      }
    })
  }, 1000);
}

onMounted(() => {
  const storedBatchId = localStorage.getItem('batchId');
  if (storedBatchId) {
    batchId.value = storedBatchId;
    getBatchDetail();
  }
})
</script>
  
<style scoped>
.form-group {
  border: 1px solid rgb(104, 104, 104);
  border-radius: 5px;
  padding: 13px;
}
</style>