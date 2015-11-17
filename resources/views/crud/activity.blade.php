@extends('templates.default_crud')

@section('search')
    <div class="row">
        <form class="col s12" action="{{ route('home') }}" method="POST">
        	<div class="input-field col s3">
                <select>
        	        <option value="" disabled selected>Choose your option</option>
        	        <option value="1">Option 1</option>
        	        <option value="2">Option 2</option>
        	        <option value="3">Option 3</option>
                </select>
                <label>Parameters</label>
            </div>
            <div class="input-field col s7">
                <i class="material-icons prefix">search</i>
            	<input id="icon_search" type="text" class="validate">
                <label for="icon_search">Search</label>
            </div>
            <div class="input-field col s2">
                <button class="waves-effect waves-light btn" type="submit">Search</button>
            </div>
        </form>
    </div>
@stop

@section('fields')
    <div class="row">
        <form class="col s12" method="POST" action="{{ route('crud.activity') }}">

            <div class="row">
                <div class="input-field col s4">
                    <i class="material-icons prefix">toc</i>
                    <input id="name_" name="name" type="text" class="validate">
                    <label id="lname" for="icon_prefix">Name of Activity</label>
                </div>

                <div class="input-field col s4">
                    <i class="material-icons prefix">today</i>
                    <label id="lstart" class="light-blue-text darken-4">From</label>
                    <input type="date" id="start_" name="start"  class="datepicker" class="light-blue-text darken-4">
                </div>

                <div class="input-field col s4">
                    <i class="material-icons prefix">schedule</i>
                    <input id="startTime_" name="startTime" type="time" class="validate">
                    <label class="active" id="lstarttime_" for="startTime">Start Time:</label>
                </div>
            </div>


            <div class="row">
                <div class="input-field col s4">
                    <i class="material-icons prefix">today</i>
                    <label id="lend" class="light-blue-text darken-4">To</label>
                    <input type="date" id="end_" name="end" class="datepicker" class="light-blue-text darken-4">
                </div>

                <div class="input-field col s4">
                    <i class="material-icons prefix">schedule</i>
                    <input  id="endTime_" name="endTime" type="time" class="validate">
                    <label class="active" id="lendtime" for="endTime">End Time:</label>
                </div>

                <div class="input-field col s4">
                    <i class="material-icons prefix">room</i>
                    <input id="location_" name="location" type="text" class="validate">
                    <label id="llocation" for="icon_telephone">Location</label>
                </div>

            </div>

            <div class="row">

                <div class="input-field col s4">
                    <i class="material-icons prefix">perm_identity</i>
                    <input id="qnt_participants_" name="qnt_participants" type="number" class="validate">
                    <label id="lqnt_participants" for="icon_telephone">Quantity of Participants</label>
                </div>

                <div class="input-field col s4">
                    <select id="type_" name="type">
                        <option>Choose your option</option>
                        @foreach($types as $type)
                            <option value="{{$type['value']}}">{{$type['text']}}</option>
                        @endforeach
                    </select>
                    <label><i class="material-icons left">description</i>Tipo</label>
                </div>

                <div class="input-field col s4">
                    <select id="id_event_" name="id_event">
                        <option>Choose your option</option>
                            @foreach($events as $event)
                                <option value="{{$event->id}}">{{$event->name}}</option>
                            @endforeach
                    </select>
                    <label><i class="material-icons left">description</i>Evento</label>
                </div>
            </div>

            <div class="row">

                <div class="input-field col s3">
                    <button type="submit" class="waves-effect waves-light btn" onclick="setDates()"><i class="material-icons left">input</i>Inserir</button>
                </div>

                <div class="input-field col s3">
                    <button class="waves-effect waves-light btn"><i class="material-icons left">info_outline</i>Clear fields</button>
                </div>

            </div>

            <input type="hidden" id="_token" name="_token" value="{{ Session::token() }}">

        </form>
    </div>
@stop

@section('elements')

    @if($activities == null)
        <div class="card-panel red waves-effect waves-light" role="alert">
            "Nenhuma atividade foi cadastrado ainda."
        </div>
    @else
        <ul class="collection">
        @foreach($activities as $activity)
            <li class="collection-item avatar">
                <div class="row col s12">
                    <i class="material-icons left">toc</i>
                    <div class="col s3">
                        <span id="nameSearch" name="nameSearch">{{ $activity->name }}</span>
                    </div>

                    <i class="tiny material-icons left">description</i>
                    <div class="col s3">
                        <span id="typeSearch" name="typeSearch">{{ $events[array_search($activity->id_event, array_column($events, 'id'))]->name }} </span>
                    </div>

                    <?php
                          $activityString = $activity->name . "?" . $activity->start . "?" . $activity->startTime . "?" .
                                               $activity->end . "?" . $activity->endTime . "?" . $activity->location . "?" .
                                               $activity->qnt_participants . "?" . $activity->type . "?" . $activity->id_event . "?";
                        ?>
                    <button class="waves-effect waves-light btn" onclick="edit('{{ $activityString }}');"><i class="material-icons left">info_outline</i>Edit</button>
                    <a href="#modal1" class="waves-effect waves-light btn modal-trigger" onclick="modalSetText('{{ $activity->name }}');"><i class="material-icons left">delete</i>Delete</a>
                </div>
            </li>
        @endforeach
        </ul>
    @endif
@stop

<script type="text/javascript">
    window.onload = function() {
        document.formHeader.action = "{{ route('crud.activity.delete') }}";
    }
</script>

<script type="text/javascript">

    function edit( activityString ) {

        alert(activityString);

      var split = activityString.split('?');

        alert('1 ' + split[0]);

      document.getElementById("name_").value =  split[0];
      document.getElementById("lname").className += " active";


//      document.getElementById("start_").value = split[1];
//      document.getElementById("lstart").className += " active";

//      document.getElementById("starttime_").value = split[2].slice(0, 5);
//      document.getElementById("lstarttime").className += " active";


//      document.getElementById("end_").value = split[3];
//      document.getElementById("lend").className += " active";

//      document.getElementById("endtime_").value = split[4];
//      document.getElementById("lendtime").className += " active";

    alert('5 ' + split[5]);


      document.getElementById('location_').value = split[5];
      document.getElementById("llocation").className += " active";


      document.getElementById("qnt_participants_").value = split[6];
      document.getElementById("lqnt_participants").className += " active";

//      document.getElementById("course_").value = split[7];
//      document.getElementById("lcourse").className += " active";

//      document.getElementById("department_").value = split[8];
//      document.getElementById("ldepartment").className += " active";
    }
</script>

<script>
    function setDates(){

        var today = new Date(Date.parse(document.getElementById('start_').value));
        var dd = today.getDate();
        var mm = today.getMonth()+1; //January is 0!

        var yyyy = today.getFullYear();
        if(dd<10){
            dd='0'+dd
        }
        if(mm<10){
            mm='0'+mm
        }

        var today = yyyy+'-'+mm+'-'+dd;

        alert(today);
        document.getElementById('start_').value = today;

        // -----------------------------------------------------

        var today = new Date(Date.parse(document.getElementById('end_').value));
        var dd = today.getDate();
        var mm = today.getMonth()+1; //January is 0!

        var yyyy = today.getFullYear();
        if(dd<10){
            dd='0'+dd
        }
        if(mm<10){
            mm='0'+mm
        }

        var today = yyyy+'-'+mm+'-'+dd;

        alert(today);
        document.getElementById('end_').value = today;

    }
</script>