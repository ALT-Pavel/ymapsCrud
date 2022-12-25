<template>
  <div>
    <h4 class="text-center">Add Marker</h4>
    <div class="row">
      <div class="col-md-6">
        <form @submit.prevent="addMarker">
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
          <button type="submit" class="btn btn-primary">Add Marker</button>
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
  methods: {
    addMarker() {
      this.$axios
        .get("/sanctum/csrf-cookie")
        .then((response) => {
          this.$axios
            .post("/api/markers/add", this.marker)
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
