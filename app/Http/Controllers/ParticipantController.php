<?php

namespace CTFlor\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Input;
use Illuminate\Support\Facades\Mail;
use CTFlor\Http\Requests;
use CTFlor\Http\Controllers\Controller;
use CTFlor\Models\Participant;
use CTFlor\Models\ActivityParticipant;
use CTFlor\Models\TechnicalVisitParticipant;
use Validator;

class ParticipantController extends Controller{

    public function participantIndex()
    {
        $participants = Participant::orderBy('name')->get();
        return view('crud.participant', compact('participants') );
    }

    public function searchParticipant(Request $request)
    {
        $this->validate($request,[
               'valueSearch'       => 'required',
               'radioSearch'       => 'required',
        ]);

        $param  = Input::get('radioSearch');
        $searchText = Input::get('valueSearch');


        if($param == "Name")              
            $results = Participant::where('name', 'LIKE' , $searchText . '%')->orderBy('name')->get();
        else if($param == "Location")     
            $results = Participant::where('location', 'LIKE' , $searchText . '%')->orderBy('location')->get();
        else      
            $results = Participant::where('type', 'LIKE' , $searchText . '%')->orderBy('type')->get();

        return view('crud.participant', compact('results'));
    }




    public function store(Request $request){

        //dd($request);

        $participante = Participant::find($request['id']);

        if($participante != null)
            return $this->alterRegister($request, $participante);
        else{
            $this->validate($request,[
                'name'			=> 'required',
                'cpf'			=> 'required|unique:participants',
                'email'			=> 'required',
                'phone'			=> 'required',
                'address'		=> 'required',
                'password'      => 'required',
                'type'			=> 'required|rparticipant',
            ]);

            if(Input::get('type') == "student")
            {
              $this->validate($request,[
                  'university'		=> 'required',
                  'course'			=> 'required',
              ]);
            }
            else if(Input::get('type') == "professor")
            {
              $this->validate($request,[
                  'university'		=> 'required',
                  'department'		=> 'required',
              ]);
            }

            $inputParticipant = $request->all();

            //Participant::create($inputParticipant);

            //Não alterar - ainda que fora do padrão

            // =====================================================

                DB::table('participants')->insert([
                    'name'              => Input::get('name'),
                    'cpf'               => Input::get('cpf'),
                    'email'             => Input::get('email'),
                    'phone'             => Input::get('phone'),
                    'address'           => Input::get('address'),
                    'password'          => bcrypt(Input::get('password')),
                    'type'              => Input::get('type'),
                    'university'        => Input::get('university'),
                    'course'            => Input::get('course'),
                    'department'        => Input::get('department'),
                    'responsability'    => Input::get('responsability'),
                ]);

            // +++++++++++++++++++++++++++++++++++++++++++++++++++++

            Mail::raw('Sua conta foi criada com sucesso na plataforma do CTFlor',
                function ($message)
                {
                  $message->to(Input::get('email'), Input::get('name'))->subject('CTFlor Sistema Web - Registro');
                }
            );

            return redirect()->back()->with('info', 'Conta criada com sucesso! Um email chegará em breve para você');
        }

    }

    public function deleteRegister(Request $request){

        $id = Input::get('modalMSGValue');

        Participant::where('name', '=', $id)->delete();

        return redirect()->back()->with('info', 'Participante excluído com sucesso!');
    }

    private function alterRegister(Request $request, $participante){

        //dd($request->all());

        $this->validate($request,[
                'name'          => 'required',
                'cpf'           => 'required',
                'email'         => 'required',
                'phone'         => 'required',
                'address'       => 'required',
                'password'      => 'required',
                'type'          => 'required|rparticipant',
            ]);

            if(Input::get('type') == "student")
            {
              $this->validate($request,[
                  'university'      => 'required',
                  'course'          => 'required',
              ]);
            }
            else if(Input::get('type') == "professor")
            {
              $this->validate($request,[
                  'university'      => 'required',
                  'department'      => 'required',
              ]);
            }

        $participante->update($request->all());
        return redirect()->back()->with('info', 'Participante atualizado com sucesso!');

    }



// ================================== Inscrição ATIVIDADES ===================================================


    public function subscribing(){

        $participants = Participant::orderBy('name')->get();


        $id_participant = '2';

        $lectures = ActivityParticipant::join('activities', 'activitiesparticipants.id_activity', '=', 'activities.id')
        ->select('activities.name as aName', 'activities.*', 'activitiesparticipants.role_participant')
        ->where('activitiesparticipants.id_participant', '=', $id_participant)
        ->where('activities.type', '=', 'lecture')
        ->orderBy('aName')
        ->get();


        $mini_courses = ActivityParticipant::join('activities', 'activitiesparticipants.id_activity', '=', 'activities.id')
        ->select('activities.name as aName', 'activities.*', 'activitiesparticipants.role_participant')
        ->where('activitiesparticipants.id_participant', '=', $id_participant)
        ->where('activities.type', '=', 'mini_course')
        ->orderBy('aName')
        ->get();

        $technical_visits = ActivityParticipant::join('activities', 'activitiesparticipants.id_activity', '=', 'activities.id')
        ->select('activities.name as aName', 'activities.*', 'activitiesparticipants.role_participant')
        ->where('activitiesparticipants.id_participant', '=', $id_participant)
        ->where('activities.type', '=', 'technical_visit')
        ->orderBy('aName')
        ->get();


        return view('lista.participantes', compact('lectures', 'mini_courses', 'technical_visits'));
    }

    public function subscribingSave(Request $request){


        $ids = explode('&', $request['allData'], -1);

        TechnicalVisitParticipant::where('id_activity', '=', $ids[0])->delete();

        $i = 1;
        $tam = count($ids);
        for (; $i < $tam; $i++) {
            technicalVisitParticipants::create(['id_activity' => $ids[0], 'id_participant' => $ids[$i]]);
        }

        return $this->same_subscribing($ids[0]);

    }

// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++


}
