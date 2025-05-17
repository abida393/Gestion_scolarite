<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
   public function index()
{
    // Récupérer toutes les news
    $news = News::orderBy('date_news', 'desc')->get();
    return view('responsable.news', compact('news'));
}

    // Ajouter une nouvelle news
    public function store(Request $request)
    {
        // Validation des données du formulaire
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'date_news' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Traitement de l'image si elle est présente
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images/news', 'public');
        }

        // Création et sauvegarde de la nouvelle news
        $news = new News();
        $news->title = $validatedData['title'];
        $news->content = $validatedData['content'];
        $news->date_news = $validatedData['date_news'];
        $news->image = $imagePath;
        $news->save();

        // Redirection avec un message de succès
        return redirect()->route('news.index')->with('success', 'News ajoutée avec succès!');
    }

    // Afficher le formulaire d'édition d'une news
   public function edit($id)
{
    // Récupérer la news à éditer
    $newsToEdit = News::findOrFail($id);

    // Récupérer toutes les news pour les passer à la vue
    $news = News::orderBy('date_news', 'desc')->get();
    
    // Retourner à la vue avec la news à éditer et toutes les news
    return view('responsable.news', compact('newsToEdit', 'news'));
}

    // Mettre à jour une news
    public function update(Request $request, $id)
    {
        // Validation des données du formulaire d'édition
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'date_news' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Trouver la news à mettre à jour
        $news = News::findOrFail($id);
        $imagePath = $news->image;

        // Si une nouvelle image est téléchargée
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            if ($news->image) {
                Storage::delete('public/' . $news->image);
            }
            // Sauvegarder la nouvelle image
            $imagePath = $request->file('image')->store('images/news', 'public');
        }

        // Mise à jour de la news avec les nouvelles données
        $news->update([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            'date_news' => $validatedData['date_news'],
            'image' => $imagePath,
        ]);

        // Redirection avec un message de succès
        return redirect()->route('news.index')->with('success', 'News mise à jour avec succès!');
    }

    // Supprimer une news
    public function destroy($id)
    {
        // Trouver la news à supprimer
        $news = News::findOrFail($id);

        // Supprimer l'image associée à la news si elle existe
        if ($news->image) {
            Storage::delete('public/' . $news->image);
        }

        // Supprimer la news de la base de données
        $news->delete();

        // Redirection avec un message de succès
        return redirect()->route('news.index')->with('success', 'News supprimée avec succès!');
    }
}
