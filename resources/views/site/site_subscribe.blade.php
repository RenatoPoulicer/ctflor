@extends('site.templates.site_default')


@section('content')
<div class="container">
    @include('templates.partials.alerts')

    <h3> Cadastre-se na nossa plataforma agora mesmo!</h3>
    <br />
    <br />
    <div class="row">
        @if($errors->any())
            <div class="card-panel red waves-effect waves-light" role="alert">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif


        <form class="col s12" method="POST" action="{{ route('crud.participant') }}">
          <input type="hidden" id="_token" name="_token" value="{{ Session::token() }}">
          <div class="row">
            <div class="card card-panel">
                <div class="input-field col s4">
                    <i class="material-icons prefix">perm_identity</i>
                    <input id="name_" name="name" type="text" class="validate">
                    <label id="lname" for="name">Nome</label>
                </div>

                <div class="input-field col s4">
                    <i class="material-icons prefix">credit_card</i>
                    <input id="cpf_" name="cpf" type="text" class="validate">
                    <label id="lcpf" for="cpf">CPF</label>
                </div>

                <div class="input-field col s4">
                    <i class="material-icons prefix">email</i>
                    <input id="email_" name="email" type="email" class="validate">
                    <label id="lemail" for="email">Email</label>
                </div>

                <div class="input-field col s4">
                    <i class="material-icons prefix">phone</i>
                    <input id="phone_" name="phone" type="text" class="validate">
                    <label id="lphone" for="phone">Telefone</label>
                </div>

                <div class="input-field col s4">
                    <i class="material-icons prefix">location_on</i>
                    <input id="address_" name="address" type="text" class="validate">
                    <label id="laddress" for="address">Endereco</label>
                </div>

                <div class="input-field col s4">
                    <i class="material-icons prefix">lock</i>
                    <input id="password_" name="password" type="password" class="validate">
                    <label id="lpassword" for="password">Senha</label>
                </div>


                <div class="input-field col s4">
                    <select id="type_" name="type">
                        <option value="" selected="false">Escolha uma opcao</option>
                        <option id="student" value="student">Estudante</option>
                        <option id="professor" value="professor">Professor</option>
                        <option id="community" value="community">Comunidade</option>
                    </select>
                    <label>Tipo de usuário</label>
                </div>

                <div class="input-field col s4">
                    <i class="material-icons prefix">store</i>
                    <input id="university_" name="university" type="text" class="validate">
                    <label id="luniversity" for="university">Universidade</label>
                </div>

                <div class="input-field col s4">
                    <i class="material-icons prefix">assignment</i>
                    <input id="course_" name="course" type="text" class="validate">
                    <label id="lcourse" for="course">Curso</label>
                </div>

                <div class="input-field col s6">
                    <i class="material-icons prefix">work</i>
                    <input id="department_" name="department" type="text" class="validate">
                    <label id="ldepartment" for="department">Departamento</label>
                </div>

                <div class="input-field col s6">
                    <i class="material-icons prefix">supervisor_account</i>
                    <input id="responsability_" name="responsability" type="text" class="validate">
                    <label id="lresponsability" for="responsability">Responsabilidade</label>
                </div>


                <div class="input-field col s3">
                    <button type="submit" class="waves-effect waves-light green darken-4 btn">
                      <i class="material-icons left">input</i>
                      Inserir
                    </button>
                </div>

                <div class="input-field col s3">
                  <button id="clearButton_" name="clearButton" class="waves-effect waves-light green darken-4 btn" onclick="clear();" >
                    <i class="material-icons left">delete</i>
                    Limpar
                  </button>
                </div>

              </div>
            </div>
      </form>
    </div>
</div>
<script>
    $(document).ready(function() {
      $('select').material_select();
    });

    function clear()
    {
      document.getElementById("name_").value =  "";

      document.getElementById("cpf_").value = "";

      document.getElementById("email_").value = "";

      document.getElementById("phone_").value = "";

      document.getElementById("address_").value = "";

      document.getElementById("type_").value = "";

      document.getElementById("university_").value = "";

      document.getElementById("course_").value = "";

      document.getElementById("department_").value = "";

      document.getElementById("responsability_").value = "";
    }

</script>
@stop
