<!DOCTYPE html>
<html lang="de">

<head>
    <title>vHEMS - RescueTrack</title>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="./media/favicon.png" />

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
    <link rel="stylesheet" href="./css/index.css">
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>

    <script src="https://unpkg.com/leaflet.gridlayer.googlemutant@latest/dist/Leaflet.GoogleMutant.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyALMYSbib0J3i5xU5NUt4XPPzHX1Ll90u4" async defer></script>
    <script src="https://cdn.maptiler.com/mapbox-gl-js/v1.5.1/mapbox-gl.js"></script>
    <script src="https://cdn.maptiler.com/mapbox-gl-leaflet/latest/leaflet-mapbox-gl.js"></script>
    <script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-omnivore/v0.2.0/leaflet-omnivore.min.js'></script>
    <!---Konvert KML to geoJSON -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdn.maptiler.com/mapbox-gl-js/v1.5.1/mapbox-gl.css" />

</head>


<body>
    <html>

    <body>
        <div id="map"></div>
        <div class="rightBar hidden">
            <button class="toggleSide">
                <span class=" material-icons">
                    handyman
                </span></button>
            <div id="planeList" class="planeList">
            </div>
        </div>

    </body>

    </html>

    <script type="text/javascript">
        var dataNew = []
        var dataOld = []
        var markersShown = []
        var sideList = []
        var planeDiv = document.getElementById("planeList")


        var darkLayer = L.tileLayer('https://api.mapbox.com/styles/v1/mapbox/dark-v10/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoicHhsbG9ld2UiLCJhIjoiY2tpeDF1N3I5M29zZDJ2cWowdHhtMHNoYSJ9.tz-VKD3f41D0IjxsOOWUog', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            maxZoom: 18,
            id: 'mapbox/dark-v10',
            tileSize: 512,
            zoomOffset: -1,
            accessToken: 'pk.eyJ1IjoicHhsbG9ld2UiLCJhIjoiY2tpeDF1N3I5M29zZDJ2cWowdHhtMHNoYSJ9.tz-VKD3f41D0IjxsOOWUog'
        })

        var DarkMatter = L.mapboxGL({
            attribution: "\u003ca href=\"https://www.maptiler.com/copyright/\" target=\"_blank\"\u003e\u0026copy; MapTiler\u003c/a\u003e \u003ca href=\"https://www.openstreetmap.org/copyright\" target=\"_blank\"\u003e\u0026copy; OpenStreetMap contributors\u003c/a\u003e",
            style: 'https://api.maptiler.com/maps/62e52561-e915-4b01-8910-db867f5d88bf/style.json?key=4BB1IOnpAKW0l36TVJbL'
        })

        var roadMutant = L.gridLayer.googleMutant({
            maxZoom: 24,
            type: "roadmap",
        })

        var hybridMutant = L.gridLayer.googleMutant({
            maxZoom: 24,
            type: "hybrid",
        });

        var satMutant = L.gridLayer.googleMutant({
            maxZoom: 24,
            type: "satellite",
        });

        var terrainMutant = L.gridLayer.googleMutant({
            maxZoom: 24,
            type: "terrain",
        });

        var googleMaps = L.tileLayer()

        var mymap = L.map("map", {
            zoomSnap: 0.25,
            layers: [hybridMutant],
            center: [51.61668560448308, 10.123267161219689],
            zoom: 6,
        })
        var baseMaps = {
            "hybrid": hybridMutant,
            "darkLayer": darkLayer,
            "darkMatter": DarkMatter,
            "roadmap": roadMutant,
            "Satalite": satMutant,
            "Terrain": terrainMutant
        }
        var controllSettings = {
            position: "bottomleft"
        }
        //CONTROL-PANEL
        var mapControll = L.control.layers(baseMaps, null, controllSettings)
            .addTo(mymap)

        $.getJSON("./kml/Funkverkehrsbereiche.geojson", function(data) {
            var Funk = L.geoJson(data, {
                onEachFeature: function(feature, featureLayer) {
                    featureLayer.bindPopup(feature.properties.name)
                },
                style: {
                    opacity: 0.4,
                    fillOpacity: 0.2,
                }
            })

            mapControll.addOverlay(Funk, 'Funk')
        });
        $.getJSON("./kml/RTH.geojson", function(data) {
            var Funk = L.geoJson(data, {
                onEachFeature: function(feature, featureLayer) {
                    featureLayer.bindPopup(feature.properties.Name)
                    
                },
                style: {
                    opacity: 0,
                    fillOpacity: 0,
                }
            })

            mapControll.addOverlay(Funk, 'LRZs')
        });

        setInterval(() => {
            //übernehmen der alten Marker in Arrey und löschen neue
            $.get("/api/planes.php", async (data) => {
                if (data == "") return
                var dataJSON = JSON.parse(data)
                var dataArr = Object.entries(dataJSON)

                // update markers Array
                dataOld = dataNew
                dataNew = dataArr

                if (dataNew.length == dataOld.length) {
                    console.log("Amount of pilots same: refreshing pos only")
                    updateMarkers(dataArr, markersShown)
                } else {
                    console.log("refreshing map")
                    clearMarkers();
                    generateMarkers(dataArr)
                    showMarkers()

                }
            })
        }, 500)


        function clearMarkers() {
            for (var i = 0; i < markersShown.length; i++) {
                mymap.removeLayer(markersShown[i].marker);
            }
            markersShown = []
            planeDiv.innerHTML = "";
        }

        function generateMarkers(data) {
            var i = 0;
            while (i < data.length) {
                var dataInt = data[i]
                var dataReal = dataInt[1]

                var latitude = dataReal.latitude
                var longitude = dataReal.longitude

                var newMarker = L.marker([latitude, longitude])
                    .bindPopup(`${dataReal.name}`)

                //creating Div for List
                var element = document.createElement("div")


                element.innerHTML += `<img src="./media/${dataReal.icon}.png" onclick="scrollImg('${dataReal.ip}')">`

                element.innerHTML += `<h1 class="name" onclick="activateText('${sideList.length}', '${dataReal.ip}')">${dataReal.name}</h1>`

                element.innerHTML += `<button onclick="zoomTo('${dataReal.ip}')" class="zoomTo">Zoom to Plane</button>`

                element.className = "sideElement"

                sideList.push(element)



                markersShown.push({
                    marker: newMarker,
                    ip: dataReal.ip,
                    indexSideElement: sideList.length - 1
                })
                i++;
            }
        }

        function showMarkers() {


            for (var i = 0; i < markersShown.length; i++) {
                markersShown[i].marker
                    .addTo(mymap)
                planeDiv.appendChild(sideList[markersShown[i].indexSideElement])
            }
        }

        function getMarkerByIP(planes, ip) {
            for (var i = 0; i < planes.length; i++) {
                if (planes[i].ip == ip) return i;
            }
        }

        function updateMarkers(data, markerArr) {

            for (var i = 0; i < data.length; i++) {

                var dataInt = data[i]
                var dataReal = dataInt[1]

                var latitude = dataReal.latitude
                var longitude = dataReal.longitude
                var ip = dataReal.ip
                var icon = dataReal.icon + ".png"
                var currentMarkerIndex = getMarkerByIP(markerArr, ip)
                var currentPlane = markerArr[currentMarkerIndex]

                var myIcon = L.icon({
                    iconUrl: `./media/${icon}`,
                    iconSize: [100, 100],
                    iconAnchor: [50, 50],
                    popupAnchor: [0, -20],
                })

                currentPlane.marker
                    .setLatLng([latitude, longitude])
                    .setIcon(myIcon)
                    ._popup.setContent(`${getDisplayName(dataReal)}`)

                var imgSide = sideList[currentPlane.indexSideElement].getElementsByTagName("img")[0]
                imgSide.src = `./media/${dataReal.icon}.png`
                var nameSide = sideList[currentPlane.indexSideElement].getElementsByTagName("h1")[0]
                if (nameSide == undefined) return;
                nameSide.innerText = getDisplayName(dataReal)
            }
        }
        $('.toggleSide').click(event => {
            var sideBar = document.querySelector(".rightBar").classList.toggle("hidden")
        })

        function scrollImg(ip) {
            $.get({
                url: `https://vhems.pxlloewe.de/api/scrollIcon.php?ip=${ip}`,
            })
        }

        function rename(ip, name) {
            $.get({
                url: `https://vhems.pxlloewe.de/api/rename.php?ip=${ip}&name=${name}`,
            })
        }

        function activateText(parrentID, ip) {
            var parrent = sideList[parrentID]
            var h1El = parrent.getElementsByTagName("h1")[0]

            h1El.remove()


            parrent.innerHTML += `<input type="text" class="name" onkeydown="deactivateText('${parrentID}', event, '${ip}')">`

            parrent.getElementsByTagName("input")[0].focus()

        }

        function deactivateText(parrentID, event, ip) {

            var parrent = sideList[parrentID]
            var input = parrent.getElementsByTagName("input")[0]
            var newName = input.value
            if (event.key === 'Enter') {
                newName = newName.replaceAll(" ", "+")
                $.get({
                    url: "https://vhems.pxlloewe.de/api/rename.php",
                    data: {
                        name: newName,
                        ip: ip,
                    }
                })
                input.remove();
                parrent.innerHTML += `<h1 class="name" onclick="activateText('${parrentID}', '${ip}')"></h1>`
            }


            if (event.key === 'Escape') {
                input.remove()
                parrent.innerHTML += `<h1 class="name" onclick="activateText('${parrentID}', '${ip}')"></h1>`
            }


        }

        function zoomTo(ip) {

            var planeIndex = getMarkerByIP(markersShown, ip)

            var latlang = markersShown[planeIndex].marker.getLatLng()

            mymap.setView(latlang, mymap.getZoom(), {
                "animate": true,
                "pan": {
                    "duration": 2
                }
            })
        }

        function getDisplayName(dataReal) {
            if (!dataReal.customName) {
                return dataReal.name
            } else {
                return dataReal.customName
            }
        }
    </script>
</body>

</html>