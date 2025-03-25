@extends('layout.modelo')

@section('content')
@php
        if(auth()->check()){
            $user = auth()->user()->type_user;
            $id_user = auth()->user()->id;
            $usu = auth()->user();
        } else {
            $id_user = null;
            $user = null;
        }

        //dd($usu);
    @endphp

    <div class="w-100 d-block bg-light px-4 py-5 rounded-4">


        <div class="row">
            <div class="d-flex justify-content-between mb-5">
                @if ($usuario->type_user == 1)
                    <h4 class="mb-0 text-primary">Edite seus dados!</h4>
                @else
                    <h4 class="mb-0 text-primary">Edite os dados de {{$usuario->nome}}</h4>
                @endif
                <a class="btn btn-sm btn-outline-verde px-4 rounded-pill" href="javascript:history.go(-1)">Voltar</a>
            </div>
        </div>


        @if ( session()->has('message'))
            <div class="alert alert-warning bg-success text-white alert-dismissible fade show" role="alert">
                <strong>Sucesso!</strong>  {{ session()->get('message') }}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ( session()->has('error'))
            <div class="alert alert-warning bg-vermelho text-white alert-dismissible fade show" role="alert">
                <strong>Erro!</strong>  {{ session()->get('error') }}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($semContribuicao180 && $user != 1)
            <div class="alert bg-vermelho text-white alert-dismissible fade show" role="alert">
                Essa pessoa não contribui há mais de 180 dias.
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif


        <div class="row d-contents">
            <div class="col-12">
                <form action="{{ route('users.update', ['user' => $usuario->id]) }}" method="POST" class="row">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <div class="col-12 bg-white p-4 rounded-4 border border-verde-lista">
                        <div class="row">
                            <div class="col-md-6 col-12 mb-3">
                                <label for="nome" class="form-label fw-bold">Nome</label>
                                <input type="text" name="nome" class="form-control " id="nome" value="{{ $usuario->nome }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label fw-bold">E-mail</label>
                                <input type="text" name="email" class="form-control " id="email" value="{{ $usuario->email }}">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="telefone" class="form-label fw-bold">Celular</label>
                                <input type="tel" name="telefone" class="form-control " id="telefone" value="{{ $usuario->celular }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="data" class="form-label fw-bold">Aniversário</label>
                                <input type="date" name="data_edit" class="form-control" id="data_edit" value="{{ $usuario->aniversário }}" />
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="data" class="form-label fw-bold">Data de início</label>
                                <input type="date" name="data_mantes_edit" class="form-control" id="data_mantes_edit" value="{{ $usuario->data_mantenedor }}">
                            </div>

                            <div class="col-12">
                                <hr class="opacity-25 border-success">
                            </div>

                            <div class="col-md-3">
                                <label for="pais" class="form-label fw-bold">País</label>
                                <select name="pais" id="pais" class="form-control form-select">
                                    <option value="AA">Aruba</option>
                                    <option value="AC">Antígua e Barbuda</option>
                                    <option value="AF">Afeganistão</option>
                                    <option value="AG">Argélia</option>
                                    <option value="AJ">Azerbaijão</option>
                                    <option value="AL">Albânia</option>
                                    <option value="AM">Armênia</option>
                                    <option value="AN">Andorra</option>
                                    <option value="AO">Angola</option>
                                    <option value="SA">Arábia Saudita</option>
                                    <option value="AR">Argentina</option>
                                    <option value="AS">Austrália</option>
                                    <option value="AU">Áustria</option>
                                    <option value="AV">Anguilla</option>
                                    <option value="AX">Acrotíri</option>
                                    <option value="AY">Antártica</option>
                                    <option value="BA">Bahrain</option>
                                    <option value="BB">Barbados</option>
                                    <option value="BC">Botswana</option>
                                    <option value="BD">Bermudas</option>
                                    <option value="BE">Bélgica</option>
                                    <option value="BF">Bahamas</option>
                                    <option value="BG">Bangladesh</option>
                                    <option value="BH">Belize</option>
                                    <option value="BK">Bósnia e Herzegovina</option>
                                    <option value="BL">Bolívia</option>
                                    <option value="BM">Birmânia Myanmar</option>
                                    <option value="BN">Benim</option>
                                    <option value="BO">Bielorrússia</option>
                                    <option value="BR" selected>Brasil</option>
                                    <option value="BT">Butão</option>
                                    <option value="BU">Bulgária</option>

                                    <option value="BX">Brunei</option>
                                    <option value="BY">Burundi</option>
                                    <option value="CA">Canadá</option>
                                    <option value="CB">Camboja</option>
                                    <option value="CD">Chade</option>

                                    <option value="CG">República Democrática do Congo</option>
                                    <option value="CH">China</option>
                                    <option value="CM">Camarões</option>
                                    <option value="CL">Chile</option>
                                    <option value="CY">Chipre</option>

                                    <option value="CO">Colômbia</option>
                                    <option value="CQ">Ilhas Marianas do Norte</option>
                                    <option value="CR">Ilhas do Mar de Coral</option>
                                    <option value="CS">Costa Rica</option>
                                    <option value="CT">República Centro-Africana</option>
                                    <option value="CU">Cuba</option>
                                    <option value="CV">Cabo Verde</option>


                                    <option value="DA">Dinamarca</option>
                                    <option value="DJ">Djibouti</option>
                                    <option value="DO">Dominica</option>
                                    <option value="DQ">Ilha Jarvis</option>
                                    <option value="DR">República Dominicana</option>
                                    <option value="DX">Deceleia</option>
                                    <option value="EC">Equador</option>
                                    <option value="LO">Eslováquia</option>
                                    <option value="SP">Espanha</option>
                                    <option value="EG">Egito</option>
                                    <option value="AE">Emirados Árabes Unidos</option>
                                    <option value="EI">Irlanda</option>
                                    <option value="EK">Guiné Equatorial</option>
                                    <option value="EN">Estónia</option>
                                    <option value="ER">Eritreia</option>
                                    <option value="ES">El Salvador</option>
                                    <option value="ET">Etiópia</option>
                                    <option value="EZ">República Checa</option>
                                    <option value="FG">Guiana Francesa</option>
                                    <option value="FI">Finlândia</option>
                                    <option value="FJ">Fiji</option>
                                    <option value="FK">Ilhas Falkland Ilhas Malvinas</option>
                                    <option value="FM">Estados Federados da Micronésia</option>
                                    <option value="FO">Ilhas Feroe</option>
                                    <option value="FP">Polinésia Francesa</option>
                                    <option value="FQ">Ilha Baker</option>
                                    <option value="FR">França</option>
                                    <option value="FS">Terras Austrais e Antárticas Francesas</option>
                                    <option value="GA">Gâmbia</option>
                                    <option value="GB">Gabão</option>
                                    <option value="GF">Guiana francesa</option>
                                    <option value="GG">Geórgia</option>
                                    <option value="GH">Gana</option>
                                    <option value="GI">Gibraltar</option>
                                    <option value="GJ">Granada</option>
                                    <option value="GK">Guernsey</option>
                                    <option value="GL">Gronelândia</option>
                                    <option value="GM">Alemanha</option>
                                    <option value="GP">Guadalupe</option>
                                    <option value="GQ">Guam</option>
                                    <option value="GR">Grécia</option>
                                    <option value="GT">Guatemala</option>
                                    <option value="GV">Guiné</option>
                                    <option value="GW">Guiné-Bissau</option>
                                    <option value="GY">Guiana</option>
                                    <option value="HA">Haiti</option>
                                    <option value="HK">Hong Kong</option>
                                    <option value="HO">Honduras</option>
                                    <option value="HQ">Ilha Howland</option>
                                    <option value="HR">Croácia</option>
                                    <option value="HU">Hungria</option>
                                    <option value="IC">Islândia</option>
                                    <option value="ID">Indonésia</option>
                                    <option value="IM">Ilha de Man</option>
                                    <option value="IN">Índia</option>
                                    <option value="IP">Ilha de Clipperton</option>
                                    <option value="BP">Ilhas Salomão</option>
                                    <option value="BQ">Ilha Navassa</option>
                                    <option value="BV">Ilha Bouvet</option>
                                    <option value="AT">Ilhas Ashmore e Cartier</option>
                                    <option value="CJ">Ilhas Cayman</option>
                                    <option value="CK">Ilhas Cocos Keeling</option>
                                    <option value="IR">Irã</option>
                                    <option value="IS">Israel</option>
                                    <option value="IT">Itália</option>
                                    <option value="CI">Costa do Marfim</option>
                                    <option value="IZ">Iraque</option>
                                    <option value="JP">Japão</option>
                                    <option value="JM">Jamaica</option>
                                    <option value="JO">Jordânia</option>
                                    <option value="KE">Quénia</option>
                                    <option value="KG">Quirguistão</option>
                                    <option value="KN">Coreia do Norte</option>
                                    <option value="KR">Kiribati</option>
                                    <option value="KS">Coreia do Sul</option>
                                    <option value="KU">Kuwait</option>
                                    <option value="KV">Cazaquistão</option>
                                    <option value="LA">Laos</option>
                                    <option value="LE">Líbano</option>
                                    <option value="LG">Letónia</option>
                                    <option value="LH">Lituânia</option>
                                    <option value="LI">Libéria</option>

                                    <option value="LP">Latin Purificado</option>
                                    <option value="LQ">Atol Palmyra</option>
                                    <option value="LS">Liechtenstein</option>
                                    <option value="LT">Lesoto</option>
                                    <option value="LU">Luxemburgo</option>
                                    <option value="LY">Líbia</option>
                                    <option value="MA">Marrocos</option>
                                    <option value="MB">Martinica</option>
                                    <option value="MC">Macau</option>
                                    <option value="MD">Moldávia</option>
                                    <option value="ME">Madeira</option>
                                    <option value="MF">Mayotte</option>
                                    <option value="MG">Mongólia</option>
                                    <option value="MH">Montserrat</option>
                                    <option value="MI">Malawi</option>
                                    <option value="MJ">Montenegro</option>
                                    <option value="MK">Macedônia</option>
                                    <option value="ML">Mali</option>
                                    <option value="MN">Mônaco</option>
                                    <option value="MP">Maurícia</option>
                                    <option value="MQ">Atol de Midway</option>
                                    <option value="MR">Mauritânia</option>
                                    <option value="MT">Malta</option>
                                    <option value="MU">Omã</option>
                                    <option value="MV">Maldivas</option>
                                    <option value="MX">México</option>
                                    <option value="MY">Malásia</option>
                                    <option value="MZ">Moçambique</option>
                                    <option value="WA">Namíbia</option>
                                    <option value="NG">Níger</option>
                                    <option value="NH">Vanuatu</option>
                                    <option value="NI">Nigéria</option>
                                    <option value="NL">Países Baixos/Holanda</option>
                                    <option value="NO">Noruega</option>
                                    <option value="NP">Nepal</option>
                                    <option value="NR">Nauru</option>
                                    <option value="NS">Suriname</option>
                                    <option value="NT">Antilhas Holandesas</option>
                                    <option value="NU">Nicarágua</option>
                                    <option value="NZ">Nova Zelândia</option>
                                    <option value="PA">Paraguai</option>
                                    <option value="PE">Peru</option>
                                    <option value="PF">Ilhas Paracel</option>
                                    <option value="PG">Ilhas Spratly</option>
                                    <option value="PK">Paquistão</option>
                                    <option value="PL">Polônia</option>
                                    <option value="PM">Panamá</option>
                                    <option value="PT">Portugal</option>
                                    <option value="PP">Papua-Nova Guiné</option>
                                    <option value="PS">Palau</option>
                                    <option value="PU">Guiné-Bissau</option>
                                    <option value="QA">Qatar</option>
                                    <option value="AQ">Samoa Americana</option>
                                    <option value="RI">Sérvia</option>
                                    <option value="RM">Ilhas Marshall</option>
                                    <option value="RN">Saint Martin</option>
                                    <option value="RO">Roménia</option>
                                    <option value="RP">Filipinas</option>
                                    <option value="RQ">Porto Rico</option>
                                    <option value="RS">Rússia</option>
                                    <option value="CZ">República Tcheca</option>
                                    <option value="RW">Ruanda</option>

                                    <option value="SB">Saint Pierre e Miquelon</option>
                                    <option value="SC">São Cristóvão e Nevis</option>

                                    <option value="SE">Seychelles</option>
                                    <option value="SF">África do Sul</option>
                                    <option value="SG">Senegal</option>
                                    <option value="SH">Santa Helena território</option>
                                    <option value="SI">Eslovénia</option>
                                    <option value="SL">Serra Leoa</option>
                                    <option value="SM">San Marino</option>
                                    <option value="SN">Singapura</option>
                                    <option value="SO">Somália</option>
                                    <option value="CE">Sri Lanka</option>

                                    <option value="ST">Santa Lúcia</option>
                                    <option value="SU">Sudão</option>
                                    <option value="SV">Svalbard</option>
                                    <option value="SW">Suécia</option>
                                    <option value="SX">Ilhas Geórgia do Sul e Sandwich do Sul</option>
                                    <option value="SY">Síria</option>
                                    <option value="SZ">Suiça</option>
                                    <option value="TB">Saint-Barthélemy Antilhas francesas</option>
                                    <option value="TD">Trinidad e Tobago</option>
                                    <option value="TH">Tailândia</option>
                                    <option value="TI">Tadjiquistão</option>
                                    <option value="TK">Ilhas Turks e Caicos</option>
                                    <option value="TL">Tokelau</option>
                                    <option value="TN">Tonga</option>
                                    <option value="TO">Togo</option>
                                    <option value="TP">São Tomé e Príncipe</option>
                                    <option value="TS">Tunísia</option>
                                    <option value="TT">Timor-Leste</option>
                                    <option value="TR">Turquia</option>
                                    <option value="TV">Tuvalu</option>
                                    <option value="TW">Taiwan</option>
                                    <option value="TX">Turquemenistão</option>
                                    <option value="TZ">Tanzânia</option>
                                    <option value="UG">Uganda</option>
                                    <option value="UK">Reino Unido</option>
                                    <option value="UP">Ucrânia</option>
                                    <option value="US">Estados Unidos</option>
                                    <option value="UV">Burkina Faso</option>
                                    <option value="UY">Uruguai</option>
                                    <option value="UZ">Uzbequistão</option>
                                    <option value="VC">São Vicente e Granadinas</option>
                                    <option value="VE">Venezuela</option>
                                    <option value="VI">Ilhas Virgens Britânicas</option>
                                    <option value="VM">Vietname</option>
                                    <option value="VQ">Ilhas Virgens Americanas</option>
                                    <option value="VT">Vaticano</option>

                                    <option value="WE">Cisjordânia</option>
                                    <option value="WS">Samoa</option>
                                    <option value="WZ">Suazilândia</option>
                                    <option value="YM">Iémen</option>
                                    <option value="ZA">Zâmbia</option>
                                    <option value="ZI">Zimbabwe</option>
                                  </select>
                            </div>

                            <div class="est-br col-md-6">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="estado" class="form-label fw-bold">Estado</label>
                                        <select id="estado" name="estado" class="form-control form-select">
                                            <option value="OO" {{ empty($usuario->estado) ? 'selected' : '' }}>Selecione</option>
                                            <option value="AC" {{ $usuario->estado === 'AC' ? 'selected' : '' }}>Acre</option>
                                            <option value="AL" {{ $usuario->estado === 'AL' ? 'selected' : '' }}>Alagoas</option>
                                            <option value="AP" {{ $usuario->estado === 'AP' ? 'selected' : '' }}>Amapá</option>
                                            <option value="AM" {{ $usuario->estado === 'AM' ? 'selected' : '' }}>Amazonas</option>
                                            <option value="BA" {{ $usuario->estado === 'BA' ? 'selected' : '' }}>Bahia</option>
                                            <option value="CE" {{ $usuario->estado === 'CE' ? 'selected' : '' }}>Ceará</option>
                                            <option value="DF" {{ $usuario->estado === 'DF' ? 'selected' : '' }}>Distrito Federal</option>
                                            <option value="ES" {{ $usuario->estado === 'ES' ? 'selected' : '' }}>Espírito Santo</option>
                                            <option value="GO" {{ $usuario->estado === 'GO' ? 'selected' : '' }}>Goiás</option>
                                            <option value="MA" {{ $usuario->estado === 'MA' ? 'selected' : '' }}>Maranhão</option>
                                            <option value="MT" {{ $usuario->estado === 'MT' ? 'selected' : '' }}>Mato Grosso</option>
                                            <option value="MS" {{ $usuario->estado === 'MS' ? 'selected' : '' }}>Mato Grosso do Sul</option>
                                            <option value="MG" {{ $usuario->estado === 'MG' ? 'selected' : '' }}>Minas Gerais</option>
                                            <option value="PA" {{ $usuario->estado === 'PA' ? 'selected' : '' }}>Pará</option>
                                            <option value="PB" {{ $usuario->estado === 'PB' ? 'selected' : '' }}>Paraíba</option>
                                            <option value="PR" {{ $usuario->estado === 'PR' ? 'selected' : '' }}>Paraná</option>
                                            <option value="PE" {{ $usuario->estado === 'PE' ? 'selected' : '' }}>Pernambuco</option>
                                            <option value="PI" {{ $usuario->estado === 'PI' ? 'selected' : '' }}>Piauí</option>
                                            <option value="RJ" {{ $usuario->estado === 'RJ' ? 'selected' : '' }}>Rio de Janeiro</option>
                                            <option value="RN" {{ $usuario->estado === 'RN' ? 'selected' : '' }}>Rio Grande do Norte</option>
                                            <option value="RS" {{ $usuario->estado === 'RS' ? 'selected' : '' }}>Rio Grande do Sul</option>
                                            <option value="RO" {{ $usuario->estado === 'RO' ? 'selected' : '' }}>Rondônia</option>
                                            <option value="RR" {{ $usuario->estado === 'RR' ? 'selected' : '' }}>Roraima</option>
                                            <option value="SC" {{ $usuario->estado === 'SC' ? 'selected' : '' }}>Santa Catarina</option>
                                            <option value="SP" {{ $usuario->estado === 'SP' ? 'selected' : '' }}>São Paulo</option>
                                            <option value="SE" {{ $usuario->estado === 'SE' ? 'selected' : '' }}>Sergipe</option>
                                            <option value="TO" {{ $usuario->estado === 'TO' ? 'selected' : '' }}>Tocantins</option>
                                        </select>

                                    </div>

                                    <div class="col-md-8 mb-3">
                                        <label for="cidade" class="form-label fw-bold">Cidade</label>
                                        <input type="tel" name="cidade" class="form-control " id="cidade" value="{{ $usuario->cidade }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <hr class="opacity-25 border-success">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="categoria" class="form-label fw-bold">Categoria</label>
                                <select name="categoria" id="categoria" class="form-control form-select">
                                    @foreach ($categoria as $cat => $val)
                                        <option value="{{ $cat }}" {{ $usuario->categoria == $cat ? 'selected' : ''}}>{{ $val }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="data" class="form-label fw-bold">Melhor dia</label>
                                <select class="form-control form-select" name="melhor_dia_oferta" id="melhor_dia_oferta">
                                    <option value="0">Selecione</option>
                                    @for ($i = 1; $i <= 31; $i++)
                                        @if ($i == $usuario->melhor_dia) <!-- Verifica se o dia atual do loop é igual ao valor em 'melhor_dia' do usuário -->
                                            <option selected value="{{ $i }}">{{ $i }}</option>
                                        @else
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endif
                                    @endfor
                                </select>
                            </div>



                            @if ( $user == 1 || $usuario->type_user == 3 )
                                <div class="col-12">
                                    <hr class="opacity-25 border-success">
                                </div>
                                <div class="col-md-3 mb-3 senha">
                                    <label for="senha" class="form-label fw-bold">Nova Senha</label>
                                    <input type="password" name="senha" class="form-control  pass" id="senha" value="">
                                    <i class="fa-solid fa-eye text-roxo opacity-75" id="ico-senha" onclick="mostrarSenha()"></i>
                                </div>

                                <div class="col-md-3 mb-3 senha">
                                    <label for="rep_senha" class="form-label fw-bold">Repetir Senha</label>
                                    <input type="password" name="rep_senha" class="form-control  pass" id="rep_senha" value="">
                                    <i class="fa-solid fa-eye text-roxo opacity-75" id="ico-rep-senha" onclick="mostrarRepSenha()"></i>
                                </div>
                            @endif

                        <div class="col-12 text-center mt-5 mb-4">
                            <button type="submit" class="btn btn-primary rounded-pill px-5">Atualizar usuário</button>
                        </div>
                        @if ($usuario->user_type == 1)
                            <div class="col-12 mb-3 d-flex">
                                <button type="button" class="btn btn-verde px-5 align-self-end border-0 rounded-pill" id="abrir_comentarios"
                                        data-texto-inicial="{{ $usuario->observacoes->count() > 0 ? 'Ver observações' : 'Adicionar observação' }}"
                                        data-texto-alternativo="Fechar observação">
                                    {{ $usuario->observacoes->count() > 0 ? 'Ver observações' : 'Adicionar observação' }}
                                </button>
                            </div>
                        @endif
                    </div>
                </form>


                <div class="col-12" id="caixa_observacao" style="display: none">
                    <div class="row">
                        <div class="col-12 my-4">
                            <hr class="opacity-25 border-success">
                        </div>

                        <div class="col-md-5 col-12">
                            <form action="{{ route('users.observacoes.store', $usuario->id)}}" method="POST">
                                @csrf
                                <label for="observacoes" class="form-label fw-bold h4 mb-4">Observação</label>
                                <div class="form-group mb-3">
                                    <textarea class="form-control form-text" name="observacoes" id="observacoes" cols="30" rows="7" placeholder="Observação" required></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary rounded-pill px-5">Registar observação</button>
                                </div>
                            </form>
                        </div>



                        <div class="col-md-7 col-12">
                            <label for="observacoes" class="form-label fw-bold h4 mb-4">Histórico</label>
                            <div class="observ">
                                @forelse ($obs->observacoes as $observacao)
                                    <div class="obs">
                                        <p>{{ $observacao->observacao }}</p>
                                        <div class="d-flex align-items-center w-100 mt-2">
                                            <p class="m-0"><span class="small text-cinza">Criada em: {{ $observacao->created_at->format('d/m/Y \à\s H:i') }}</span></p>
                                            @if($observacao->created_at != $observacao->updated_at)
                                                <div class="vr mx-2"></div>
                                                <p class="m-0"><span class="small text-cinza">Atualizada em: {{ $observacao->updated_at->format('d/m/Y \à\s H:i') }}</span></p>
                                            @endif
                                        </div>
                                        <div class="d-flex align-items-center w-100 mt-2">
                                            <a href="#!" class="link-azul small" data-bs-toggle="modal" data-bs-target="#modalResposta{{ $observacao->id }}">Responder</a>
                                                <div class="vr mx-2"></div>
                                            <button type="button" class="link-azul border-0 bg-white small bot_resposta px-0"  data-target="#respostas_{{ $observacao->id }}">
                                                Resposta/s ({{ $observacao->respostas->count() }})
                                            </button>
                                                <div class="vr mx-2"></div>
                                            <a href="#!" class="link-azul small" data-bs-toggle="modal" data-bs-target="#modalExclusao{{ $observacao->id }}">Excluir</a>
                                                <div class="vr mx-2"></div>
                                            <a href="#!" class="link-azul small" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $observacao->id }}">Editar</a>
                                        </div>


                                        <div id="respostas_{{$observacao->id}}" class="respostas">
                                        @foreach ($observacao->respostas as $resposta)
                                            <div class="resposta">
                                                <span class="material-symbols-outlined text-cinza">reply</span>
                                                <p>{{ $resposta->resposta }}</p>
                                                <div class="d-flex align-items-center fst-normal">
                                                    <p class="m-0"><span class="small text-cinza">{{ $resposta->created_at->format('d/m/Y \à\s H:i') }}</span></p>
                                                        <div class="vr mx-2"></div>
                                                    <a href="{{ route('respostas.destroy', $resposta->id) }}" class="link-azul small" onclick="return confirm('Tem certeza que deseja excluir esta resposta?')">Excluir Resposta</a>
                                                </div>
                                            </div>
                                        @endforeach
                                        </div>

                                        <!-- Modal para Responder -->
                                        <div class="modal fade" id="modalResposta{{ $observacao->id }}" tabindex="-1" aria-labelledby="modalResposta{{ $observacao->id }}Label" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Em resposta à:</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('observacoes.respostas.store', $observacao->id) }}" method="POST">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <p>{{ $observacao->observacao }}</p>
                                                            <textarea class="form-control" name="resposta" rows="5" placeholder="Digite sua resposta..."></textarea>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary">Enviar Resposta</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fim Modal para Responder -->

                                        <!-- Modal para Exclusão da observação -->
                                        <div class="modal fade" id="modalExclusao{{ $observacao->id }}" tabindex="-1" aria-labelledby="modalExclusao{{ $observacao->id }}Label" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Você desejá mesmo remover essa observação?</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('observacoes.destroy', $observacao->id) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <div class="modal-body">
                                                            <p>{{ $observacao->observacao }}</p>
                                                        </div>
                                                        <div class="modal-footer d-flex align-items-center justify-content-center">
                                                            <button type="submit" class="btn btn-primary">Excluir observação</button>
                                                            <button type="button" class="btn btn-vermelho" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fim Modal para Exclusão da observação -->

                                        <!-- Modal para Edição da observação -->
                                        <div class="modal fade" id="modalEdit{{ $observacao->id }}" tabindex="-1" aria-labelledby="modalEdit{{ $observacao->id }}Label" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Editar</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('observacoes.edit', $observacao->id) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="_method" value="PUT">
                                                        <div class="modal-body">
                                                            <textarea class="form-control" name="edit_observacao" rows="5" placeholder="Digite sua resposta...">{{ $observacao->observacao }}</textarea>
                                                        </div>
                                                        <div class="modal-footer d-flex align-items-center justify-content-center">
                                                            <button type="submit" class="btn btn-primary">Editar observação</button>
                                                            <button type="button" class="btn btn-vermelho" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fim Modal para Edição da observação -->

                                    </div>


                                @empty
                                    <p>Nenhuma observação registrada sobre {{$usuario->nome}}.</p>
                                @endforelse
                            </div>

                        </div>

                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection
