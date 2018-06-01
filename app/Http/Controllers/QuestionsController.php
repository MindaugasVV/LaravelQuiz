<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class QuestionsController extends Controller
{
    public $question_count = 10;

    public function index($id)
    {
        //Jeigu mūsų klausimai ir testo ID atitinka kas patalpinta ir pasirinkta Sesijoje, užkrauname ęsančius klausimus
        if(Session::get('questions') && Session::get('current_test') == $id){
            $question = $this->getActiveQuestion();
        }else{
            // Jeigu neatitinka, reiškias testas buvo pakeistas arba klausimai iš senesnių sprendimų buvo nerasti
            // todėl sugeneruosime naują klausimų masyvą
            Session::forget('answers');
            $question = $this->generateQuestions($id);
        }

        //Jeigu yra neatsakytų klausimų, atidarome vaizda su nauju klausimu
        if($question){
            return view('questions', [
                'current_question' => $question,
                'progress' => $this->calculateProgress(),
                'test_id' => $id
            ]);

        //Šioje vietoje neatsakytų klausimų neliko, todėl atidarome rezultatų atvaizdavimą
        }else{
            return view('results', [
                'progress' => $this->calculateProgress(),
                'points' => $this->calculatePoints(),
                'questions' => $this->resultBoard(),
                'answers' => $this->formatAnswersArray()
            ]);
        }
    }

    public function getActiveQuestion()
    {
        //Sukame ciklą ir tikriname kuris iš klausimų yra spręstas paskutinis, bet neatsakytas ir jį grąžiname į atvaizdavimą
        foreach(Session::get('questions') as $question){
            if($question['status'] == 1){
                return $this->getQuestion($question['id']);
            }
        }
    }

    public function generateQuestions($id)
    {
        //Sugeneruojame naujus klausimus atsitiktine tvarka ir patalpiname į masyvą su papildomais atributais
        //kaip id ir status. Status naudojame atskirti klausimus tarp neatsakyto/atsakyto/dabartinio
        $questions_array = array();
        $rand_questions = Question::where('test_id', $id)->take($this->question_count)->inRandomOrder()->get();
        //Šitokį klausimų saugojimo metodą galima panaudoti ir kuriant mygtuką "Atgal", kadangi sudarytas masyvas turi
        //pagal eiliškumą sudėtus klausimus, ir klausimams atskirti yra naudojamas dvimatis masyvas.
        //tokiu atveju galim tiesiog pasiimt dabartinio klausimo raktą ir jį sumažinti vienu, lengvai gauname ankstesnį klausimą
        foreach ($rand_questions as $question){
            $questions_array[] = [
                'id' => $question->id,
                'status' => 0,          //0 -> not answered, 1 -> current question, 2 -> answered
                ];
        }
        Session::put('questions', $questions_array);
        Session::put('current_test', $id);
        return $this->getRandomQuestionID($questions_array);
    }

    public function getRandomQuestionID($questions_array)
    {
        //Šitoje vietoje sukam ciklą ir ieškome dabartinio klausimo, tam kad ęsamą klausimą pažymėtume kaip atsakytu
        //Kuriant naują testą ši vieta praktiškai nenaudojama, bet einant prie kito klausimo, žymėjimas kas atsakyta ir koks
        //dabartinis masyvo elementas naudojamas yra privalomas norint atskirti po refresho kurį klausimą atvaizduoti
        $question_id = Null;
        foreach ($questions_array as $key => $question) {
            if ($question['status'] == 1) {
                $questions_array[$key]['status'] = 2;
                Session::put('questions', $questions_array);
            }
        }
        //Sukam ciklą per visus klausimus ir jeigu randame neatsakytą dar klausimą t.y kurio tipas yra 0
        //mes sustabdome ciklą, priskiriame naujai paimta elementa kaip Dabartiniu klausimu t.y 1
        // ir sumetam pakoreguotą masyvą i sessiją
        for($i=0; $i<= $this->question_count; $i++){
            $questions_array_key = array_rand($questions_array);
            if ($questions_array[$questions_array_key]['status'] == 0) {
                $questions_array[$questions_array_key]['status'] = 1;
                Session::put('questions', $questions_array);
                $question_id = $questions_array[$questions_array_key]['id'];
                break;
            }
        }
        //Čia tikriname ar buvo gražintas klausimo ID kuris pareina iš viršuje ęsančio for
        //jeigu mes gauname klausimo ID, keliaujame į kitą metodą kuris ištrauks iš duombazės norimą klausimą su atsakymais.
        if($question_id) return $this->getQuestion($question_id);
    }

    public function nextQuestion(Request $request)
    {
        //Mygtukas next question buvo paspaustas todėl bus atsitiktine tvarka išgautas ir sugeneruoto
        //klausimu masyvo naujas klausimas su atsakymais
        $this->getRandomQuestionID(Session::get('questions'));
        //Pasiimam iš sesijos esantį atsakymų masyvą ir jam priskiriam pakoreaguotą reikšmę, kuri
        //ateina iš naujai atsakyto klausimo.
        $answers_array = Session::get('answers');
        $answers_array[] = [
            'question_id' => $request->question_id,
            'answer_id' => $request->answer_id
        ];
        Session::put('answers', $answers_array);
        //Kadangi index metodas automatiškai tikrina Sessiją, mums tereikia išsaugoti atsakymys ir redirectinti
        //į pradinį testo puslapi ir viskas bus sugeneruojama automatiškai (Klausimai, atsakymai ir tt)
        return redirect()->route('testas', $request->test_id);
    }

    public function getQuestion($id)
    {
        //Išsitraukiam klausimą ir naudojam ryšį norint išgauti surištus atsakymus su klausimu
        return Question::with('Answers')->find($id);
    }

    public function calculateProgress()
    {
        //Apskaičiuojame procentais kokią dalį testo jau išsprendėme
        $answered_count = 0;
        foreach (Session::get('questions') as $question) {
            if($question['status'] == 2){
                $answered_count++;
            }
        }
        return $answered_count*100/$this->question_count;
    }

    public static function calculatePoints()
    {
        //Šiame metode naudojami atsakymo ID (iš sessijos) kurie veliau verčiami į pointus per vieną SQL užklausą,
        // tam kad Useris negalėtu inputo value reikšmių sukčiaudamas prisirašyti :))
        $answers_id_array = array();
        $points = 0;
        //Čia vykdoma optimizacija sistemos. Aišku galėjome tiesiog paleisti foreach ir išsitraukti duomenis,
        // bet tokiu atveju susidarytų mažiausiai 10 SQL užklausų.
        //Todėl pirmiausiai yra susitvarkoma su lokaliais duomenimis.
        //Susiformatuojam sessijos duomenis į tokį masyva kurį galėtume naudoti query užklausai
        foreach(Session::get('answers') as $answer){
            $answers_id_array[] = $answer['answer_id'];
        }
        //Čia mūsų naujai sukurtas masyvas atrodo šitaip: [5,4,3,6,2]. Masyve laikome atsakymų indexus kurie bus naudojami queryje
        //Čia viena užklausa išsitraukiame visus atsakymus kuriuos Useris buvo pasirinkęs
        $answers = Answer::whereIn('id', $answers_id_array)->get();
        //Sukame cikla per visus jo atsakymus ir sumuojam taškus
        foreach ($answers as $answer){
            $points += $answer->points;
        }
        return $points;
        //Tarp kitko, taškai yra sumuojami tik ant pačio galo kai visi klausimai yra atsakyti. Tokiu atvėju taškai niekur nedingsta
        //ir neatsiranda tarpiniu SQL užklausų kol Useris neišsprendė testo
    }

    public function resultBoard(){
        //Praktiškai darome viską kaip ir su taškais, tik prie to dar pridedam ryšį, kad nereiktų 2 kartus
        //kreiptis į SQL gaunant klausimus ir atsakymus.
        foreach(Session::get('answers') as $answer){
            $questions_id_array[] = $answer['question_id'];
        }
        $questions = Question::whereIn('id', $questions_id_array)->with('Answers')->get();
        return $questions;
    }

    public function formatAnswersArray(){
        //Ši vieta užduotyje nebuvo nūrodyta, bet norėjosi kažko patrauklaus akiai,
        // kad aiškiai matytūsi kokie klausimai buvo ir kuriuos Useris suklydo,
        //tai čia tiesiog formatuojam sesijoje laikomus atsakymų ID kuriuos veliau naudojam
        //gražiam ir aiškiam atsakymu ir klaidų atvaizdavimui
        //SQL užklausų nebuvo naudota šioje vietoje, todėl krovimo atžvilgiu skirtumo nėra.
        $answers_id_array = array();
        foreach(Session::get('answers') as $answer){
            $answers_id_array[] = $answer['answer_id'];
        }
        return $answers_id_array;
    }

    public function resetTest(){
        //Kadangi resetinant testą mums vistiek reikia žinoti koks visgi tas testas buvo pasirinktas,
        //negalim tiesiog flushint Sessijos kuri laiko dabartinio testo ID. Tiesiog pravalom
        //sugeneruotus random klausimus ir atsakymus ir visą kitą musų index metodas pats sugeneruos.
        Session::forget('questions');
        Session::forget('answers');
        return redirect()->route('testas', Session::get('current_test'));
    }

    public function selectNewTest(){
        //Jeigu jau renkamės naują testą, tada jau nebesvarbūs jokie Sessijos duomenis todel tiesiog flushinam ir
        //redirectinam useri prie visų testų.
        Session::flush();
        return redirect('/');
    }
}
