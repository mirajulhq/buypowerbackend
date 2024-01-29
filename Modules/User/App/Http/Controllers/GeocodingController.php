<?php

namespace Modules\User\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use GuzzleHttp\Client;

class GeocodingController extends Controller
{
    public function getRegionInfo($latitude, $longitude)
    {
        // Replace 'YOUR_GOOGLE_API_KEY' with your actual API key
        $apiKey = 'AIzaSyD0FeNTACOETan6R_fJ18o5kSgTyoAFabk';

        // Google Maps Geocoding API endpoint
        $apiEndpoint = 'https://maps.googleapis.com/maps/api/geocode/json';

        // Make the API request
        $client = new Client();
        $response = $client->get($apiEndpoint, [
            'query' => [
                'latlng' => $latitude . ',' . $longitude,
                'key' => $apiKey,
            ],
        ]);

        // Decode the JSON response
        $data = json_decode($response->getBody(), true);

        // Extract region information (you may need to customize this based on the API response)
        $regionInfo = null;
        // if (isset($data['results'][0]['address_components'])) {
        //     foreach ($data['results'][0]['address_components'] as $component) {
        //         if (in_array('administrative_area_level_1', $component['types'])) {
        //             $regionInfo = $component['long_name'];
        //             break;
        //         }
        //     }
        // }
        if (isset($data['results'])) {
            foreach ($data['results'] as $component) {
                if (isset($component['address_components'])) {
                    foreach ($component['address_components'] as $key => $value) {
                        if (in_array('administrative_area_level_1', $value['types'])) {
                            $regionInfo = $value['long_name'];
                            break;
                        }
                    }
                }
            }
        }

        // Return the region information
        // return response()->json(['region' => $regionInfo]);
        return $regionInfo;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('user::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('user::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('user::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
