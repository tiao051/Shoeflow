@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-black text-center mb-8 uppercase">Find A Store</h1>

    <div class="max-w-2xl mx-auto mb-6 relative">
        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Start From (Leave empty to use GPS)</label>
        <div class="flex gap-2">
            <input type="text" id="user-address" 
                   placeholder="Enter your address (e.g., Ben Thanh Market, Ho Chi Minh)" 
                   class="w-full border border-gray-300 p-3 rounded-lg shadow-sm focus:ring-2 focus:ring-black focus:border-black transition"
                   onkeypress="if(event.key === 'Enter') Swal.fire('Hint', 'Please select a store below to calculate the route.', 'info')">
            
            <button onclick="locateUser()" class="bg-gray-200 text-gray-700 px-4 rounded-lg hover:bg-gray-300 transition" title="Use My Current Location">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </button>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-6 h-[600px]">
        
        <div class="lg:w-1/3 bg-white border border-gray-200 rounded-lg overflow-y-auto shadow-sm custom-scrollbar">
            @foreach($stores as $store)
            <div class="p-4 border-b border-gray-100 hover:bg-gray-50 cursor-pointer transition" 
                 onclick="focusOnMap({{ $store['lat'] }}, {{ $store['lng'] }})">
                <h3 class="font-bold text-lg">{{ $store['name'] }}</h3>
                <p class="text-gray-600 text-sm mt-1">{{ $store['address'] }}</p>
                
                <button onclick="getDirections({{ $store['lat'] }}, {{ $store['lng'] }}); event.stopPropagation();" 
                        class="mt-3 w-full bg-black text-white text-xs font-bold py-2 rounded hover:bg-red-600 flex items-center justify-center gap-2 transition transform active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0121 18.382V7.618a1 1 0 01-.553-.894L15 4m0 13V4m0 0L9 7" />
                    </svg>
                    GET DIRECTIONS
                </button>
            </div>
            @endforeach
        </div>

        <div class="lg:w-2/3 bg-gray-200 rounded-lg overflow-hidden relative shadow-md border border-gray-300">
            <div id="map" class="w-full h-full z-0"></div>
            
            <div id="map-loading" class="absolute inset-0 bg-white/90 flex flex-col items-center justify-center z-[1000] hidden">
                <svg class="animate-spin h-10 w-10 text-black mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="font-bold text-gray-800 text-sm" id="loading-text">Calculating Route...</span>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>

