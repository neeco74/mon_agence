jQuery(function () {

    let $contactButton = $('#contactButton')
    $contactButton.click(function (e) {
        e.preventDefault()
        $('#contactForm').slideDown();
        $contactButton.slideUp();
    })


    // Suppression des pictures

    // Gestion des boutons "Supprimer"
    let links = document.querySelectorAll("[data-delete]")

    // On boucle sur links
    for (link of links) {
        // On écoute le clic
        link.addEventListener("click", function (e) {
            // On empêche la navigation
            e.preventDefault()

            // On demande confirmation
            if (confirm("Voulez-vous supprimer cette image ?")) {
                // On envoie une requête Ajax vers le href du lien avec la méthode DELETE
                fetch(this.getAttribute("href"), {
                    method: "DELETE",
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({ "_token": this.dataset.token })
                }).then(
                    // On récupère la réponse en JSON
                    response => response.json()
                ).then(data => {
                    if (data.success)
                        this.parentElement.remove()
                    else
                        alert(data.error)
                }).catch(e => alert(e))
            }
        })
    }




    //require('https://unpkg.com/leaflet@1.7.1/dist/leaflet.css');




    class Map {

        static init() {
            let map = document.querySelector('#map')
            if (map === null) {
                return
            }
            let icon = L.icon({
                iconUrl: '/images/marker-icon.png',
            })
            let center = [map.dataset.lat, map.dataset.lng]
            map = L.map('map').setView([villeLat, villeLng], 11)
            let accesstoken = 'pk.eyJ1IjoibmVlY28iLCJhIjoiY2tscnVpa3Z4MWdsZDJ2cW1qc2duMDVzZSJ9.B_hdZvl3AbuVmUqvF4Ms1w'

            L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
                attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                maxZoom: 18,
                minZoom: 5,
                id: 'mapbox/streets-v11',
                tileSize: 512,
                zoomOffset: -1,
                accessToken: 'pk.eyJ1IjoibmVlY28iLCJhIjoiY2tscnVpa3Z4MWdsZDJ2cW1qc2duMDVzZSJ9.B_hdZvl3AbuVmUqvF4Ms1w'
            }).addTo(map);



            //L.marker([51.505, -0.09]).addTo(map)



            
            for (let ville in villes) {
                var marker = L.marker([villes[ville].lat, villes[ville].lon]).addTo(map);
            }  
        }

    }





    Map.init()


    let inputAddress = document.querySelector('#biens_address')
    if (inputAddress !== null) {
        let place = places({
            container: inputAddress
        })
        place.on('change', e => {
            document.querySelector('#biens_city').value = e.suggestion.city
            document.querySelector('#biens_postal_code').value = e.suggestion.postcode
            document.querySelector('#biens_lat').value = e.suggestion.latlng.lat
            document.querySelector('#biens_lng').value = e.suggestion.latlng.lng
        })
    }










});
