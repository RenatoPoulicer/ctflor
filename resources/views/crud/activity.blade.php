@extends('templates.default_crud')

@section('subheader')
    <br><br>
        <h1 class="header center green-text text-darken-3">Atividades</h1>
        <div class="row center">
          <h5 class="header col s12 light">Você pode buscar, criar, alterar e excluir Atividades</h5>
        </div>
    <br><br>
@stop

@section('search')
    <div class="row">
      <div class="card card-panel">
          <form class="col s12" action="{{ route('crud.activity.search') }}" method="POST">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

              <div class="input-field col s4">
                   <p>
                     <input name="radioSearch" type="radio" id="nameSearch_" value="Name" />
                     <label for="nameSearch_">Nome</label>

                     <input name="radioSearch" type="radio" id="locationSearch_" value="Location" />
                     <label for="locationSearch_">Localização</label>

                     <input name="radioSearch" type="radio" id="typeSearch_" value="Tipe" />
                     <label for="typeSearch_">Tipo</label>
                   </p>
               </div>
               <div class="input-field col s6">
                   <i class="material-icons prefix">search</i>
                   <input name="valueSearch" id="icon_search" type="text" class="validate">
                   <label for="icon_search">Buscar</label>
               </div>

              <div class="input-field col s2">
                  <button class="waves-effect waves-light btn" type="submit">Buscar</button>
              </div>

          </form>
      </div>
    </div>
@stop

@section('fields')
    <div class="row">
      <div class="card card-panel">

            <form id="formSubmit" class="col s12" method="POST" action="{{ route('crud.activity') }}">

                @if($errors->any())
                    <div class="card-panel red waves-effect waves-light" role="alert">
                        <p>
                        @foreach($errors->all() as $error)
                          {{ $error }}
                        @endforeach
                        </p>
                    </div>
                @endif


                <div class="row">

                    <div class="input-field" style="visibility:hidden">
                        <i class="material-icons prefix">toc</i>
                        <input id="id_" name="id" type="number" class="validate" value="-1">
                        <label id="lid" for="icon_prefix">ID:</label>
                    </div>

                    <div class="input-field col s4">
                        <i class="material-icons prefix">toc</i>
                        <input id="name_" name="name" type="text" class="validate">
                        <label id="lname" for="icon_prefix">Nome da Atividade</label>
                    </div>

                    <div class="input-field col s4">
                        <i class="material-icons prefix">today</i>
                        <label id="lstart" class="light-blue-text darken-4">Data Início</label>
                        <input type="date" id="start_" name="start"  class="datepicker" class="light-blue-text darken-4" >
                    </div>

                    <div class="input-field col s4">
                        <i class="material-icons prefix">schedule</i>
                        <input id="startTime_" name="startTime" type="text" class="timepicker">
                        <label id="lStartTime_">Hora Início:</label>
                    </div>

                    <script>
                      $('#startTime_').pickatime({   twelvehour: false  });
                    </script>


                </div>


                <div class="row">
                    <div class="input-field col s4">
                        <i class="material-icons prefix">today</i>
                        <label id="lend" class="light-blue-text darken-4">Data Fim</label>
                        <input type="date" id="end_" name="end" class="datepicker" class="light-blue-text darken-4">
                    </div>

                    <div class="input-field col s4">
                        <i class="material-icons prefix">schedule</i>
                        <input id="endTime_" name="endTime" type="text" class="timepicker">
                        <label id="lEndTime_">Hora Término:</label>
                    </div>

                    <script>
                      $('#endTime_').pickatime({   twelvehour: false  });
                    </script>

                    <div class="input-field col s4">
                        <i class="material-icons prefix">room</i>
                        <input id="location_" name="location" type="text" class="validate">
                        <label id="llocation" for="icon_telephone">Locatização</label>
                    </div>

                </div>

                <div class="row">

                    <div class="input-field col s4">
                        <i class="material-icons prefix">perm_identity</i>
                        <input id="qnt_participants_" name="qnt_participants" type="number" class="validate">
                        <label id="lqnt_participants" for="icon_telephone">Quantidade de Participantes</label>
                    </div>

                    <div class="input-field col s4">
                        <select id="type_" name="type">
                            <option>Escolha uma opção</option>
                            @foreach($types as $type)
                                <option value="{{$type['value']}}">{{$type['text']}}</option>
                            @endforeach
                        </select>
                        <label><i class="material-icons left">description</i>Tipo</label>
                    </div>

                    <div class="input-field col s4">
                        <select id="id_event_" name="id_event">
                            <option>Escolha uma opção</option>
                                @foreach($events as $event)
                                    <option value="{{$event->id}}">{{$event->name}}</option>
                                @endforeach
                        </select>
                        <label><i class="material-icons left">description</i>Evento</label>
                    </div>
                </div>

                <div class="row">

                    <div class="input-field col s4">
                        <i class="material-icons prefix">payment</i>
                        <input id="priceActivity_" name="priceActivity" type="number" class="validate">
                        <label id="lPriceActivity" for="icon_telephone">Preço</label>
                    </div>

                </div>

                <div class="row">

                    <div class="input-field col s3">
                        <button id="incluir_alterar" type="submit" class="waves-effect waves-light btn" onclick="setDates();">
                          <i class="material-icons left">input</i>
                          Inserir
                        </button>
                    </div>

                    <div class="input-field col s3">

                        <button type="reset" class="waves-effect waves-light btn" onclick="clearFields()">
                          <i class="material-icons left">info_outline</i>
                          Limpar Campos
                        </button>
                    </div>

                    <div id="cancelar" class="input-field col s3" style="visibility:hidden">

                        <button type="reset" class="waves-effect waves-light btn" onclick="cancelAll()">

                          <i class="material-icons left">info_outline</i>
                          Cancelar
                        </button>
                    </div>

                </div>

                <input type="hidden" id="_token" name="_token" value="{{ Session::token() }}">

            </form>
      </div>
    </div>
