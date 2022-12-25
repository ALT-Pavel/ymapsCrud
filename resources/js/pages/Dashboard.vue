<template>
  <div class="text-center">Привет {{ name }}!</div>
  <br />
  <div class="dashboard">
    <div class="col-8" v-if="showMap">
      <yandex-map ymap-class="yandex-map" v-bind="config" @click="handleClick">
        <div v-if="markers.length">
          <ymap-marker
            v-for="(marker, index) in markers"
            :key="marker.id"
            :markerId="marker.id"
            :coords="[marker.latitude, marker.longitude]"
            :options="{ draggable: true }"
            :balloon-template="customBalloon(marker)"
            v-bind="{
              icon: {
                layout: 'default#image',
                imageHref: markerIcon,
              },
              ...marker,
            }"
            @click="centerMap"
            @dragend="(e) => handleDragMarkerEnd(e, index)"
          />
        </div>
      </yandex-map>
    </div>
    <div class="col-4">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Latitude</th>
            <th>Longitude</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="marker in markers" :key="marker.id">
            <td>{{ marker.id }}</td>
            <td>{{ marker.name }}</td>
            <td>{{ marker.latitude.toFixed(4) }}</td>
            <td>{{ marker.longitude.toFixed(4) }}</td>
            <td>
              <div class="btn-group" role="group">
                <router-link
                  :to="`/markers/edit/${marker.id}`"
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
  </div>
</template>
    
    <script>
import { yandexMap, ymapMarker } from "vue-yandex-maps";
import markerIcon from "../../images/marker.svg";
const DEFAULT_CENTER = [58.604492, 49.656254];
export default {
  name: "Dashboard",
  components: { yandexMap, ymapMarker },
  data() {
    return {
      markerIcon,
      showMap: false,
      markers: [],
    };
  },
  props: {
    config: {
      default: () => ({
        zoom: "14",
        coords: DEFAULT_CENTER,
        settings: {
          apiKey: "",
          lang: "ru_RU",
          coordorder: "latlong",
          version: "2.1",
        },
      }),
    },
  },
  created() {
    if (window.Laravel.user) {
      this.name = window.Laravel.user.name;
      this.id = window.Laravel.user.id;
    }
    this.$axios
      .get("/sanctum/csrf-cookie")
      .then((responce) => {
        this.$axios
          .get("/api/markers/")
          .then((responce) => {
            this.markers = responce.data;
          })
          .catch(function (error) {
            console.log(error);
          });
      })
      .catch(function (error) {
        console.log(error);
      });
  },
  mounted() {
    this.showMap = true;
  },
  methods: {
    customBalloon(marker) {
      if (marker.name) {
        return `<div class='balloon'>
                      <div class='form-group'>
                          <label>Name</label>
                          <p>${marker.name}</p>
                      </div>
                  </div>`;
      } else {
        return `<div class='balloon'>
                      <div class='form-group'>
                        <a class="btn btn-info" href="/markers/add"> Add </a>
                      </div>
                  </div>`;
      }
    },
    centerMap(id) {
      console.log(id);
    },
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
    updateMarker(id) {
      this.$axios
        .get("/sanctum/csrf-cookie")
        .then((response) => {
          this.$axios
            .get(`/api/markers/edit/${id}`, this.marker)
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
    deleteMarker(id) {
      if (confirm("Are you sure?")) {
        this.$axios
          .get("/sanctum/csrf-cookie")
          .then((response) => {
            this.$axios
              .delete(`/api/markers/delete/${id}`)
              .then((response) => {
                let i = this.markers.map((item) => item.id).indexOf(id);
                this.markers.splice(i, 1);
              })
              .catch(function (error) {
                console.error(error);
              });
          })
          .catch(function (error) {
            console.log(error);
          });
      } else {
        console.log("wimp");
      }
    },
    handleClick(e) {
      if (typeof e.get === "function") {
        const [latitude, longitude] = e.get("coords");
        this.markers = [
          ...this.markers,
          { id: this.markers.at(-1).id + 1, latitude, longitude },
        ];
      }
    },
    handleDragMarkerEnd(e, id) {
      const [latitude, longitude] = e.get("target").geometry.getCoordinates();
      this.markers[id] = { ...this.markers[id], latitude, longitude };
    },
  },
};
</script>
    
    <style lang="scss">
.yandex-map {
  width: 100%;
  height: 400px;
  border-radius: 16px;
  overflow: hidden;
  margin-bottom: 16px;
}
.dashboard {
  display: flex;
  width: 100%;
  flex-direction: row-reverse;
}
</style>