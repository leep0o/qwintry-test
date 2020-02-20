<template>
  <div class="card-body">
    <table
      v-if="documents"
      class="table table-bordered table-striped"
    >
      <thead>
        <tr>
          <th>Name</th>
          <th>Desc</th>
          <th>Created</th>
          <th>File</th>
          <th width="100">
            Actions
          </th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="document in documents"
          :key="document.id"
        >
          <td>{{ document.name }}</td>
          <td>{{ document.desc }}</td>
          <td>{{ document.created_at }}</td>
          <td>{{ document.has_file ? 'Yes' : 'No' }}</td>

          <td>
            <b-btn
              size="sm"
              variant="warning"
              @click="editDocument(document.id)"
            >
              Edit
            </b-btn>
            <b-btn
              size="sm"
              variant="danger"
              @click="deleteDocument(document.id)"
            >
              Delete
            </b-btn>
          </td>
        </tr>
      </tbody>
    </table>
    <div
      v-else
      class="spinner-border"
      role="status"
    >
      <span class="sr-only">Loading...</span>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'DocumentList',
  data () {
    return {
      documents: null
    }
  },
  mounted () {
    this.getDocuments()
  },
  methods: {
    getDocuments () {
      axios.get('/v1/documents')
        .then((response) => {
          this.documents = response.data
        })
        .catch((response) => {
          console.log(response)
          alert('Не удалось загрузить')
        })
    },
    editDocument (id) {
      console.log('editDocument', id)
      // this.$store.dispatch('user/sendMessage', {
      //     to: this.pet.owner.id,
      //     message: this.message
      // }).then(() => {
      //     // this.$root.$emit('bv::hide::modal', 'modal-send-message')
      //
      //     // this.message = ''
      // })
    },
    deleteDocument (id) {
      console.log('deleteDocument', id)
    }
  }
}
</script>
