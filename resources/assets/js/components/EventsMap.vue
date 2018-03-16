<template>
    <section id="map-section">
        <form class="form-inline" id="map-form" @submit.prevent="findPlace">
            <div class="container">
                <div class="row justify-content-md-center">
                    <div class="col-md-6">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                                <button 
                                    class="btn btn-secondary" 
                                    type="button" 
                                    title="My location"
                                    @click="findMe"
                                >
                                    <i class="material-icons mt-2">my_location</i>
                                </button>
                            </div>
                            <input
                                type="text" 
                                class="form-control" 
                                v-model="address"
                                placeholder="Find event nearby" 
                                aria-label="Find event nearby" 
                                aria-describedby="basic-addon2"
                                required
                            >
                            <div class="input-group-append">
                                <button class="btn btn-secondary" type="submit">Search</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div id="map"></div>
    </section>
</template>

<script>
    export default {
        data () {
            return {
                map: null,
                init_zoom: 6,
                search_zoom: 12,
                address: '',
                markers: [],
                default_position: {
                    coords: {
                        latitude: 52.1,
                        longitude: 19.45
                    }
                }
            }
        },
        mounted () {
            this.getUserPosition().then((position) => {
                console.log('Goelocation work!')
                this.mapInit()
                this.runSearch(this.transformPosition(position))
            }).catch(() => {
                console.error('Goelocation doesn\'t work!')
                this.mapInit()
            })
        },
        methods: {
            mapInit () {
                let coords = this.transformPosition(this.default_position)

                // Init map
                this.map = new google.maps.Map(document.getElementById('map'), {
                    zoom: this.init_zoom,
                    center: coords
                })
            },
            runSearch (position) {
                this.map.zoom = this.search_zoom
                this.removeAllMarkers()
                this.getEvents(position)
                this.map.setCenter(position)
                this.placeUserMarker(position)
            },
            getUserPosition () {
                return new Promise(function(resolve, reject) {
                    if ("geolocation" in navigator) {
                        navigator.geolocation.watchPosition((position) => {
                            resolve(position)
                        }, reject())
                    } else {
                        reject()
                    }
                });
            },
            getEvents(position) {
                axios.get('/map/events/' + `${position.lat},${position.lng}`).then((response) => {
                    let markers = response.data
                    this.placeMarkers(markers)
                }).catch(() => {
                    console.error('Can not download events!')
                })
            },
            findPlace () {
                let geocoder = new google.maps.Geocoder()
                geocoder.geocode( { 'address': this.address}, (results, status) => {
                    if (status == 'OK') {
                        let position = this.transformPosition(results[0].geometry.location)
                        this.runSearch(position)
                    } else {
                        alert('Geocode was not successful for the following reason: ' + status);
                    }
                })
            },
            findMe () {
                this.getUserPosition().then((position) => {
                    console.log('Goelocation work!')
                    this.runSearch(this.transformPosition(position))
                }).catch(() => {
                    console.error('Goelocation doesn\'t work!')
                    alert('We can\'t find your position now')
                })
            },
            placeUserMarker (position) {
                var marker = new google.maps.Marker({
                    position: position,
                    map: this.map
                })
                this.markers.push(marker)
            },
            placeMarkers (markers) {
                var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
                var labelIndex = 0
                markers.forEach((mark) => {
                    var infowindow = new google.maps.InfoWindow({
                        content: mark.name
                    })
                    var marker = new google.maps.Marker({
                        position: mark.position,
                        map: this.map,
                        label: labels[labelIndex++ % labels.length],
                        title: mark.name
                    })
                    marker.addListener('click', function() {
                        infowindow.open(this.map, marker);
                    });
                    this.markers.push(marker)
                })
            },
            removeAllMarkers () {
                for (var i = 0; i < this.markers.length; i++) {
                    this.markers[i].setMap(null)
                }
                this.markers = []
            },
            transformPosition (position) {
                if(position.coords !== undefined) {
                    return {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    }
                } else {
                    return {
                        lat: position.lat(),
                        lng: position.lng()
                    }
                }
            }
        },
    }
</script>

<style scoped>
    #map-section {
        position: relative;
    }
    #map {
        height:500px;
        width: 100%;
   }
   #map-form {
        
   }
</style>