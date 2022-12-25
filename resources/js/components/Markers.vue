<template>
  <div>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Latitude</th>
          <th>Longitude</th>
          <th>Created at</th>
          <th>Updated at</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="marker in markers" :key="marker.id">
          <td>{{ marker.id }}</td>
          <td>{{ marker.name }}</td>
          <td>{{ marker.latitude }}</td>
          <td>{{ marker.longitude }}</td>
          <td>{{ marker.created_at }}</td>
          <td>{{ marker.updated_at }}</td>
          <td>
            <div class="btn-group" role="group">
              <router-link
                :to="{ name: 'editmarker', params: { id: marker.id } }"
                class="btn btn-primary"
                >Edit
              </router-link>
              <button class="btn btn-danger" @click="deleteMarker(marker.id)">
                Delete
              </button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>

    <button
      type="button"
      class="btn btn-info"
      @click="this.$router.push('/markers/add')"
    >
      Add marker
    </button>
  </div>
</template>

<script>
export default {
  data() {
    return {
      markers: [],
    };
  },
  created() {
    this.$axios
      .get("/sanctum/csrf-cookie")
      .then((response) => {
        this.$axios
          .get("/api/markers")
          .then((response) => {
            this.markers = response.data;
          })
          .catch(function (error) {
            console.error(error);
          });
      })
      .catch(function (error) {
        console.log(error);
      });
  },
  methods: {
    deleteMarker(id) {
      this.$axios
        .get("/sanctum/csrf-cookie")
        .then((response) => {
          this.$axios
            .delete(`/api/markers/delete/${id}`)
            .then((response) => {
              let i = this.markers.map((item) => item.id).indexOf(id); // find index of your object
              this.markers.splice(i, 1);
            })
            .catch(function (error) {
              console.error(error);
            });
        })
        .catch(function (error) {
          console.log(error);
        });
    },
  },
  beforeRouteEnter(to, from, next) {
    if (!window.Laravel.isLoggedin) {
      window.location.href = "/";
    }
    next();
  },
};
</script>
