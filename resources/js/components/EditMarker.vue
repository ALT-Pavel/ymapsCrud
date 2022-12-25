<template>
  <div>
    <h4 class="text-center">Edit Marker</h4>
    <div class="row">
      <div class="col-md-6">
        <form @submit.prevent="updateMarker">
          <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" v-model="marker.name" />
          </div>
          <br />
          <div class="form-group">
            <label>Latitude</label>
            <input type="text" class="form-control" v-model="marker.latitude" />
          </div>
          <br />
          <div class="form-group">
            <label>Longitude</label>
            <input
              type="text"
              class="form-control"
              v-model="marker.longitude"
            />
          </div>
          <br />
          <button type="submit" class="btn btn-primary">Update Marker</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      marker: {},
    };
  },
  created() {
    this.$axios
      .get("/sanctum/csrf-cookie")
      .then((response) => {
        this.$axios
          .get(`/api/markers/edit/${this.$route.params.id}`)
          .then((response) => {
            this.marker = response.data;
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
    updateMarker() {
      this.$axios
        .get("/sanctum/csrf-cookie")
        .then((response) => {
          this.$axios
            .post(`/api/markers/update/${this.$route.params.id}`, this.marker)
            .then((response) => {
              this.$router.push({ name: "markers" });
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
