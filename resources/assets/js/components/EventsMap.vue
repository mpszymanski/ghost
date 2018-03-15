<template>
    <section id="map">
        
    </section>
</template>

<script>
    export default {
        data () {
            return {
                map: null,
                zoom: 12,
                default_position: {
                    coords: {
                        latitude: 52.409538,
                        longitude: 16.931992
                    }
                }
            }
        },
        mounted () {
            this.getPosition().then((position) => {
                console.log('Goelocation work!')
                let coords = this.transformPosition(position)
                this.mapInit(coords)
            }).catch(() => {
                console.error('Goelocation doesn\'t work!')
                this.mapInit(this.transformPosition(this.default_position))
            })
        },
        methods: {
            mapInit (position) {
                var user = position

                // Init map
                this.map = new google.maps.Map(document.getElementById('map'), {
                    zoom: this.zoom,
                    center: user
                })

                // Place user marker
                var marker = new google.maps.Marker({
                    position: user,
                    map: this.map
                })

                // Place event markers
                axios.get('/map/events/' + `${position.lat},${position.lng}`).then((response) => {
                    let markers = response.data
                    this.placeMarkers(markers)
                }).catch(() => {
                    console.error('Can not download events!')
                })
            },
            getPosition () {
                return new Promise(function(resolve, reject) {
                    if ("geolocation" in navigator) {
                        navigator.geolocation.getCurrentPosition((position) => {
                            resolve(position)
                        }, reject())
                    } else {
                        reject()
                    }
                });
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
                })
            },
            transformPosition (position) {
                return {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                }
            }
        },
    }
</script>

<style scoped>
    #map {
    height:500px;
    width: 100%;
   }
</style>