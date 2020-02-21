<template>
  <div class="card-body">
    <template v-if="errors.length">
      <b-alert
        v-for="(error, index) in errors"
        :key="index"
        variant="warning"
        show
        dismissible
      >
        {{ error }}
      </b-alert>
    </template>

    <b-form
      @reset.prevent="onReset"
      @submit.prevent="onSubmit"
    >
      <b-form-group
        id="input-group-name"
        label="Document Name:"
        label-for="input-name"
      >
        <b-form-input
          id="input-name"
          v-model="document.name"
          required
          placeholder="Enter document name"
        />
      </b-form-group>

      <b-form-group
        label="Document description"
        label-for="textarea-description"
      >
        <b-form-textarea
          id="textarea-description"
          v-model="document.desc"
          placeholder="Enter your description"
        />
      </b-form-group>

      <b-form-group
        label="Attach image"
        label-for="file-image"
      >
        <b-form-file
          id="file-image"
          v-model="file"
          accept="image/*"
        />
      </b-form-group>

      <b-button type="submit" variant="primary">
        Submit
      </b-button>
      <b-button type="reset" variant="danger">
        Reset
      </b-button>
    </b-form>

    <b-img-lazy
      v-if="document.has_file"
      class="w-100 mt-3"
      :src="document.file.url"
      :alt="document.file.name"
    />
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'DocumentForm',
  props: {
    documentId: {
      type: Number,
      default: null
    }
  },
  data () {
    return {
      document: {},
      errors: [],
      file: null
    }
  },
  mounted () {
    if (this.documentId) {
      this.getDocument()
    }
  },
  destroyed () {
    this.document = null
  },
  methods: {
    getDocument () {
      axios.get('/v1/documents/' + this.documentId)
        .then((response) => {
          this.document = response.data
        })
        .catch((response) => {
          console.log(response)
          // alert('Failed to load document')
        })
    },
    onSubmit () {
      let formData = new FormData()

      if (this.document.id) {
        formData.append('id', this.document.id)
      }

      formData.append('name', this.document.name)
      formData.append('desc', this.document.desc)

      if (this.file) {
        formData.append('image', this.file)
      }

      axios.post('/v1/documents/', formData)
        .then((response) => {
          if (response.data.id) {
            this.$emit('store-document')
          }
        })
        .catch((errors) => {
          console.log(errors.response.data.errors)

          for (let key in errors.response.data.errors) {
            errors.response.data.errors[key].map(msg => {
              this.errors.push(msg)
            })
          }
        })
    },
    onReset () {
      this.document = {}
    }
  }
}
</script>
