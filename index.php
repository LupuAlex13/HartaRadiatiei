<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Harta Radiatiei</title>
    <meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no">
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.4.0/mapbox-gl.css" rel="stylesheet">
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.4.0/mapbox-gl.js"></script>
    <style>
        body { margin: 0; padding: 0; }
        #map { position: absolute; top: 0; bottom: 0; width: 100%; }
    </style>
</head>
<body>
<style>
    .mapboxgl-popup {
        max-width: 400px;
        font: 12px/20px 'Helvetica Neue', Arial, Helvetica, sans-serif;
    }
</style>
<div id="map"></div>
<script>
    mapboxgl.accessToken = 'pk.eyJ1IjoibHVwdXNhbGV4IiwiYSI6ImNraGYwcTJ3cjBlNTcycm80emp0cWR5eTgifQ.7ZO9RkFPRcOPuZzXZqYvbw';
    const map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11',
        center: [26.102272, 44.437294],
        zoom: 11.15
    });

    map.on('load', () => {
        map.addSource('places', {
// This GeoJSON contains features that include an "icon"
// property. The value of the "icon" property corresponds
// to an image in the Mapbox Streets style's sprite.
            'type': 'geojson',
            'data': {
                'type': 'FeatureCollection',
                'features': [
                    {
                        'type': 'Feature',
                        'properties': {
                            'description':
                                '<strong>Piat Unirii</strong><p>Cea mai aglomerata zona a Bucurestiului</p>',
                            'icon': 'mark/orange.png'
                        },
                        'geometry': {
                            'type': 'Point',
                            'coordinates': [26.103728, 44.425411]
                        }
                    },
                    {
                        'type': 'Feature',
                        'properties': {
                            'description':
                                '<strong>Timpuri Noi</strong><p>O zona familiara tuturor</p>',
                            'icon': 'mark/orange.png'
                        },
                        'geometry': {
                            'type': 'Point',
                            'coordinates': [26.113754, 44.416605]
                        }
                    }
                ]
            }
        });
// Add a layer showing the places.
        map.addLayer({
            'id': 'places',
            'type': 'symbol',
            'source': 'places',
            'layout': {
                'icon-image': '{icon}',
                'icon-allow-overlap': true
            }
        });

// When a click event occurs on a feature in the places layer, open a popup at the
// location of the feature, with description HTML from its properties.
        map.on('click', 'places', (e) => {
// Copy coordinates array.
            const coordinates = e.features[0].geometry.coordinates.slice();
            const description = e.features[0].properties.description;

// Ensure that if the map is zoomed out such that multiple
// copies of the feature are visible, the popup appears
// over the copy being pointed to.
            while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
            }

            new mapboxgl.Popup()
                .setLngLat(coordinates)
                .setHTML(description)
                .addTo(map);
        });

// Change the cursor to a pointer when the mouse is over the places layer.
        map.on('mouseenter', 'places', () => {
            map.getCanvas().style.cursor = 'pointer';
        });

// Change it back to a pointer when it leaves.
        map.on('mouseleave', 'places', () => {
            map.getCanvas().style.cursor = '';
        });
    });
</script>

</body>
</html>