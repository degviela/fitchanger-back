<?php

namespace App\Http\Controllers;

use App\Models\Outfit;
use App\Models\ClothingItem;
use Illuminate\Http\Request;

class OutfitController extends Controller
{
    // funkcija index, kas iegūst visus outfitus
    public function index()
    {
        $outfits = Outfit::all();
        return response()->json($outfits);
    }

    //funkcija, kas iegūst outfitus pēc lietotāja ID
    public function getByUserId($userId)
    {
        $outfits = Outfit::where('user_id', $userId)->get();
        return response()->json($outfits);
    }

    // funkcija, kas ļauj izveidoy jaunu outfitu ieliekot ievades datu datubāzē
    public function store(Request $request)
    {
        //aizmugursistēmas validācijas, lai lietotājs neieliktu nepareizus datus
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'clothing_items' => 'required|array',
            'clothing_items.*.type' => 'required|in:head,top,bottom,footwear',
            'clothing_items.*.id' => 'required|exists:clothing_items,id',
        ]);

        //ja atbilst validācijas noteikumiem,
        // turpinās apģērbu kombināciju izpilde

        try {
            $clothingItemIds = [
                'head_id' => null,
                'top_id' => null,
                'bottom_id' => null,
                'footwear_id' => null,
            ];
            //iziet cauri visiem apģērbu veidiem un piešķirt to ID atbilstošajiem tipiem
            foreach ($request->clothing_items as $item) {
                switch ($item['type']) {
                    case 'head':
                        $clothingItemIds['head_id'] = $item['id'];
                        break;
                    case 'top':
                        $clothingItemIds['top_id'] = $item['id'];
                        break;
                    case 'bottom':
                        $clothingItemIds['bottom_id'] = $item['id'];
                        break;
                    case 'footwear':
                        $clothingItemIds['footwear_id'] = $item['id'];
                        break;
                }
            }

            $validatedData = array_merge($validatedData, $clothingItemIds);
            //izveido jaunu outfitu ar validētiem datiem
            $outfit = Outfit::create($validatedData);
            //izvada outfit
            return response()->json($outfit, 201);
        } catch (\Exception $e) {
            //ja notiek kļūda, atgriež kļūdas ziņojumu
            return response()->json(['error' => 'Server error'], 500);
        }
    }

    //parāda specifisku outfitu
    public function show($id)
    {
        //meklē outfit pēc ID
        $outfit = Outfit::find($id);
        //ja outfit nav atrasts, atgriež kļūdas ziņojumu
        if (!$outfit) {
            return response()->json(['message' => 'Outfit not found'], 404);
        }
        //ja outfit ir atrasts, atgriež outfit ar nosacīto ID
        return response()->json($outfit);
    }



    //funkcija, kas atjauno outfit datus
    public function update(Request $request, $id)
    {
        // validē izmaiņas
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'clothing_items' => 'required|array',
            'clothing_items.*.type' => 'required|in:head,top,bottom,footwear',
            'clothing_items.*.id' => 'required|exists:clothing_items,id',
        ]);

        try {
            //meklē outfit pēc ID
            $outfit = Outfit::findOrFail($id);
            //iestata visus drēbju ID no jauna
            $clothingItemIds = [
                'head_id' => null,
                'top_id' => null,
                'bottom_id' => null,
                'footwear_id' => null,
            ];
            //iziet cauri visiem apģērbu veidiem un piešķirt to ID atbilstošajiem tipiem
            foreach ($request->clothing_items as $item) {
                switch ($item['type']) {
                    case 'head':
                        $clothingItemIds['head_id'] = $item['id'];
                        break;
                    case 'top':
                        $clothingItemIds['top_id'] = $item['id'];
                        break;
                    case 'bottom':
                        $clothingItemIds['bottom_id'] = $item['id'];
                        break;
                    case 'footwear':
                        $clothingItemIds['footwear_id'] = $item['id'];
                        break;
                }
            }
            //apvieno validētos datus ar drēbju ID
            $validatedData = array_merge($validatedData, $clothingItemIds);
            //atjauno outfit ar validētiem datiem
            $outfit->update($validatedData);
            return response()->json($outfit, 200);
        } catch (\Exception $e) {
            //ja notiek kļūda, atgriež kļūdas ziņojumu
            return response()->json(['error' => 'Server error'], 500);
        }
    }


    //funkcija, kas dzēš outfit datus no datubāzes
    public function destroy($id)
    {

        try {
            //meklē outfit pēc ID
            $outfit = Outfit::findOrFail($id);
            //Ja atrod outfit, tad to dzēš
            $outfit->delete();
            return response()->json(null, 200);
        } catch (\Exception $e) {
            //ja notiek kļūda, atgriež kļūdas ziņojumu
            return response()->json(['error' => 'Server error'], 500);
        }
    }

}
