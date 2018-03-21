<template>
    <div>
        <div id="map"></div>
        <input type="hidden" :name="lat_name" :value="position.lat">
        <input type="hidden" :name="lng_name" :value="position.lng">
    </div>
</template>

<script>
    export default {
        props: {
            lat_name: {
                type: String,
                required: true
            }, 
            lng_name: {
                type: String,
                required: true
            }, 
            lat: {
                type: Number,
                required: false,
                default: null
            }, 
            lng: {
                type: Number,
                required: false,
                default: null
            }
        },
        data () {
            return {
                map: null,
                init_zoom: 5.8,
                search_zoom: 12,
                marker: null,
                position: {
                    lat: null,
                    lng: null,
                },
                default_position: {
                    coords: {
                        latitude: 52.1,
                        longitude: 19.45
                    }
                }
            }
        },
        mounted () {
            this.position.lat = parseFloat(this.lat)
            this.position.lng = parseFloat(this.lng)

            if(this.position.lat && this.position.lng) {
                this.mapInit()
                this.runSearch(this.position)
                this.placeMarker(this.position)
                return true;
            }

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

                google.maps.event.addListener(this.map, 'click', (event) => {
                   this.placeMarker(event.latLng);
                });
            },
            runSearch (position) {
                this.map.zoom = this.search_zoom
                this.map.setCenter(position)
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
            findMe () {
                this.getUserPosition().then((position) => {
                    console.log('Goelocation work!')
                    this.runSearch(this.transformPosition(position))
                }).catch(() => {
                    console.error('Goelocation doesn\'t work!')
                    alert('We can\'t find your position now')
                })
            },
            placeMarker (location) {
                if(this.marker)
                    this.marker.setMap(null)
                this.marker = new google.maps.Marker({
                    position: location, 
                    map: this.map
                })
                this.position = this.transformPosition(location)
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
        height:400px;
        width: 100%;
   }
</style>