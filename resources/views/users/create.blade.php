@extends('layout.modelo')

@section('content')

    <div class="w-100 d-block bg-light px-4 py-5 rounded-4 tela">
        <h4 class="mb-5 text-primary">Novo mantenedor</h4>

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


        <div class="row d-contents">
            <div class="col-12">
                <form action="{{ route('users.store') }}" method="POST" class="row">
                    @csrf
                    <input type="hidden" name="usuario" class="form-control border-0" id="usuario" value="" />
                    <div class="col-12 bg-white p-4 rounded-4 border border-verde-lista">
                        <div class="row">
                            <div class="col-md-6 col-12 mb-3">
                                <label for="nome" class="form-label fw-bold">Nome</label>
                                <input type="text" name="nome" class="form-control" id="nome" value="" onblur="generateUsername()">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label fw-bold">E-mail</label>
                                <input type="text" name="email" class="form-control" id="email" value="">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="telefone" class="form-label fw-bold">Celular</label>
                                <input type="tel" name="telefone" class="form-control" id="telefone" value="">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="data" class="form-label fw-bold">Aniversário</label>
                                <input type="text" name="data" class="form-control" id="data" placeholder="00/00/0000" value="">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="data" class="form-label fw-bold">Data de início</label>
                                <input type="date" name="data_mantes" class="form-control" id="data_mantes" value="<?php echo date('Y-m-d');?>">
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
                                            <option value="OO" selected>Selecione</option>
                                            <option value="AC">Acre</option>
                                            <option value="AL">Alagoas</option>
                                            <option value="AP">Amapá</option>
                                            <option value="AM">Amazonas</option>
                                            <option value="BA">Bahia</option>
                                            <option value="CE">Ceará</option>
                                            <option value="DF">Distrito Federal</option>
                                            <option value="ES">Espírito Santo</option>
                                            <option value="GO">Goiás</option>
                                            <option value="MA">Maranhão</option>
                                            <option value="MT">Mato Grosso</option>
                                            <option value="MS">Mato Grosso do Sul</option>
                                            <option value="MG">Minas Gerais</option>
                                            <option value="PA">Pará</option>
                                            <option value="PB">Paraíba</option>
                                            <option value="PR">Paraná</option>
                                            <option value="PE">Pernambuco</option>
                                            <option value="PI">Piauí</option>
                                            <option value="RJ">Rio de Janeiro</option>
                                            <option value="RN">Rio Grande do Norte</option>
                                            <option value="RS">Rio Grande do Sul</option>
                                            <option value="RO">Rondônia</option>
                                            <option value="RR">Roraima</option>
                                            <option value="SC">Santa Catarina</option>
                                            <option value="SP">São Paulo</option>
                                            <option value="SE">Sergipe</option>
                                            <option value="TO">Tocantins</option>
                                        </select>
                                    </div>

                                    <div class="col-md-8 mb-3">
                                        <label for="cidade" class="form-label fw-bold">Cidade</label>
                                        <input type="tel" name="cidade" class="form-control" id="cidade" value="">
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <hr class="opacity-25 border-success">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="categoria" class="form-label fw-bold">Categoria</label>
                                <select name="categoria" id="categoria" class="form-control form-select">
                                    <option value="1" selected>Mantenedor</option>
                                    <option value="2">Voluntário</option>
                                    <option value="3">Wokshop</option>
                                    <option value="4">Semana Missionária</option>
                                    <option value="5">Notícias Família Aziz</option>
                                    <option value="6">Intercessores</option>
                                    <option value="10">Outros</option>
                                </select>
                            </div>

                            <div class="mb-3 col-md-3 col-12">
                                <label for="melhor_dia_oferta" class="form-label fw-bold">Melhor dia</label>
                                <select class="form-control form-select" name="melhor_dia_oferta" id="melhor_dia_oferta">
                                    <option value="0">Selecione</option>
                                    @for ($i = 1; $i <= 31; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div class="col-12 text-center mt-4">
                                <button type="submit" class="btn btn-primary rounded-pill px-5">Cadastrar mantenedor</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection



