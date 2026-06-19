<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Category;
use App\Models\AdPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdController extends Controller
{
    //toutes les annonces et/ou filtre
        public function index(Request $request){
            $query = Ad::with(['user', 'category', 'photos'])->latest();

            //recherche par titte
            if ($request->search){
                $query->where('title', 'like', '%' . $request->search . '%');
            }

            //par category
            if ($request->category){
                $query->where('category_id', $request->category);
            }

            //filtre par localisation
            if ($request->localisation){
                $query->where('localisation', 'like', '%' . $request->localisation . '%');
            }

            //filtre par prix min
            if ($request->min_price){
                $query->where('price', '>=', $request->min_price);
            }

            //filtre par prix max
            if ($request->max_price){
                $query->where('price', '<=', $request->max_price);
            }

            //filtre par condition
            if ($request->condition){
                $query->whereIn('condition', $request->condition);
            }

            $ads = $query->paginate(4);
            $categories = Category::all();
            return view('ads.index', compact('ads', 'categories'));
        }

    //annoces speci
        public function show($id){
            $ad = Ad::with(['user', 'category', 'photos'])->findOrFail($id);
            return view('ads.show', compact('ad'));
        }

        //formulaire pour crere une ad
            public function create(){
                $categories = Category::all();
                return view('ads.create', compact('categories'));
            }

        //suvegarder une add
            public function store(Request $request){
                $request->validate([
                    'title' => 'required|min:4',
                    'category_id' => 'required|exists:categories,id',
                    'description' => 'required|min:10',
                    'price' => 'required|numeric|min:0',
                    'localisation' => 'required',
                    'condition' => 'required|in:neuf,bon etat,abimé',
                    'photos' => 'required',
                    'photos.*' => 'image|mimes:jpeg,png,jpg|max:2048'
                ]);

                $ad = Ad::create([
                    'user_id' => Auth::id(),
                    'category_id' => $request->category_id,
                    'title'       => $request->title,
                    'description' => $request->description,
                    'price'       => $request->price,
                    'localisation'    => $request->localisation,
                    'condition'   => $request->condition
                ]);

                foreach($request->file('photos') as $photo){
                    $path = $photo->store('ads', 'public');
                    AdPhoto::create([
                        'ad_id' => $ad->id,
                        'path' => $path
                    ]);
                }

                return redirect('/ads/' . $ad->id);

            }

            //mogifier add
            public function edit($id){
                $ad = Ad::findOrFail($id);
                if ($ad->user_id !== Auth::id()){
                    return redirect('/');
                }
                $categories = Category::all();
                return view('ads.edit', compact('ad', 'categories'));
            }

            //sauvegarder la modifs
            public function update(Request $request, $id){
                $ad = Ad::findOrFail($id);
                if ($ad->user_id !== Auth::id()) {
                    return redirect('/');
                }

                $request->validate([
                    'title'       => 'required|min:4',
                    'category_id' => 'required|exists:categories,id',
                    'description' => 'required|min:10',
                    'price'       => 'required|numeric|min:0',
                    'localisation'    => 'required',
                    'condition'   => 'required|in:neuf,bon etat,abimé',
                    'photos.*'    => 'image|mimes:jpeg,png,jpg|max:2048'

                ]);

                $ad->update([
                    'category_id' => $request->category_id,
                    'title'       => $request->title,
                    'description' => $request->description,
                    'price'       => $request->price,
                    'localisation'    => $request->localisation,
                    'condition'   => $request->condition,
                ]);

                if ($request->hasFile('photos')) {
                    // Supprimer les anciennes photos
                    $ad->photos()->delete();

                    // Sauvegarder les nouvells
                    foreach ($request->file('photos') as $photo) {
                        $path = $photo->store('ads', 'public');
                        AdPhoto::create([
                            'ad_id' => $ad->id,
                            'path'  => $path,
                        ]);
                    }
                }

                return redirect('/ads/' . $ad->id);
            }

            //suprimer add
                public function destroy($id){
                    $ad = Ad::findOrFail($id);
                    if ($ad->user_id !== Auth::id()) {
                        return redirect('/');
                    }

                $ad->delete();
                return redirect('/');
                }

}
