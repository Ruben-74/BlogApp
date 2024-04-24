<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PostRequest extends FormRequest
{
    /**
     * Pour pouvoir venir preparer un champ avant sa validation 
     * (ici le slug si l'user le laisse vide il sera slugifier a l'aide du titre passé ou l'user passe un slug
     *  avant d'etre soumis par les regles de validation)
     */
    protected function prepareForValidation() : void
    {
        $this->merge([
            'slug' => Str::slug($this->slug ? $this->slug : $this->title)
        ]);
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(Request $request): array
    {
        return [
            'title' => ['required', 'string', 'between:3,255'],
            'slug' => ['required', 'string','between:3,255', Rule::unique('posts')->ignore($this->post)], //le slug est unique excepté celui sur lequel on modifie sinon on se retrouve avec une erreur (en cas de maj)
            'content' =>['required', 'string', 'min:10'],
            'thumbnail' => [Rule::requiredIf($request->isMethod('post')), 'image'], //le champ image est seulement requis si on est sur une creation est pas une maj 
            //(on va verifier avec required if si $request utilise la methode post (creation) et pas patch (maj))
            'category_id' => ['required', 'integer', 'exists:categories,id'], //exists consiste a verifier si la valeur saisi est contenu dans notre table category au niveau des id
            'tag_id' => ['array', 'exists:tags,id'], //tags contient des id dans un tableau qui sera analyser pour savoir s'ils existent dans la table tag (id)
        ];
    }
}
