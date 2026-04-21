<x-app-layout>
    <x-slot name="title">{{ $title }}</x-slot>
    <form id="Formato" class="needs-validation" novalidate>
        {{ csrf_field() }}
        <input type="hidden" name="id_establecimiento" id="id_establecimiento" value="{{ $format->id_establecimiento }}" />
        <!--<h4>DATOS GENERALES DE LA IPRESS</h4>-->
        <input name="es_creacion" id="es_creacion" type="hidden" value="0" />
        <div class="accordion" id="accordionExample" style="font-size: 12px;font-weight: bold;">
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                1. DATOS GENERALES DEL ESTABLECIMIENTO DE SALUD
              </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
              <div class="accordion-body">
                <div class="row g-0 align-items-end" style="font-size: 10px;">
                    <div class="col-md-2 col-lg-2">
                        @if(env('ENDPOINT_RENIPRESS_SUSALUD'))
                            <label for="codigo_ipre" class="col-md-12 col-form-label d-flex align-items-center justify-content-between">
                                C&Oacute;DIGO IPRESS <span class="text-danger">(*)</span>
                                <img src="{{ asset('img/logo.gif') }}" class="mr-2" style="width:24px;cursor:pointer" onclick="onSusalud()" />
                            </label>
                        @else
                            <label for="codigo_ipre" class="col-md-12 col-form-label">
                                C&Oacute;DIGO IPRESS <span class="text-danger">(*)</span>
                            </label>
                        @endif
                        <div class="col-md-12">
                            @if ($codigo != null && $codigo != '')
                            <input type="number" min="1" max="99999999" maxlength="8" class="form-control" name="codigo_ipre" value="{{ $format->codigo_ipre }}" id="codigo_ipre" placeholder=""
                                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)" readonly required />
                            @else
                            <input type="number" min="1" max="99999999" maxlength="8" class="form-control" name="codigo_ipre" value="{{ $format->codigo_ipre }}" id="codigo_ipre"  placeholder=""
                                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)" required />
                            @endif
                            <div class="invalid-feedback">Digite el C&oacute;digo</div>
                        </div>  
                    </div>
                    <div class="col-md-3">
                        <label for="codigo_ipre" class="col-md-12 col-form-label">INSTITUCI&Oacute;N <span class="text-danger">(*)</span></label>
                        <div class="col-md-12">
                            <select class="form-control" id="idinstitucion" name="idinstitucion" required>
                                <option value="">Seleccione</option>
                                @foreach($instituciones as $institucion)
                                    <option value="{{ $institucion->id }}" <?php echo($establishment->id_institucion == $institucion->id ? "selected" : ""); ?>>{{ $institucion->nombre }}</option>
                                @endforeach
                            </select>
                        </div>  
                    </div>
                    <div class="col-md-4">
                        <label for="nombre_eess" class="col-md-12 col-form-label">NOMBRE DEL EESS</label>
                        <div class="col-md-12">
                            <input type="text" class="form-control texto" maxlength="200" name="nombre_eess" value="{{ $format->nombre_eess }}" id="nombre_eess" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="nombre_eess" class="col-md-12 col-form-label">REGI&Oacute;N</label>
                        <div class="col-md-12">
                            <select class="form-control" id="idregion" name="idregion" required onchange="onChangeRegion()">
                                <option value="">Seleccione</option>
                                @foreach($regiones as $region)
                                    <option value="{{ $region->id }}" <?php echo($establishment->idregion == $region->id ? "selected" : ""); ?>>{{ $region->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="nombre_eess" class="col-md-12 col-form-label">PROVINCIA</label>
                        <div class="col-md-12">
                            <select class="form-control" id="idprovincia" name="idprovincia" required onchange="onChangeProvincia()">
                                <option value="">Seleccione</option>
                                @if($establishment->idprovincia > 0)
                                    <option value="{{ $establishment->idprovincia }}" selected>{{ $establishment->provincia }}</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-3">
                        <label for="nombre_eess" class="col-md-12 col-form-label">DISTRITO</label>
                        <div class="col-md-12">
                            <select class="form-control" id="iddistrito" name="iddistrito" required>
                                <option value="">Seleccione</option>
                                @if($establishment->iddistrito > 0)
                                    <option value="{{ $establishment->iddistrito }}">{{ $establishment->distrito }}</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="nombre_red" class="col-md-12 col-form-label">RED</label>
                        <div class="col-md-12">
                            <input type="text" class="form-control texto" maxlength="200" name="nombre_red" value="{{ $format->nombre_red }}"  id="nombre_red" onkeyup="IsModify(this)" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="nombre_microred" class="col-md-12 col-form-label">MICRORED</label>
                        <div class="col-md-12">
                            <input type="text" class="form-control texto" maxlength="200" name="nombre_microred" value="{{ $format->nombre_microred }}"  id="nombre_microred" onkeyup="IsModify(this)" />
                        </div>
                    </div>
                </div>
                <div class="row g-0" style="font-size: 10px;">
                    <div class="col-md-4">
                        <label for="nivel_atencion" class="col-md-12 col-form-label">NIVEL DE ATENCI&Oacute;N</label>
                        <div class="col-md-12">
                            <select class="form-control" name="nivel_atencion" id="nivel_atencion">
                                <option value="">Seleccione</option>
                                @foreach($niveles_atencion as $nivel)
                                    <option value="{{ $nivel->nombre }}" <?php echo ($format->nivel_atencion == $nivel->nombre ? "selected" : "") ?>>{{ $nivel->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="id_categoria" class="col-md-12 col-form-label">CATEGOR&Iacute;A ACTUAL</label>
                        <div class="col-md-12">
                            <select class="form-control" name="id_categoria" id="id_categoria">
                                <option value="">Seleccione</option>
                                @foreach($niveles as $nivel)
                                    <option value="{{ $nivel->id }}" <?php echo ($establishment->id_categoria == $nivel->id ? "selected" : "") ?>>{{ $nivel->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="resolucion_categoria" class="col-md-12 col-form-label">RESOLUCI&Oacute;N DE CATEGORIA</label>
                        <div class="col-md-12">
                            <input type="text" class="form-control alfanumerico" maxlength="10" name="resolucion_categoria" id="resolucion_categoria" value="{{ $format->resolucion_categoria }}" onkeyup="IsModify(this)" />
                        </div>
                    </div>
                </div>
                <div class="row g-0" style="font-size: 10px;">
                    <div class="col-md-6">
                        <label for="clasificacion" class="col-md-12 col-form-label">CLASIFICACI&Oacute;N</label>
                        <div class="col-md-12">
                            <input type="text" class="form-control alfanumerico" name="clasificacion" id="clasificacion" maxlength="200" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="tipo" class="col-md-12 col-form-label">TIPO</label>
                        <div class="col-md-12">
                            <input type="text" class="form-control alfanumerico" name="tipo" id="tipo" maxlength="200"  />
                        </div>
                    </div>
                </div>
                <div class="row g-0" style="font-size: 10px;">
                    <div class="col-md-12">
                        <label for="unidad_ejecutora" class="col-md-12 col-form-label">NOMBRE DE LA UNIDAD EJECUTORA O ADMINISTRACI&Oacute;N A LA QUE PERTENECE</label>
                        <div class="col-md-12">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control col-sm-2" maxlength="4" name="codigo_unidad_ejecutora" id="codigo_unidad_ejecutora" value="" onkeyup="IsModify(this)" />
                                <input type="text" class="form-control texto" maxlength="200" name="unidad_ejecutora" id="unidad_ejecutora" value="{{ $format->unidad_ejecutora }}" onkeyup="IsModify(this)" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-0" style="font-size: 10px;">
                    <div class="col-md-6">
                        <label for="director_medico" class="col-md-12 col-form-label">RESPONSABLE DEL ESTABLECIMIENTO DE SALUD</label>
                        <div class="col-md-12">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control texto" maxlength="200" name="director_medico" id="director_medico" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="horario" class="col-md-12 col-form-label">HORARIO DE ATENCI&Oacute;N</label>
                        <div class="col-md-12">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" maxlength="200" name="horario" id="horario" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="telefono" class="col-md-12 col-form-label">TELEFONO</label>
                        <div class="col-md-12">
                            <div class="input-group mb-3">
                                <input type="phone" class="form-control" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)" maxlength="200" name="telefono" id="telefono" />
                            </div>
                        </div>
                    </div>
                </div>
                <ul class="nav nav-tabs mt-2" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true" style="font-weight: bold;background:#dee2e6;">
                            ESTA INFORMACION DEBERIA SER PROPORCIONADA POR SERVICIOS DE SALUD DE LA RED O DIRESA
                        </button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab" style="border: 1px solid;border-color: #dee2e6;border-bottom-left-radius: .25rem;border-bottom-right-radius: .25rem;">
                        <div class="row g-0 pb-2" style="font-size: 10px;">
                            <div class="col-md-4">
                                <label for="inicio_funcionamiento" class="col-md-12 col-form-label">INICIO DE FUNCIONAMIENTO</label>
                                <div class="col-md-12">
                                    <input type="date" class="form-control" min="1875-01-01" max="{{ date('Y-m-d') }}" name="inicio_funcionamiento" id="inicio_funcionamiento" value="{{ $format->inicio_funcionamiento }}" onkeyup="IsModify(this)" />
                                    <div class="invalid-feedback">La fecha no podra ser superior a la fecha actual</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="fecha_registro" class="col-md-12 col-form-label">FECHA REGISTRO</label>
                                <div class="col-md-12">
                                    <input type="date" class="form-control" min="1875-01-01" max="{{ date('Y-m-d') }}" name="fecha_registro" id="fecha_registro" value="{{ $format->fecha_registro }}" onkeyup="IsModify(this)" />
                                    <div class="invalid-feedback">La fecha no podra ser superior a la fecha actual</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="ultima_recategorizacion" class="col-md-12 col-form-label">ULTIMA RECATEGORIZACI&Oacute;N</label>
                                <div class="col-md-12">
                                    <input type="date" class="form-control" min="1875-01-01" max="{{ date('Y-m-d') }}" name="ultima_recategorizacion" id="ultima_recategorizacion" value="{{ $format->ultima_recategorizacion }}" onkeyup="IsModify(this)" />
                                    <div class="invalid-feedback">La fecha no podra ser superior a la fecha actual</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="antiguedad_anios" class="col-md-12 col-form-label">ANTIGUEDAD DEL EE.SS</label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" name="antiguedad_anios" id="antiguedad_anios" value="" maxlength="50" />
                                    <div class="invalid-feedback">Antiguedad en a&ntides;os</div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label for="categoria_inicial" class="col-md-12 col-form-label">CATEGORIA INICIAL</label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control alfanumerico" maxlength="15" name="categoria_inicial" id="categoria_inicial" value="{{ $format->categoria_inicial }}" onkeyup="IsModify(this)" />
                                </div>
                            </div>
                            <div class="col-md-6 row g-0">
                                <div class="col-md-4">
                                    <label for="categoria_inicial" class="col-md-12 col-form-label">QUINTIL</label>
                                    <div class="col-md-12">
                                        <select class="form-control" id="quintil" name="quintil">
                                            <option value="">Seleccione</option>
                                            <option value="1" <?php echo ($format->quintil == "1" ? "selected" : "") ?>>1</option>
                                            <option value="2" <?php echo ($format->quintil == "2" ? "selected" : "") ?>>2</option>
                                            <option value="3" <?php echo ($format->quintil == "3" ? "selected" : "") ?>>3</option>
                                            <option value="4" <?php echo ($format->quintil == "4" ? "selected" : "") ?>>4</option>
                                            <option value="5" <?php echo ($format->quintil == "5" ? "selected" : "") ?>>5</option>
                                        </select>
                                    </div>
                                </div>  
                                <div class="col-md-5">
                                    <label for="categoria_inicial" class="col-md-12 col-form-label">PCM/ZONA</label>
                                    <div class="col-md-12">
                                        <select class="form-control" id="pcm_zona" name="pcm_zona">
                                            <option value="">Seleccione</option>
                                            <option value="URBANO" <?php echo ($format->pcm_zona == "URBANO" ? "selected" : "") ?>>URBANO</option>
                                            <option value="RURAL" <?php echo ($format->pcm_zona == "RURAL" ? "selected" : "") ?>>RURAL</option>
                                        </select>
                                    </div>
                                </div>  
                                <div class="col-md-3">
                                    <label for="frontera" class="col-md-12 col-form-label">FRONTERA</label>
                                    <div class="col-md-12">
                                        <select class="form-control" id="frontera" name="frontera">
                                            <option value="">Seleccione</option>
                                            <option value="0" <?php echo ($format->frontera == "0" ? "selected" : "") ?>>0</option>
                                            <option value="1" <?php echo ($format->frontera == "1" ? "selected" : "") ?>>1</option>
                                        </select>
                                    </div>
                                </div>  
                            </div>
                        </div>
                    </div>
                </div>
                <ul class="nav nav-tabs mt-2" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true" style="font-weight: bold;background:#dee2e6;">
                            DATOS ADICIONALES
                        </button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab" style="border: 1px solid;border-color: #dee2e6;border-bottom-left-radius: .25rem;border-bottom-right-radius: .25rem;">
                        <div class="row g-0 pb-2" style="font-size: 10px;">
                            <div class="col-md-2">
                                <label for="numero_camas" class="col-md-12 col-form-label">N&Uacute;MERO DE CAMAS</label>
                                <div class="col-md-12">
                                    <input type="number" class="form-control" name="numero_camas" id="numero_camas" value="{{ $format->numero_camas }}" onkeyup="IsModify(this)" />
                                    <div class="invalid-feedback">Digite el n&uacute;mero de camas</div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label for="autoridad_sanitaria" class="col-md-12 col-form-label">AUTORIDAD SANITARIA</label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" name="autoridad_sanitaria" id="autoridad_sanitaria" value="{{ $format->autoridad_sanitaria }}" onkeyup="IsModify(this)"  maxlength="150" />
                                    <div class="invalid-feedback">Digite la Autoridad Sanitaria</div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label for="propietario_ruc" class="col-md-12 col-form-label">PROPIETARIO RUC</label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" name="propietario_ruc" id="propietario_ruc" value="{{ $format->propietario_ruc }}" onkeyup="IsModify(this)"  maxlength="11"/>
                                    <div class="invalid-feedback">Digite el Ruc del Propietario</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="propietario_razon_social" class="col-md-12 col-form-label">PROPIETARIO RAZON SOCIAL</label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" name="propietario_razon_social" id="propietario_razon_social" value="" maxlength="150"/>
                                    <div class="invalid-feedback">Digite la Razon Social del Propietario</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="situacion_estado" class="col-md-12 col-form-label">SITUACION ESTADO</label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" name="situacion_estado" id="situacion_estado" value="{{ $format->situacion_estado }}" onkeyup="IsModify(this)" maxlength="100" />
                                    <div class="invalid-feedback">Digite la Raz&oacute;n Social del Propietario</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="situacion_condicion" class="col-md-12 col-form-label">SITUACION CONDICION</label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" name="situacion_condicion" id="situacion_condicion" value="{{ $format->situacion_condicion }}" onkeyup="IsModify(this)" maxlength="100" />
                                    <div class="invalid-feedback">Digite la Condici&oacute;n Sitaci&oacute;n</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                2. LOCALIZACI&Oacute;N GEOGR&Aacute;FICA
              </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
              <div class="accordion-body">
                <div class="mb-3 row g-0" style="font-size: 12px;">
                    <label for="direccion" class="col-md-2 col-form-label">DIRECCI&Oacute;N</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control text" maxlength="300" name="direccion" id="direccion" value="{{ $format->direccion }}" onkeyup="IsModify(this)" />
                    </div>
                </div>
                <div class="mb-3 row g-0" style="font-size: 12px;">
                    <label for="referencia" class="col-md-2 col-form-label d-flex align-items-center justify-content-between">
                        REFERENCIA
                        <img src="{{ asset('img/google_maps_logo_icon.png') }}" class="mr-2"  style="width:24px;cursor:pointer" onclick="onGoogleMaps()" />
                    </label>
                    <div class="col-md-10">
                        <input type="text" class="form-control text" maxlength="200"  name="referencia" id="referencia" value="{{ $format->referencia }}" onkeyup="IsModify(this)" />
                    </div>
                </div>
                <div class="mb-3 row g-0" style="font-size: 12px;">
                    <label for="cota" class="col-md-2 col-form-label">
                        M.S.N.M. (ALTITUD)<br/>
                    </label>
                    <div class="col-md-2">
                        <input type="text" class="form-control" maxlength="200"  name="cota" id="cota" value="{{ $format->cota }}" onkeyup="IsModify(this)" 
                        onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode == 46 && !this.value.includes('.') && this.value.length > 0) || (event.charCode == 45 && this.value.length == 0))" />
                    </div>
                    <label for="coordenada_utm_norte" class="col-md-2 col-form-label">COORDENADAS UTM NORTE</label>
                    <div class="col-md-2">
                        <input type="text" class="form-control" maxlength="100" name="coordenada_utm_norte" id="coordenada_utm_norte" value="{{ $format->coordenada_utm_norte }}" onkeyup="IsModify(this)"
                        onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode == 46 && !this.value.includes('.') && this.value.length > 0) || (event.charCode == 45 && this.value.length == 0))" />
                    </div>
                    <label for="coordenada_utm_este" class="col-md-2 col-form-label">COORDENADAS UTM ESTE</label>
                    <div class="col-md-2">
                        <input type="text" class="form-control" maxlength="100" name="coordenada_utm_este" id="coordenada_utm_este" value="{{ $format->coordenada_utm_este }}" onkeyup="IsModify(this)"
                            onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode == 46 && !this.value.includes('.') && this.value.length > 0) || (event.charCode == 45 && this.value.length == 0))" />
                    </div>
                </div>
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingSeven">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                3 INDICE SEGURIDAD HOSPITALARIA
              </button>
            </h2>
            <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <div class="mb-3 row g-0 d-flex align-items-center" style="font-size: 12px;">
                        <label class="col-md-3 col-form-label">¿CUENTO CON EL DOCUMENTO DE INDICE DE SEGURIDAD HOSPITALARIA?</label>
                        <div class="col-md-3">
                            <div class="form-check form-check-inline d-inline-flex">
                                <input class="form-check-input" type="radio" name="seguridad_hospitalaria" onchange="IsSeguridad(true)" <?php echo ($format->seguridad_hospitalaria == "SI" ? "checked" : ""); ?> id="seguridad_hospitalaria1" value="SI">
                                <label class="form-check-label" for="seguridad_hospitalaria1">SI</label>
                            </div>
                            <div class="form-check form-check-inline d-inline-flex">
                                <input class="form-check-input" type="radio" name="seguridad_hospitalaria" onchange="IsSeguridad(false)" <?php echo ($format->seguridad_hospitalaria == "NO" ? "checked" : ""); ?> id="seguridad_hospitalaria2" value="NO">
                                <label class="form-check-label" for="seguridad_hospitalaria2">NO</label>
                            </div>
                        </div>
                        <label for="seguridad_resultado" class="col-md-3 col-form-label">¿CUAL FUE EL RESULTADO? <span class="text-danger">(*)</span></label>
                        <div class="col-md-3">
                            <select class="form-control" name="seguridad_resultado" id="seguridad_resultado" <?php echo ($format->seguridad_hospitalaria != "SI" ? "disabled" : ""); ?>>
                                <option value="">Seleccione</option>
                                <option value="CATEGORIA A" <?php echo ($format->seguridad_resultado == "CATEGORIA A" ? "selected" : "") ?>>CATEGORIA A</option>
                                <option value="CATEGORIA B" <?php echo ($format->seguridad_resultado == "CATEGORIA B" ? "selected" : "") ?>>CATEGORIA B</option>
                                <option value="CATEGORIA C" <?php echo ($format->seguridad_resultado == "CATEGORIA C" ? "selected" : "") ?>>CATEGORIA C</option>
                            </select>
                            <div class="invalid-feedback">Seleccione el Resultado</div>
                        </div>
                    </div>
                    <div class="mb-3 row g-0 d-flex align-items-center" style="font-size: 12px;">
                        <label for="seguridad_fecha" class="col-lg-6 col-sm-9 col-form-label">EN QUE A&Ntilde;O SE REALIZ&Oacute; EL &Uacute;LTIMO INDICE DE SEGURIDAD HOSPITALARIA <span class="text-danger">(*)</span></label>
                        <div class="col-md-3">
                            <input type="date" class="form-control" name="seguridad_fecha" id="seguridad_fecha" min="1875-01-01" max="{{ date('Y-m-d') }}" value="{{ $format->seguridad_fecha }}">
                            <div class="invalid-feedback">La fecha no podra ser superior a la fecha actual</div>
                        </div>
                    </div>
                </div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingThree">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                4. CONDICI&Oacute;N DE PATRIMONIO CULTURAL
              </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
              <div class="accordion-body">
                <div class="mb-3 row g-0 d-flex align-items-center" style="font-size: 12px;">
                    <div class="col-md-4">
                        <label class="col-md-12 col-form-label">¿LA IPRESS ES CONSIDERADA COMO PATRIMONIO CULTURAL?</label>
                        <div class="col-md-12">
                            <div class="form-check form-check-inline d-inline-flex">
                                <input class="form-check-input" type="radio" name="patrimonio_cultural" onchange="IsPatrimonio(true)" <?php echo ($format->patrimonio_cultural == "SI" ? "checked" : ""); ?> id="patrimonio_cultural1" value="SI">
                                <label class="form-check-label" for="patrimonio_cultural1">SI</label>
                            </div>
                            <div class="form-check form-check-inline d-inline-flex">
                                <input class="form-check-input" type="radio" name="patrimonio_cultural" onchange="IsPatrimonio(false)" <?php echo ($format->patrimonio_cultural == "NO" ? "checked" : ""); ?> id="patrimonio_cultural2" value="NO">
                                <label class="form-check-label" for="patrimonio_cultural2">NO</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="fecha_emision" class="col-md-12 col-form-label">¿FECHA DE RECONOCIMIENTO COMO PATRIMONIO CULTURAL? <span class="text-danger">(*)</span></label>
                        <div class="col-md-12">
                            <input type="date" class="form-control" name="fecha_emision" id="fecha_emision" min="1875-01-01" max="{{ date('Y-m-d') }}" value="{{ $format->fecha_emision }}">
                            <div class="invalid-feedback">La fecha no podra ser superior a la fecha actual</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="numero_documento" class="col-md-12 col-form-label">N&Uacute;MERO DE RESOLUCIÓN</label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" name="numero_documento" id="numero_documento" value="{{ $format->numero_documento }}" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)" maxlength="8" />
                        </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingFive">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
               5. DATOS DEL DIRECTOR O ADMINISTRADOR DE LA IPRESS
              </button>
            </h2>
            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
              <div class="accordion-body">
                <div class="row g-0" style="font-size: 10px;">
                    <div class="col-md-3">
                        <label for="tipo_documento_registrador" class="col-md-12 col-form-label">TIPO DE DOCUMENTO <span class="text-danger">(*)</span></label>
                        <div class="col-md-12">
                            <select class="form-control" name="tipo_documento_registrador" id="tipo_documento_registrador" onchange="TipoDocumentoRegistrador()" required>
                                <option value="">Seleccione</option>
                                @foreach($tipodocumentos as $tipodocumento)
                                    <option value="{{ $tipodocumento->id }}" <?php echo ($tipodocumento->id == $format->tipo_documento_registrador ? "selected" : "") ?>>{{ $tipodocumento->nombre }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Seleccione el Tipo de Documento</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="doc_entidad_registrador" class="col-md-12 col-form-label">DOC. DE IDENTIDAD <span class="text-danger">(*)</span></label>
                        <div class="col-md-12">
                            <input type="number" minlength="8" maxlength="8" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="form-control" name="doc_entidad_registrador" id="doc_entidad_registrador" value="{{ $format->doc_entidad_registrador }}" onkeyup="IsDocumentoRegistrador()" onchange="TipoDocumentoRegistrador()" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)" required/>
                            <div class="invalid-feedback doc_entidad_registrador">El doc. de identidad debe contener 8 caracteres</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="nombre_registrador" class="col-md-12 col-form-label">NOMBRES Y APELLIDOS <span class="text-danger">(*)</span></label>
                        <div class="col-md-12">
                            <input type="text" class="form-control texto" maxlength="200" name="nombre_registrador" id="nombre_registrador" value="{{ $format->nombre_registrador }}" onkeyup="IsModify(this)" required />
                            <div class="invalid-feedback">Digite el nombre</div>
                        </div>
                    </div>
                </div>
                <div class="row g-0" style="font-size: 10px;">
                    <div class="col-md-4">
                        <label for="id_profesion_registrador" class="col-md-12 col-form-label">PROFESI&Oacute;N <span class="text-danger">(*)</span></label>
                        <div class="col-md-12">
                            <select class="form-control" name="id_profesion_registrador" id="id_profesion_registrador">
                                <option value="">SELECCIONAR</option>
                                @foreach($profesiones as $profesion)-->
                                    <option value="{{ $profesion->id }}">{{ $profesion->nombre }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Digite la Profesi&oacute;n</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="cargo_registrador" class="col-md-12 col-form-label">CARGO O FUNCI&Oacute;N <span class="text-danger">(*)</span></label>
                        <div class="col-md-12">
                            <input type="text" class="form-control texto" maxlength="100" name="cargo_registrador" id="cargo_registrador" value="{{ $format->cargo_registrador }}" onkeyup="IsModify(this)" required />
                            <div class="invalid-feedback">Digite el Cargo o Funci&oacute;n</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="condicion_laboral" class="col-md-12 col-form-label">CONDICI&Oacute;N LABORAL <span class="text-danger">(*)</span></label>
                        <div class="col-md-12">
                            <select class="form-control" name="condicion_laboral" id="condicion_laboral" onchange="CondicionLaboral()">
                                <option value="">SELECCIONE</option>
                                @foreach($condiciones as $condicion)
                                    <option value="{{ $condicion->id }}">{{ $condicion->nombre }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Seleccione la Condici&oacunte;n Laboral</div>
                        </div>
                    </div>
                    <div class="col-md-4 contenido_condicion_profesional_otro" style="display:none">
                        <label for="condicion_profesional_otro" class="col-md-12 col-form-label">OTRO <span class="text-danger">(*)</span></label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" maxlength="100" name="condicion_profesional_otro" id="condicion_profesional_otro" value="{{ $format->condicion_profesional_otro }}" onkeyup="IsModify(this)" />
                            <div class="invalid-feedback">Digite la Condici&oacunte;n Laboral</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="regimen_laboral" class="col-md-12 col-form-label">R&Eacute;GIMEN LABORAL <span class="text-danger">(*)</span></label>
                        <div class="col-md-12">
                            <select class="form-control" name="regimen_laboral" id="regimen_laboral" onchange="RegimenLaboral()">
                                <option value="">SELECCIONE</option>
                                @foreach($regimenes as $regimen)
                                    <option value="{{ $regimen->id }}">{{ $regimen->nombre }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Seleccione la Condici&oacunte;n Laboral</div>
                        </div>
                    </div>
                    <div class="col-md-4 contenido_regimen_laboral_otro" style="display:none">
                        <label for="regimen_laboral_otro" class="col-md-12 col-form-label">OTRO <span class="text-danger">(*)</span></label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" maxlength="100" name="regimen_laboral_otro" id="regimen_laboral_otro" value="{{ $format->regimen_laboral_otro }}" onkeyup="IsModify(this)" />
                            <div class="invalid-feedback">Digite la Condici&oacunte;n Laboral</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="email_registrador" class="col-md-12 col-form-label">CORREO ELECTR&Oacute;NICO <span class="text-danger">(*)</span></label>
                        <div class="col-md-12">
                            <input type="email" class="form-control" placeholder="example@example.com" maxlength="200" name="email_registrador" id="email_registrador" value="{{ $format->email_registrador }}" onkeyup="IsModify(this)" required />
                            <div class="invalid-feedback">El correo es obligatorio</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="movil_registrador" class="col-md-12 col-form-label">N&Uacute;MERO CELULAR <span class="text-danger">(*)</span></label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" placeholder="999999999" name="movil_registrador" id="movil_registrador" value="{{ $format->movil_registrador }}" onkeyup="IsModify(this)" minlength="9" maxlength="9" 
                             onkeypress="return (event.charCode >= 48 && event.charCode <= 57)" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required />
                            <div class="invalid-feedback">El celular debe empezar con 9 y tener 9 digitos</div>
                        </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div style="display: flex; justify-content: center;">
                    <button type="submit" class="btn btn-primary" id="btn-guardar" style="display:none"></button>
                    <button type="button" class="btn btn-primary" onclick="GuardarClick()">Guardar</button>
                </div>
            </div>
        </div>
    </form>
    @cannot('Datos Generales - Crear') @cannot('Datos Generales - Editar')
      <script>
        document.querySelectorAll('#accordionExample input, #accordionExample select').forEach(function (el) {
            if (el.id !== "codigo_ipre") {
                el.setAttribute('readonly', true);
                el.setAttribute('disabled', true);
            }
        });
      </script> 
    @endcannot @endcannot
    <script>
        let is_modify = false, limit = false, click = false, is_creacion = false;
        function IsModify(item) {
            debugger;
            is_modify = true;
            limit = false;
            click = false;
        }
        
        $(function () {
            var forms = document.querySelectorAll('#Formato.needs-validation');
            Array.prototype.slice.call(forms).forEach(function (form) {
                debugger;
                form.addEventListener('submit', function (event) {
                debugger;
                    event.preventDefault();
                    event.stopPropagation();
                                
                    var codigoIpre = $("#codigo_ipre").val();
                    
                    if (form.checkValidity()) {
                        $.ajax({
                            type: "POST",
                            url : "{{ route('format-0-save') }}",
                            data : new FormData(this),
                            contentType: false,
                            processData: false,
                            success : function(result) {
                                debugger;
                                Swal.fire({
                                    title: (result.status == "OK" ? "INFORMATIVO" : "ALERTA"),
                                    text: result.mensaje,
                                    icon: (result.status == "OK" ? (click ? "success" : "info") : "warning"),
                                    confirmButtonText: "OK",
                                    confirmButtonColor: "#3085d6",
                                });
                                if (result.status == "OK") {
                                    is_creacion = false;
                                    $("#es_creacion").val("0");
                                }
                                is_modify = false;
                                click = false;
                            },
                        });
                    } else {
                        const primerError = form.querySelector(":invalid");
                        if (primerError) {
                            let accordionItem = primerError.closest('.accordion-collapse');
                            if (accordionItem && !accordionItem.classList.contains('show')) {
                                let accordionButton = accordionItem.previousElementSibling.querySelector('.accordion-button');
                                if (accordionButton) {
                                    accordionButton.click();
                                }
                            }
                    
                            primerError.scrollIntoView({ behavior: "smooth", block: "center" });
                            primerError.focus();
                            primerError.classList.add("border-danger");
                            setTimeout(() => {
                                primerError.classList.remove("border-danger");
                            }, 3000);
                        }

                        if (!codigoIpre || codigoIpre.trim() === "") {
                            Swal.fire({
                                title: "ALERTA",
                                html: "Agregar el c&oacute;digo IPRESS como campo obligatorio",
                                icon: "warning",
                                confirmButtonText: "OK",
                                confirmButtonColor: "#3085d6",
                            });
                            return;
                        }
                    
                        Swal.fire({
                            title: "ALERTA",
                            text: "Complete todos los campos obligatorios",
                            icon: "warning",
                            confirmButtonText: "OK",
                            confirmButtonColor: "#3085d6",
                        });
                        is_modify = false;
                        click = false;
                    }
                    form.classList.add('was-validated');
                }, false);
            });
            
            if (!!$("#codigo_ipre").val()) {
                SearchFormat();
            }
        });
        
        function GuardarClick() {
            click = true;
            is_modify = true;
            limit = true;
            is_creacion = false;
            guardar();
        }
        
        function guardar() { 
            debugger;
            if (is_modify && limit && !is_creacion) {
                $("#btn-guardar").click();
            }
        }
        
        $(function() {
            setInterval(function(){
                limit = true;
            }, 10000)
            setInterval(guardar, 60000);
        });
        
        function BloqueoInput(EsCreacion) {
            if (!$("#idinstitucion").val()) {
                $("#idinstitucion").prop("disabled", false);
            } else {
                $("#idinstitucion").prop("disabled", !EsCreacion);
            }
            
            if (!$("#nombre_eess").val()) {
                $("#nombre_eess").prop("readonly", false);
            }else {
                $("#nombre_eess").prop("readonly", !EsCreacion);
            }
            
            if (!$("#idregion").val()) {
                $("#idregion").prop("disabled", false);
            } else {
                $("#idregion").prop("disabled", !EsCreacion);
            }
            
            if (!$("#idprovincia").val()) {
                $("#idprovincia").prop("disabled", false);
            } else {
                $("#idprovincia").prop("disabled", !EsCreacion);
            }
            
            if (!$("#iddistrito").val()) {
                $("#iddistrito").prop("disabled", false);
            } else {
                $("#iddistrito").prop("disabled", !EsCreacion);
            }
            
            if (!$("#nombre_red").val()) {
                $("#nombre_red").prop("readonly", false);
            } else {
                $("#nombre_red").prop("readonly", !EsCreacion);
            }
            
            if (!$("#director_medico").val()) {
                $("#director_medico").prop("readonly", false);
            } else {
                $("#director_medico").prop("readonly", !EsCreacion);
            }
            
            if (!$("#nombre_microred").val()) {
                $("#nombre_microred").prop("readonly", false);
            } else {
                $("#nombre_microred").prop("readonly", !EsCreacion);
            }
        }
        
        var condiciones = JSON.parse('<?php echo $condiciones; ?>');
        var regimenes = JSON.parse('<?php echo $regimenes; ?>');
        var controladorTiempo = "";
        function SearchFormat() {
            debugger;
            $.ajax({
                type: "GET",
                url : "{{ route('format-0-search') }}/" + $("#codigo_ipre").val(),
                beforeSend: function() {
                    Swal.fire({
                        title: "Importante",
                        html: "Esta buscando espere un momento...",
                        timerProgressBar: true,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        },
                    });  
                },
                error: function(xhr) { 
                    debugger;            
                    Swal.close();
                    console.log("error")
                },
                success: function(r) {
                    debugger;            
                    Swal.close();
                    $("#es_creacion").val("0");
                    if (r.format != null) {
                        if (r.creacion) {
                            @cannot('Datos Generales - Crear')
                                Swal.fire({
                                    title: "ALERTA",
                                    text: "C&oacute;digo IPRESS ingresado no se encuentra en RENIPRESS y  no tiene los permisos necesarios para crear un nuevo establecimiento.",
                                    icon: "warning",
                                    confirmButtonText: "OK",
                                    confirmButtonColor: "#3085d6",
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                });
                            @else
                                Swal.fire({
                                    title: "ALERTA",
                                    html: 'C&oacute;digo IPRESS ingresado no se encuentra en RENIPRESS, si su establecimiento se encuentra en proceso de categorizaci&oacute;n/recategorizaci&oacute;n puede continuar... <br/> Desea agregar el establecimiento.',
                                    icon: "warning",
                                    showCancelButton: true,
                                    confirmButtonText: "Si",
                                    cancelButtonText: "No",
                                    confirmButtonColor: "#3085d6",
                                    cancelButtonColor: "#d33",
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                }).then((result) => {
                                    onDataEstablecimiento(r);
                                    if (result.isConfirmed) {
                                        is_creacion = true;
                                        $("#es_creacion").val("1");
                                        BloqueoInput(true);
                                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                                        is_creacion = false;
                                        $("#es_creacion").val("0");
                                        BloqueoInput(false);
                                        $("#codigo_ipre").val('');
                                    }
                                });
                            @endcannot
                        } else {
                            is_creacion = false;
                            $("#es_creacion").val("0");
                            onDataEstablecimiento(r);
                            BloqueoInput(false);
                        }
                    } else {
                        Swal.fire({
                            title: "ALERTA",
                            text: r.mensaje,
                            icon: "warning",
                            confirmButtonText: "OK",
                            confirmButtonColor: "#3085d6",
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                        });
                    }
                },
            });
        }
        
        function onDataEstablecimiento(r) {
            $("[type=radio]").prop("checked", false);
                        
            $("#id_establecimiento").val(r.establishment.id);
            $("#idinstitucion option[value='" + (r.establishment.id_institucion??"") + "']").prop("selected", true);
            $("#nombre_eess").val(r.establishment.nombre_eess);
            $("#idregion option[value='']").prop("selected", true);
            $("#idregion option[value='" + (r.establishment.idregion??"") + "']").prop("selected", true);
            
            $("#idprovincia").html('<option value="">Seleccione</option>');
            r.provincias.map((provincia) => {
                $("#idprovincia").append('<option value="' + provincia.id + '">' + provincia.nombre + '</option>');
            });
            $("#idprovincia option[value='" + (r.establishment.idprovincia??"") + "']").prop("selected", true);
            
            $("#iddistrito").html('<option value="">Seleccione</option>');
            r.distritos.map((distrito) => {
                $("#iddistrito").append('<option value="' + distrito.id + '">' + distrito.nombre + '</option>');
            });
            $("#iddistrito option[value='" + (r.establishment.iddistrito??"") + "']").prop("selected", true);
            
            $("#nombre_red").val(r.establishment.nombre_red);
            $("#nombre_microred").val(r.establishment.nombre_microred);
            
            if (r.establishment.nivel_atencion != "I" && r.establishment.nivel_atencion != "II" && r.establishment.nivel_atencion != "III" && r.establishment.nivel_atencion != "") {
                if (!!r.establishment.categoria) {
                    if (r.establishment.categoria.includes("III")) {
                        $('#nivel_atencion option[value="III"]').prop("selected", true);
                    } else if (r.establishment.categoria.includes("II")) {
                        $('#nivel_atencion option[value="II"]').prop("selected", true);
                    } else if (r.establishment.categoria.includes("I")) {
                        $('#nivel_atencion option[value="I"]').prop("selected", true);
                    } else {
                        document.getElementById("nivel_atencion").selectedIndex = "4";
                    }
                } else {
                    $('#nivel_atencion option[value=""]').prop("selected", true);
                }
            } else {
                $("#nivel_atencion option[value='" + (r.establishment.nivel_atencion??"") + "']").prop("selected", true);
            }
            $("#id_categoria option[value='" + (r.establishment.id_categoria??"") + "']").prop("selected", true);
            $("#resolucion_categoria").val(r.establishment.resolucion_categoria);
            $("#clasificacion").val(r.establishment.clasificacion);
            $("#tipo").val(r.establishment.tipo);
            $("#codigo_unidad_ejecutora").val(r.establishment.codigo_ue);
            $("#unidad_ejecutora").val(r.establishment.unidad_ejecutora);
            $("#director_medico").val(r.establishment.director_medico);
            $("#horario").val(r.establishment.horario);
            $("#telefono").val(r.establishment.telefono);
            $("#inicio_funcionamiento").val(r.establishment.inicio_funcionamiento);
            $("#fecha_registro").val(r.establishment.fecha_registro);
            $("#ultima_recategorizacion").val(r.establishment.ultima_recategorizacion);
            $("#categoria_inicial").val(r.establishment.categoria_inicial);
            $("#antiguedad_anios").val(r.establishment.antiguedad_anios);
            $("#quintil option[value='" + (r.establishment.quintil??"") + "']").prop("selected", true);
            $("#pcm_zona option[value='" + (r.establishment.pcm_zona??"") + "']").prop("selected", true);
            $("#frontera option[value='" + (r.establishment.frontera??"") + "']").prop("selected", true);
            $("#numero_camas").val(r.establishment.numero_camas);
            $("#autoridad_sanitaria").val(r.establishment.autoridad_sanitaria);
            $("#propietario_ruc").val(r.establishment.propietario_ruc);
            $("#propietario_razon_social").val(r.establishment.propietario_razon_social);
            $("#situacion_estado").val(r.establishment.situacion_estado);
            $("#situacion_condicion").val(r.establishment.situacion_condicion);
            $("#direccion").val(r.establishment.direccion);
            $("#referencia").val(r.establishment.referencia);
            $("#cota").val(r.establishment.cota);
            $("#coordenada_utm_norte").val(r.establishment.coordenada_utm_norte);
            $("#coordenada_utm_este").val(r.establishment.coordenada_utm_este);
            
            switch(r.format.seguridad_hospitalaria) {
                case "SI":
                    IsSeguridad(true);
                    $("#seguridad_hospitalaria1").prop("checked", true);
                    break;
                case "NO":
                    IsSeguridad(false);
                    $("#seguridad_hospitalaria2").prop("checked", true);
                    break;
            }
            $("#seguridad_resultado option[value='" + (r.format.seguridad_resultado??"") +"']").prop("selected", true);
            $("#seguridad_fecha").val(r.format.seguridad_fecha);
            
            switch(r.format.patrimonio_cultural) {
                case "SI":
                    IsPatrimonio(true);
                    $("#patrimonio_cultural1").prop("checked", true);
                    break;
                case "NO":
                    IsPatrimonio(false);
                    $("#patrimonio_cultural2").prop("checked", true);
                    break;
            }
            $("#fecha_emision").val(r.format.fecha_emision);
            $("#numero_documento").val(r.format.numero_documento);
                       
            $("#tipo_documento_registrador option[value='" + (r.format.tipo_documento_registrador??"") +"']").prop("selected", true);
            if ($("#tipo_documento_registrador").val() == "" || $("#tipo_documento_registrador").val() == "1") {
                $("#nombre_registrador").prop("readonly", true);
                IsDocumentoRegistrador();
            } else {
                $("#nombre_registrador").prop("readonly", false);
            }             
            $("#doc_entidad_registrador").val(r.format.doc_entidad_registrador);
            $("#nombre_registrador").val(r.format.nombre_registrador);
            $("#id_profesion_registrador option[value='" + (r.format.id_profesion_registrador??"") + "']").prop("selected", true);
            $("#cargo_registrador").val(r.format.cargo_registrador);
            $("#condicion_laboral option[value='" + (r.format.id_condicion_profesional??"") + "']").prop("selected", true);
            $("#regimen_laboral option[value='" + (r.format.id_regimen_laboral??"") + "']").prop("selected", true);
            $("#condicion_profesional_otro").val(r.format.condicion_profesional_otro??"");
            $("#regimen_laboral_otro").val(r.format.regimen_laboral_otro??"");
            $("#email_registrador").val(r.format.email_registrador);
            $("#movil_registrador").val(r.format.movil_registrador);
                        
            debugger;
            $("#nombre_eess").prop("readonly", !!r.format.id_establecimiento);
            $("#nombre_red").prop("readonly", !!r.format.id_establecimiento);
            $("#nombre_microred").prop("readonly", !!r.format.id_establecimiento);

            CondicionLaboral();
            RegimenLaboral();
        }
        
        $("#codigo_ipre").on("keyup", function() {
            clearTimeout(controladorTiempo);
            controladorTiempo = setTimeout(SearchFormat, 1500);
        });
        
        function TipoDocumentoRegistrador() {
            debugger;
            var tipodocumentos = JSON.parse('<?php echo (json_encode($tipodocumentos)) ?>');
            var tipodocumento = tipodocumentos.find(t=>t.id==$("#tipo_documento_registrador").val());
            var maxlength = !!tipodocumento ? tipodocumento.longitud : 15;
            var minlength = !!tipodocumento && tipodocumento.exacto == "1" ? tipodocumento.longitud : 1;
            $("#doc_entidad_registrador").prop('maxlength', maxlength);  
            $("#doc_entidad_registrador").prop('minlength', minlength);
            var mensaje = maxlength == minlength ? "El doc. de identidad debe contener " + maxlength + " caracteres" : 
                "El doc. de identidad debe contar desde " + minlength + " o hasta " + maxlength + " caracteres";
            $(".invalid-feedback.doc_entidad_registrador").html(mensaje);
            var input = $("#doc_entidad_registrador");
            input.val(input.val().length > maxlength ? input.val().slice(0, maxlength) : input.val());
            
            if ($("#tipo_documento_registrador").val() == "" || $("#tipo_documento_registrador").val() == "1") {
                $("#nombre_registrador").prop("readonly", true);
                IsDocumentoRegistrador();
            } else {
                $("#nombre_registrador").prop("readonly", false);
            }
        }
        
        function IsDocumentoRegistrador() {
            var tipo_documento_registrador = $("#tipo_documento_registrador");
            var doc_entidad_registrador = $("#doc_entidad_registrador");
            if (tipo_documento_registrador.val() == 1 && doc_entidad_registrador.val().length == 8) {
                BuscarDocumento(doc_entidad_registrador, $("#nombre_registrador"), $("#director_medico"));
            }
        }
        
        function BuscarDocumento(nroDocumento, personal, director) {
            try {
                try {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('search-dni') }}/" + nroDocumento.val(),
                        success: function(result) {
                            debugger;
                            if (result.status == "OK" && !!result.data) {
                                var person = result.data;
                                if (!!person.nombres && !!person.apellidoPaterno) {
                                    personal.val(person.nombres + " " + person.apellidoPaterno + " " + (person.apellidoMaterno??""));
                                    director.val(person.nombres + " " + person.apellidoPaterno + " " + (person.apellidoMaterno??""));
                                } else {
                                    personal.prop("readonly", false);
                                    director.prop("readonly", false);
                                }
                            } else {
                                personal.prop("readonly", false);
                                director.prop("readonly", false);
                            }
                        },
                    });
                }  catch(error) {
                    throw new Error(error);
                }
            } catch(error) {
                console.log("Error: " + error);
            }
        }
        
        function IsPatrimonio(active) {
            $("#fecha_emision").prop("readonly", !active);
            $("#numero_documento").prop("readonly", !active);
            if (!active) {
                $("#fecha_emision").val("");
                $("#numero_documento").val("");
            }
        }
        
        function IsSeguridad(active) {
            $("#seguridad_resultado").prop("disabled", !active);
            $("#seguridad_fecha").prop("disabled", !active);
            if (!active) {
                $("#seguridad_resultado option[value='']").prop("selected", true);
                $("#seguridad_fecha").val("");
            }
        }
        
        function onChangeRegion() {
            debugger;
            $.ajax({
                type: "GET",
                url : "{{ route('provincias-region') }}/" + $("#idregion").val(),
                success : function(provincias) {
                    debugger;
                    $("#idprovincia").html('<option value="">Seleccione</option>');
                    provincias.map((provincia) => {
                        $("#idprovincia").append('<option value="' + provincia.id + '">' + provincia.nombre + '</option>');
                    });
                },
            });
        }
        
        function onChangeProvincia(){
            debugger;
            $.ajax({
                type: "GET",
                url : "{{ route('distritos-provincia') }}/" + $("#idprovincia").val(),
                success : function(distritos) {
                    debugger;
                    $("#iddistrito").html('<option value="">Seleccione</option>');
                    distritos.map((distrito) => {
                        $("#iddistrito").append('<option value="' + distrito.id + '">' + distrito.nombre + '</option>');
                    });
                },
            });
        }
        
        function onSusalud() {
            debugger;
            if (!$("#codigo_ipre").val()) {
                Swal.fire({
                    title: "ALERTA",
                    text: "Digite el Codigo IPRESS",
                    icon: "warning",
                    confirmButtonText: "OK",
                    confirmButtonColor: "#3085d6",
                });
                return false;
            }
            var codigo_ipre = $("#codigo_ipre").val().trim().padStart(8, 0);
            var endpoint = "<?php echo $url; ?>";
            var url = endpoint  + "?action=mostrarVer&idipress=" + codigo_ipre + "#no-back-button";
            window.open(url, '_blank');
        }
        
        function onGoogleMaps() {
            debugger;
            if (!$("#codigo_ipre").val()) {
                Swal.fire({
                    title: "ALERTA",
                    text: "Digite el Codigo IPRESS",
                    icon: "warning",
                    confirmButtonText: "OK",
                    confirmButtonColor: "#3085d6",
                });
                return false;
            }
            var direccion = $("#direccion").val().trim().replaceAll(" ", "+").replaceAll("/", "%2F");
            var coordenada_utm_norte = $("#coordenada_utm_norte").val().trim();
            var coordenada_utm_este = $("#coordenada_utm_este").val().trim();
            var url = "http://maps.google.com?q=";
            if (!!direccion) {
                var url = "https://www.google.com/maps/search/" + direccion + "/";
            } 
            if (!!coordenada_utm_norte){
                url += coordenada_utm_norte + "," + coordenada_utm_este;
                if (!!coordenada_utm_norte) {
                    url += coordenada_utm_este;
                }
            }
            window.open(url, '_blank');
        }
        
        function CondicionLaboral() {
            var esOtro = (condiciones.find((c) => c.id == $("#condicion_laboral").val())?.otro == 1);
            if (esOtro) {
                $(".contenido_condicion_profesional_otro").show();
                $("#condicion_profesional_otro").attr("required", "true");
            } else {
                $(".contenido_condicion_profesional_otro").hide();
                $("#condicion_profesional_otro").removeAttr("required");
            }
        }
        
        function RegimenLaboral() {
            var esOtro = (regimenes.find((c) => c.id == $("#regimen_laboral").val())?.otro == 1);
            if (esOtro) {
                $(".contenido_regimen_laboral_otro").show();
                $("#regimen_laboral_otro").attr("required", "true");
            } else {
                $(".contenido_regimen_laboral_otro").hide();
                $("#regimen_laboral_otro").removeAttr("required");
            }
        }
    </script>
</x-app-layout>