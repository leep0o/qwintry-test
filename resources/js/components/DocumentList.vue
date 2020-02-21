<template>
  <div class="card-body">
    <table
      v-if="documents"
      class="table table-bordered table-striped table-responsive"
    >
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Desc</th>
          <th>Created</th>
          <th>File</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="(document, index) in documents"
          :key="index"
        >
          <td>{{ document.id }}</td>
          <td>{{ document.name }}</td>
          <td>{{ document.desc }}</td>
          <td>{{ document.created_at }}</td>
          <td>{{ document.has_file ? '+' : '-' }}</td>
          <td>
            <b-btn
              size="sm"
              variant="warning"
              @click="$emit('edit-document', { documentId: document.id })"
            >
              Edit
            </b-btn>
            <b-btn
              size="sm"
              variant="danger"
              @click="deleteDocument(document.id, index)"
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
    async getDocuments () {
      await axios.get('/v1/documents')
        .then((response) => {
          this.documents = response.data
        })
        .catch(() => {
          alert('Failed to load documents')
        })
    },
    async deleteDocument (id, index) {
      if (confirm('Are you sure you want to delete the document?')) {
        await axios.delete('/v1/documents/' + id)
          .then((response) => {
            if (response.data) {
              this.documents.splice(index, 1)
            }
          })
          .catch(() => {
            alert('Sorry! Failed to delete document.')
          })
      }
    }
  }
}
</script>
