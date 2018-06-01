<?php

namespace App\Http\Controllers;

use App\Result;
use Illuminate\Http\Request;

class ResultsController extends Controller
{
    public function showSave()
    {
        return view('resultSave');
    }

    public function saveResult(Request $request){

        //Kadangi pradėjau kurti lietuviškai tai ir užbaigiau taip pat, prirašiau lietuvišką validaciją, nors ir vienas
        // fieldas, bet atrodo daug geriau kai viskas lietuviška.
        $messages = [
            'name.required' => 'Vardas privalo būti užpildytas'
        ];

        //Taisyklės...
        $rules = [
            'name' => 'required'
        ];

        //Paleidžiam validaciją...
        $this->validate($request, $rules, $messages);

        //Validacija praėjo, todėl galim sukurti naują objektą, priskirti jam atributus ir saugoti į duombazę
        $result = new Result();
        $result->name = $request->name;
        //Čia čiumpam statinį metodą iš Question kontroleriaus kuris duomenis ištraukia iš Sessijos.
        //Buvo planuota tiesiog persimesti duomenis per hidden fieldus, bet tokiu atveju Useris gali sukčiauti
        //ir atsidaręs inspecta susivesti norimą pointų skaičių :))
        $result->points = QuestionsController::calculatePoints();
        $result->save();

        return redirect('/');
    }
}