@stop

@section('elements')
    <div class="row">
        <div class="card card-panel">

          @if(isset($results))
                @if($results->count() == 0)
                    <div class="card-panel red waves-effect waves-light" role="alert">
                        "No activity has been found."
                    </div>
                @else
                    <table class="responsive-table">
                    @foreach($results as $result)
                        <?php
                            foreach ($events as $event)   
                                if($event->{'id'} == $result->id_event)     
                                    $nameEvent = $event->{'name'};

                            foreach ($types as $type)     
                                if($type['value'] == $result->type)         
                                    $typeActivity = $type['text'];
                        ?>
                        <tr>
                            <td>
                                <i class="material-icons left">description</i> <span id="nameSearch" name="nameSearch">{{ $nameEvent }}</span>
                            </td>

                            <td>
                                <i class="tiny material-icons left">description</i> <span id="typeSearch" name="typeSearch">{{ $typeActivity }} </span>
                            </td>

                            <td>
                                <i class="tiny material-icons left">toc</i> <span id="typeSearch" name="typeSearch">{{ $result->name }} </span>
                            </td>

                            <td>
                                <i class="tiny material-icons left">room</i> <span id="typeSearch" name="typeSearch">{{ $result->location }} </span>
                            </td>
                        </tr>
                    @endforeach
                    </table>
                @endif
          @else
                @if($activities == null || $activities->count() == 0)
                    <div class="card-panel red waves-effect waves-light" role="alert">"Nenhuma Atividade foi registrada ainda."</div>
                @else
                        <table class="responsive-table">
                            @foreach($activities as $activity)
                              <?php
                                  foreach ($events as $event)     
                                      if($event->{'id'} == $activity->id_event)     
                                          $nameEvent = $event->{'name'};

                                  foreach ($types as $type)       
                                      if($type['value'] == $activity->type)         
                                          $typeActivity = $type['text'];
                              ?>
                              <tr>

                                    <td>
                                        <i class="tiny material-icons left">description</i> <span id="typeSearch" name="typeSearch"> {{ $nameEvent }} </span>
                                    </td>

                                    <td>
                                        <i class="tiny material-icons left">description</i> <span id="typeSearch" name="typeSearch"> {{ $typeActivity }} </span>
                                    </td>


                                    <td>
                                        <i class="material-icons left">toc</i> <span id="nameSearch" name="nameSearch">{{ $activity->name }}</span>
                                    </td>

                                    <?php
                                          $activityString = $activity->id . "?" .$activity->name . "?" . $activity->start . "?" . $activity->startTime . "?" .
                                                            $activity->end . "?" . $activity->endTime . "?" . $activity->location . "?" .
                                                            $activity->qnt_participants . "?" . $activity->type . "?" . $activity->id_event . "?" . $activity->priceActivity;
                                    ?>
                                    <td>
                                        <button class="waves-effect waves-light btn" onclick="edit('{{ $activityString }}');"> <i class="material-icons left">info_outline</i> Editar </button>
                                    </td>
                                    <td>
                                        <a href="#modal1" class="waves-effect waves-light btn modal-trigger" onclick="modalSetText('{{ $activity->name }}');"> <i class="material-icons left">delete</i>Excluir</a>
                                    </td>
                              </tr>
                            @endforeach
                        </table>
                    </div>
                @endif
        @endif
    </div>