<script>
    let map;
    let routingControl = null;
    const storesData = @json($stores);

    // Define Custom Icons
    const storeIcon = L.icon({
        iconUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png',
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
        shadowSize: [41, 41]
    });

    const userIcon = L.divIcon({
        className: 'custom-user-icon',
        html: '<div style="background-color: #EF4444; width: 16px; height: 16px; border-radius: 50%; border: 3px solid white; box-shadow: 0 2px 5px rgba(0,0,0,0.3);"></div>',
        iconSize: [20, 20],
        iconAnchor: [10, 10]
    });

    document.addEventListener("DOMContentLoaded", function() {
        initMap();
    });

    function initMap() {
        // Initialize map centered on Ho Chi Minh City
        map = L.map('map').setView([10.774436, 106.702082], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { 
            maxZoom: 19, 
            attribution: '© OpenStreetMap' 
        }).addTo(map);

        // Add store markers
        storesData.forEach((store) => {
            L.marker([store.lat, store.lng], {icon: storeIcon})
             .addTo(map)
             .bindPopup(`<b>${store.name}</b><br>${store.address}`);
        });
    }

    function focusOnMap(lat, lng) {
        map.flyTo([lat, lng], 16, { duration: 1.5 });
    }

    // Helper: Locate User via Browser GPS
    function locateUser() {
        const loadingEl = document.getElementById('map-loading');
        const loadingText = document.getElementById('loading-text');
        
        loadingEl.style.display = 'flex';
        loadingText.innerText = 'Acquiring GPS signal...';
        
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (pos) => {
                    // Success
                    document.getElementById('user-address').value = ""; // Clear text to enforce GPS usage
                    loadingEl.style.display = 'none';
                    
                    Swal.fire({
                        icon: 'success',
                        title: 'Location Found',
                        text: 'Please select a store from the list to get directions.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                },
                () => {
                    // Error
                    loadingEl.style.display = 'none';
                    Swal.fire({
                        icon: 'warning',
                        title: 'Location Access Denied',
                        text: 'Could not retrieve your GPS location. Please enter your address manually.',
                        confirmButtonColor: '#000'
                    });
                }
            );
        } else {
            loadingEl.style.display = 'none';
            Swal.fire('Error', 'Your browser does not support Geolocation.', 'error');
        }
    }

    // Main Logic: Calculate and Draw Route
    async function getDirections(destLat, destLng) {
        const addressInput = document.getElementById('user-address').value.trim();
        const loadingEl = document.getElementById('map-loading');
        const loadingText = document.getElementById('loading-text');

        loadingEl.style.display = 'flex';

        // SCENARIO 1: User entered an address manually
        if (addressInput.length > 0) {
            loadingText.innerText = 'Searching address...';
            
            try {
                // Use Nominatim API for Geocoding
                const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(addressInput)}&limit=1`);
                const data = await response.json();

                if (data.length > 0) {
                    const userLat = parseFloat(data[0].lat);
                    const userLng = parseFloat(data[0].lon);
                    
                    drawRoute(userLat, userLng, destLat, destLng, addressInput);
                } else {
                    loadingEl.style.display = 'none';
                    Swal.fire({
                        icon: 'error',
                        title: 'Address Not Found',
                        text: 'Please try a more specific address (e.g., include City name).',
                        confirmButtonColor: '#000'
                    });
                }
            } catch (e) {
                console.error(e);
                loadingEl.style.display = 'none';
                Swal.fire('Error', 'Could not connect to map service.', 'error');
            }
        } 
        // SCENARIO 2: Input empty -> Use GPS
        else {
            loadingText.innerText = 'Getting GPS location...';
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        drawRoute(position.coords.latitude, position.coords.longitude, destLat, destLng, "Your Location");
                    },
                    (error) => {
                        // GPS Blocked/Error -> Fallback to Demo Location
                        console.warn("GPS Error, using Demo.");
                        useDemoLocation(destLat, destLng);
                    }
                );
            } else {
                useDemoLocation(destLat, destLng);
            }
        }
    }

    // Fallback function when GPS fails
    function useDemoLocation(destLat, destLng) {
        // Fake location: Ben Thanh Market
        const fakeLat = 10.7721; 
        const fakeLng = 106.6983;
        
        // Notify user nicely
        Swal.fire({
            icon: 'info',
            title: 'Demo Mode Active',
            text: 'Unable to access real location. Using "Ben Thanh Market" as the starting point for demonstration.',
            timer: 3000,
            showConfirmButton: false
        });

        drawRoute(fakeLat, fakeLng, destLat, destLng, "Demo Location");
    }

    // Core function to render route on map
    function drawRoute(startLat, startLng, destLat, destLng, startTitle) {
        document.getElementById('loading-text').innerText = 'Calculating optimal route...';

        if (routingControl) {
            map.removeControl(routingControl);
        }

        routingControl = L.Routing.control({
            waypoints: [
                L.latLng(startLat, startLng),
                L.latLng(destLat, destLng)
            ],
            routeWhileDragging: false,
            showAlternatives: false,
            fitSelectedRoutes: true,
            lineOptions: {
                styles: [{color: '#EF4444', opacity: 0.8, weight: 6}] // Converse Red styling
            },
            createMarker: function(i, waypoint, n) {
                // Only create marker for the starting point (i=0)
                if (i === 0) {
                    return L.marker(waypoint.latLng, {
                        icon: userIcon,
                        draggable: false
                    }).bindPopup("<b>Start:</b> " + startTitle).openPopup();
                }
                return null; // Destination already has a store marker
            },
            // Error handling for OSRM service
            router: L.Routing.osrmv1({
                serviceUrl: 'https://router.project-osrm.org/route/v1'
            })
        }).addTo(map);

        routingControl.on('routesfound', function(e) {
            document.getElementById('map-loading').style.display = 'none';
        });
        
        routingControl.on('routingerror', function() {
            document.getElementById('map-loading').style.display = 'none';
            Swal.fire({
                icon: 'error',
                title: 'Routing Error',
                text: 'The routing service is currently busy or unavailable. Please try again later.',
                confirmButtonColor: '#000'
            });
        });
    }
</script>

<style>
    #map { z-index: 1; }
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #888; border-radius: 3px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #555; }
    
    /* Hide the bulky default routing instructions panel */
    .leaflet-routing-container {
        display: none; 
    }
</style>
@endsection