@stop



<script type="text/javascript">

    window.onload = function() {
        document.formHeader.action = "{{ route('crud.activity.delete') }}";
    }


    function edit( activityString ) {

      //alert(activityString);

      var split = activityString.split('?');

      document.getElementById("id_").value =  split[0];
      document.getElementById("lid").className += " active";

      document.getElementById("name_").value =  split[1];
      document.getElementById("lname").className += " active";

      setDatesBack(split[2], 'start_');
      document.getElementById("lstart").className += " active";

      document.getElementById("startTime_").value =  split[3].substring(0, 5);
      document.getElementById("lStartTime_").className += " active";

      setDatesBack(split[4], 'end_');
      document.getElementById("lend").className += " active";

      document.getElementById("endTime_").value =  split[5].substring(0, 5);
      document.getElementById("lEndTime_").className += " active";

      document.getElementById('location_').value = split[6];
      document.getElementById("llocation").className += " active";

      document.getElementById("qnt_participants_").value = split[7];
      document.getElementById("lqnt_participants").className += " active";

      /*
      alert('test ' + split[8]);

      var index = "-1";

      if(split[8] === "lecture")
        index = "1";
      else if(split[8] === "mini_course")
        index = "2";
      else
        index = "3";

      alert(index + " " +  split[8] + " " + (split[8] === "lecture") + " " + document.getElementById("type_").selectedIndex);

      //document.getElementById("type_").selectedIndex = index;
      document.getElementById("type_").options[parseInt(index)].selected = true;

      alert(index + " " +  split[8] + " " + (split[8] === "lecture") + " " + document.getElementById("type_").selectedIndex);

      //document.getElementById("id_event_").value =  split[8];
      */

      //alert(split);

      document.getElementById("priceActivity_").value = split[10];
      //document.getElementById("lpriceActivity").className += " active";
      editMode();

    }

    function editMode(){
      document.getElementById("cancelar").setAttribute("style", "visibility:visible");
      document.getElementById("incluir_alterar").innerHTML = "<i class=\"material-icons left\">input</i> Alterar";
    }

    function cancelAll(){
      document.getElementById("cancelar").setAttribute("style", "visibility:hidden");
      document.getElementById("incluir_alterar").innerHTML = "<i class=\"material-icons left\">input</i> Insert";

      document.getElementById("name_").value =  "";
      document.getElementById("start_").value =  "";
      document.getElementById("startTime_").value =  "";
      document.getElementById("end_").value =  "";
      document.getElementById("endTime_").value =  "";
      document.getElementById('location_').value = "";
      document.getElementById("qnt_participants_").value = "";
      document.getElementById("type_").value =  "";
      document.getElementById("id_event_").value =  "";
    }


    //2015-11-22 -> 22 November, 2015
    function setDatesBack(date, id){
      //alert('>' + date);

      var strFinal = date.substring(8, 10) + " "; //22
      var mes = parseInt(date.substring(5, 7)); //11
      var strMes = "";
      switch(mes){
        case 1: strMes = "January"; break;
        case 2: strMes = "February"; break;
        case 3: strMes = "March"; break;
        case 4: strMes = "April"; break;
        case 5: strMes = "May"; break;
        case 6: strMes = "June"; break;
        case 7: strMes = "July"; break;
        case 8: strMes = "August"; break;
        case 9: strMes = "September"; break;
        case 10: strMes = "October"; break;
        case 11: strMes = "November"; break;
        case 12: strMes = "December"; break;
      }
      strFinal += strMes + ", ";
      strFinal += date.substring(0, 4) + " "; //2015

      document.getElementById(id).value = strFinal;

    }

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

        var today1 = yyyy+'-'+mm+'-'+dd;

        document.getElementById('start_').value = today1;
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

        var today2 = yyyy+'-'+mm+'-'+dd;

        document.getElementById('end_').value = today2;

        //alert(today1 + " " + today2);
    }
</script>
