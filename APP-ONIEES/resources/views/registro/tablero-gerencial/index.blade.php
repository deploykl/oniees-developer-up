<x-app-layout>
    <x-slot name="title">Tablero Gerencial</x-slot>
   <style>
      #spinner-siga {
          position: fixed;
          width: 100%;
          top: 0;
          bottom: 0;
          left: 0;
          right: 0;
          justify-content: center;
          align-items: center;
          z-index: 1100;
          background: rgba(250,250,25025,0.5);
          display: none;
      }
        .board{
            margin: auto;
            height: 250px;
            background-color: #e2e2e2;
            padding: 0px;
            box-sizing: border-box;
            overflow: hidden;
        }
        .sub_board{
            width: 100%;
            height: 100%;
            padding: 0px;
            margin-top: 0px;
            background-color:#f4f4f4;
            overflow: hidden;
            box-sizing: border-box;
        }
        .sep_board{
            width: 100%;
            height: 10%;
        }
        .cont_board{
            width: 100%;
            height: 82%;
        }
        .graf_board{
            width: 100%;
            height: 100%;
            float: right;
            margin-top: 0px;
            border: 2px solid #999999;
            box-sizing: border-box;
            display: flex;
        }
        .barra{
            width:100%;
            height: 100%;
            margin-right: 5px;
            margin-left: 5px;
            background-color: none;
            display: flex;
            flex-wrap: wrap;
            align-items: flex-end;
        }
        .sub_barra{
            width: 100%;
            height: 80%;
            max-height: 90%;
            background-color: #00799b;
            background-color: -moz-linear-gradient(top, #00799b 0%, #64d1be 100%);
            background-color: -webkit-linear-gradient(top, #00799b 0%,#64d1be 100%);
            background-color: linear-gradient(to bottom, #00799b 0%,#64d1be 100%);
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#00799b', endColorstr='#64d1be',GradientType=0 );
            -webkit-border-radius: 3px 3px 0 0;
            border-radius: 3px 3px 0 0;    
            background-image: linear-gradient(45deg,rgba(255,255,255,.15) 25%,
                transparent 25%, transparent 50%, rgba(255,255,255,.15) 50%, rgba(255,255,255,.15) 75%, 
                transparent 75%,transparent);
            background-size: 1rem 1rem;
            -webkit-animation: 1s linear infinite progress-bar-stripes;
            animation: 1s linear infinite progress-bar-stripes;
        }
        .tag_g{
            position: relative;
            width: 100%;
            height: 100%;
            margin-bottom: 30px;
            text-align: center;
            margin-top: -20px;
            z-index: 2;
        }
        .tag_leyenda{
            width: 100%;
            text-align: center;
            margin-top: 5px;
        }
        .tag_board{
            height: 100%;
            width: 13%;
            border-bottom: 2px solid rgba(0,0,0,0);
            box-sizing: border-box;
        }
        .sub_tag_board{
            height: 100%;
            width: 100%;
            display: flex;
            align-items: flex-end;
            flex-wrap: wrap;
        }
        .sub_tag_board>div{
            width: 100%;
            height: 10%;
            text-align: right;
            padding-right: 10px;
            box-sizing: border-box;
        }
   </style>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
   @section('plugins.Select2', true)
    <div id="spinner-siga" style="display: none;">
        <div class="spinner-border" role="status">
             <span class="sr-only">Loading...</span>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h5 class="text-center">TABLERO GERENCIAL DE LOS EQUIPOS REGISTRADOS EN EL SIGA PATRIMONIO</h5>
        </div>
        <div class="card-body p-0" style="background: #C7DFEC">
            <div class="accordion" id="accordionExample">
                <div class="accordion-item" style="font-size: 12px;">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                        Filtros
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-1">
                                        <label for="codigo_ogei" class="form-label">Codigo IPRESS</label>                            
                                        <input type="number" min="1" max="99999999" maxlength="8" class="form-control" name="codigo_ogei" value="" id="codigo_ogei"  placeholder="" 
                                                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)" required />
                                        <div class="invalid-feedback">Digite el Codigo IPRESS</div>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="mb-1">
                                        <label for="nombre_eess" class="form-label">Nombre del Establecimiento</label>
                                        <input type="text" class="form-control" maxlength="200" id="nombre_eess" disabled>
                                        <div class="invalid-feedback">Digite el Nombre del Equipo</div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-1">
                                        <label for="idregion" class="form-label">Regi&oacute;n</label>
                                        <select class="form-control" id="idregion">
                                            <option value="0">TODOS</option>
                                            @foreach($regiones as $region)
                                                <option value="{{ $region->idregion }}" <?php echo($region->idregion == $idregion ? "selected" :  "") ?>>{{ $region->nombre }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">Seleccione la Regi&oacute;n</div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-1">
                                        <label for="provincia" class="form-label">Provincia</label>
                                        <input type="text" class="form-control" id="provincia" disabled>
                                        <div class="invalid-feedback">Digite la Provincia</div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-1">
                                        <label for="codigo_margesi" class="form-label">CODIGO MARGESI</label>
                                        <select class="form-control js-example-basic-single" name="codigo_margesi" id="codigo_margesi">
                                            <option value="">Seleccionar</option>
                                            @if ($codigo_margesi != "")
                                                <option value="{{ $codigo_margesi }}" selected>{{ $codigo_margesi }}</option>
                                            @endif
                                        </select>
                                        <div class="invalid-feedback">Digite la Provincia</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-1">
                                        <label for="nombre_item" class="form-label">Nombre del Equipo</label>
                                        <select class="form-control js-example-basic-single" name="nombre_item" id="nombre_item">
                                            <option value="">Seleccionar</option>
                                            @if ($nombre_item != "")
                                                <option value="{{ $nombre_item }}" selected>{{ $nombre_item }}</option>
                                            @endif
                                        </select>
                                        <div class="invalid-feedback">Digite el Equipo</div>
                                    </div>
                                </div>
                                <div class="col-md-3" style="display: flex;align-items: end;">
                                    <div class="mb-1">
                                        <button class="btn btn-primary" onclick="Filtrar()">
                                            Filtrar <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                    &nbsp;
                                    <div class="mb-1">
                                        <button type="button" class="btn btn-outline-primary" onclick="LimpiarFiltro()">
                                            Limpiar <span class="fa fa-broom"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">
                    <div class="row p-2">
                        <div class="col-md-12 d-grid align-content-between">
                            <div class="grafico-registros-vacio card mb-2" style="display:none">
                                <div class="card-body text-center">
                                    <b class="text-danger">NO HAY REGISTROS</b>
                                </div>
                            </div>
                            <div class="grafico-registros" style="display:block">
                                <div id="piechart_3d" style="width: 100%;max-height: 400px;margin: auto;padding: 5px;"></div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-2">
                             <div class="card border-success mb-3">
                                <div class="card-header bg-transparent border-success">
                                   EQUIPO: <b style="font-weight: 900;" class="siga-nombre_item"></b>    
                                </div>
                                <div class="card-body">
                                   <hr class="mt-0 mb-1">
                                   <div class="row mb-1" style="font-size:9.4px;">
                                      <div class="col-12">
                                         <b>Estados de Conservaci&oacute;n</b>
                                      </div>
                                   </div>
                                   <div class="card-text">
                                      <div class="row g-0">
                                         <div class="col-4" style="font-size: 10px;font-weight: 600;">
                                            1. BUENO
                                         </div>
                                         <div class="col-2" style="font-size: 10px;font-weight: 600;">
                                           <span class="badge rounded-pill siga-desc-bueno" style="background: #198754;color:#ffffff">47307</span>
                                         </div>
                                         <div class="col-6">
                                            <div class="progress mb-1">
                                               <div style="background-color: rgb(25, 135, 84); color: rgb(255, 255, 255); width: 65%; font-size: 10px;" class="progress-bar progress-bar-striped progress-bar-animated siga-desc-porc-bueno" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">50%</div>
                                            </div>
                                         </div>
                                         <div class="col-4" style="font-size: 10px;font-weight: 600;">
                                            2. REGULAR
                                         </div>
                                         <div class="col-2" style="font-size: 10px;font-weight: 600;">
                                            <span class="badge rounded-pill siga-desc-regular mr-2" style="background: #ffd100;color:#000000">37386</span>
                                         </div>
                                         <div class="col-6">
                                            <div class="progress mb-1">
                                               <div style="background-color: rgb(255, 209, 0); color: rgb(0, 0, 0); width: 49%; font-size: 10px;" class="progress-bar progress-bar-striped progress-bar-animated siga-desc-porc-regular" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">34%</div>
                                            </div>
                                         </div>
                                         <div class="col-4" style="font-size: 10px;font-weight: 600;">
                                            3. MALO
                                         </div>
                                         <div class="col-2" style="font-size: 10px;font-weight: 600;">
                                           <span class="badge rounded-pill siga-desc-malo mr-2" style="background: rgb(236, 170, 0);color:#ffffff">14257</span>
                                         </div>
                                         <div class="col-6">
                                            <div class="progress mb-1">
                                               <div style="background-color: rgb(236, 170, 0); color: rgb(255, 255, 255); width: 28%; font-size: 10px;" class="progress-bar progress-bar-striped progress-bar-animated siga-desc-porc-malo" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">13%</div>
                                            </div>
                                         </div>
                                         <div class="col-4" style="font-size: 10px;font-weight: 600;">
                                            4. MUY MALO
                                         </div>
                                         <div class="col-2" style="font-size: 10px;font-weight: 600;">
                                            <span class="badge rounded-pill siga-desc-muy-malo mr-2" style="background: #dc3545;color:#ffffff">3693</span>
                                         </div>
                                         <div class="col-6">
                                            <div class="progress">
                                               <div style="background-color: rgb(220, 53, 69); color: rgb(255, 255, 255); width: 18%; font-size: 10px;" class="progress-bar progress-bar-striped progress-bar-animated siga-desc-porc-muy-malo" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">3%</div>
                                            </div>
                                         </div>
                                         <button type="button" onclick="ListadoEquipos()" style="font-size: 13px;" class="fw-bold mt-1">
                                            Ver listado de equipos
                                         </button>
                                      </div>
                                   </div>
                                </div>
                             </div>
                        </div>
                        <div class="col-md-12">
                           <div id="siga_responsive">
                              <div class="mb-auto p-2">
                                <div id="top_x_div" style="width: 100%; height: 300px;"></div>
                                <center style="background: white;">
                                    <b style="font-size: 11px;text-align:center">CATEGORIA</b>
                                </center>
                              </div>
                           </div>
                      </div>
                    </div>
                 </div>
                <div class="col-md-7">
                   <div class="row">
                      <div class="col-md-12">
                          @include('registro.tablero-gerencial.mapa')
                      </div>
                        <div class="col-md-12">
                             <div>
                                 <small class="p-2" style="font-size: 10px;font-weight: 500;">
                                     <b>Estado Activo de los Equipos Biomedicos</b>
                                 </small>
                                 <ol class="p-2 list-group list-group-numbered" style="font-size: 11px;">
                                    <li class="list-group-item d-flex justify-content-between align-items-start pt-1 pb-1">
                                       <div class="ms-2 me-auto">
                                          <div class="fw-bold">ACTIVO</div>
                                       </div>
                                       <span class="badge rounded-pill" id="siga-desc-estado-activo" style="background: #198754;color:#ffffff">0</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-start pt-1 pb-1">
                                       <div class="ms-2 me-auto">
                                          <div class="fw-bold">BAJA</div>
                                       </div>
                                       <span class="badge rounded-pill" id="siga-desc-estado-baja" style="background: #ffd100;color:#000000">0</span>
                                    </li>
                                 </ol>
                              </div>
                        </div>
                   </div>
                </div>
                <div class="col-md-4" style="display:none">
                   <div class="row p-2">
                        <div class="col-md-12">
                            <div class="card border-success mb-3">
                                <div class="card-header bg-transparent border-success">
                                    RECURSOS HUMANOS 
                                </div>
                                <div class="card-body">
                                   <div class="row" style="font-size: 10px;font-weight: 600;">
                                       <div class="col-sm-12" style="cursor:pointer;" onclick="ListadoRecursos('grupoetareo', 'Grupo Etario', 1)">1. Grupo Etario</div>
                                       <div class="col-sm-12" style="cursor:pointer;" onclick="ListadoRecursos('regimen_laboral', 'R&eacute;gimen Laboral', 2)">2. R&eacute;gimen Laboral</div>
                                       <div class="col-sm-12" style="cursor:pointer;" onclick="ListadoRecursos('condicion_laboral', 'Condici&oacute;n Laboral',2)">3. Condici&oacute;n Laboral</div>
                                       <div class="col-sm-12" style="cursor:pointer;" onclick="ListadoRecursos('condicion_laboral_final', 'Condici&oacute;n Laboral Final',2)">4. Condici&oacute;n Laboral Final</div>
                                       <div class="col-sm-12" style="cursor:pointer;" onclick="ListadoRecursos('cargo_estructural', 'Cargo Estructural',2)">5. Cargo Estructural</div>
                                       <div class="col-sm-12" style="cursor:pointer;" onclick="ListadoRecursos('cargo_a', '>Cargo A',2)">6. Cargo A</div>
                                       <div class="col-sm-12" style="cursor:pointer;" onclick="ListadoRecursos('grupofinal2', 'Grupo Final 2', 2)">7. Grupo Final 2</div>
                                       <div class="col-sm-12" style="cursor:pointer;" onclick="ListadoRecursos('profesion', 'Profesional',2)">8. Profesional</div>
                                   </div> 
                                </div>
                            </div>
                       </div>
                        <div class="col-md-12">
                            <div class="board" id="board-rrhh" style="font-size: 10px;font-weight: 500;display:block;">
                                <div class="sub_board">
                                   <div class="cont_board" style="position: relative;">
                                      <div class="graf_board" id="barra-recursos-humanos">
                                      </div>
                                      <div id="titulo-recursos-humanos" style="display: flex;justify-content: space-around;width: 100%;position: absolute;bottom: -40px;">
                                      </div>
                                   </div>
                                </div>
                            </div>
                       </div>
                   </div>
                </div>
            </div>
        </div>
        <div class="card-footer" style="font-size: 12px;">
            <div class="row">
                @foreach($personsales as $key => $personal)
                <div class="d-grid col-sm-6">
                    <b>{{ $key }}</b>
                    @for($i = 0; $i < $personal->count(); $i++)
                        <small>{{ $personal[$i]->nombre_personal }}</small>
                    @endfor
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="modal fade" id="staticBackdropI" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropILabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="width:100%;max-width:550px;">
            <div class="modal-content">
                <div class="modal-header pt-2 pb-2 bg-info">
                    <input type="hidden" value="" id="input-tipo-rrhh" />
                    <h6 class="modal-title" id="staticBackdropILabel">
                        Recursos Humanos <b id="tipo-rrhh"></b>
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="font-size: 10px;background-color: honeydew;"></button>
                </div>
                <div class="modal-body pt-2 pb-2">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" style="font-size:12px">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-truncate">Nombre</th>
                                    <th scope="col" class="text-truncate" style="width: 30px;">Cantidad</th>
                                </tr>
                            </thead>
                            <tbody id="table-content-recursos-humanos">
                            </tbody>
                       </table>
                    </div>
                </div>
                <div class="modal-footer pt-2 pb-2 d-flex justify-content-between">
                    <p class="text-sm text-gray-700 leading-5">
                        <span>Mostrando</span>
                        <span class="font-medium" id="total-rrhh">0</span>
                        <span>resultados</span>
                    </p>
                    <div class="btn-group" role="group">
                        <button class="btn btn-success" style="font-size:13px" onclick="ExportarReporteRecursosHumanos()">
                            Exportar Reporte <i class="fas fa-file-excel"></i>
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="font-size: 13px;">CERRAR</button>
                    </div>
                 </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="width:100%;max-width:900px;">
            <div class="modal-content">
                <div class="modal-header pt-2 pb-2 bg-info">
                    <h6 class="modal-title" id="staticBackdropLabel">
                        Equipos SIGA
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="font-size: 10px;background-color: honeydew;"></button>
                </div>
                <div class="modal-body pt-2 pb-2">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" style="font-size:12px">
                            <thead>
                                <tr>
                                    <!--<th scope="col" class="text-truncate">IPRESS</th>-->
                                    <th scope="col" class="text-truncate">Equipo</th>
                                    <th scope="col" class="text-truncate" style="width: 30px;">Bueno</th>
                                    <th scope="col" class="text-truncate" style="width: 35px;">Regular</th>
                                    <th scope="col" class="text-truncate" style="width: 25px;">Malo</th>
                                    <th scope="col" class="text-truncate" style="width: 40px;">Muy Malo</th>
                                    <th scope="col" class="text-truncate" style="width: 65px;">Total(R + M + MM)</th>
                                    <th scope="col" class="text-truncate" style="width: 80px;">Total General(B + Total)</th>
                                </tr>
                            </thead>
                            <tbody id="table-content-equipos">
                            </tbody>
                            <tfoot>
                                <tr class="text-truncate">
                                    <td class="align-middle text-center p-4" colspan="7">
                                        <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
                                            <span class="relative z-0 inline-flex rounded-md shadow-sm" id="pagination_number"></span>
                                        </nav>
                                    </td>
                                </tr>
                          </tfoot>
                       </table>
                    </div>
                </div>
                <div class="modal-footer pt-2 pb-2 d-flex justify-content-between">
                    <p class="text-sm text-gray-700 leading-5">
                        <span>Mostrando</span>
                        <span class="font-medium" id="from">0</span>
                        <span>a</span>
                        <span class="font-medium" id="to">0</span>
                        <span>de</span>
                        <span class="font-medium" id="total">0</span>
                        <span>resultados</span>
                    </p>
                    <div class="btn-group" role="group">
                        <button class="btn btn-success" style="font-size:13px" onclick="ExportarReporte()">
                            Exportar Reporte <i class="fas fa-file-excel"></i>
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="font-size: 13px;">CERRAR</button>
                    </div>
                 </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.0.0/chartjs-plugin-datalabels.min.js" integrity="sha512-R/QOHLpV1Ggq22vfDAWYOaMd5RopHrJNMxi8/lJu8Oihwi4Ho4BRFeiMiCefn9rasajKjnx9/fTQ/xkWnkDACg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        var regiones = [], regiones_eess = [];
        var bueno = 1, regular = 1, malo = 1, muymalo = 1;
        let myChart = null;
        
        var controladorTiempo = "";
        $("#codigo_ogei").on("keyup", function() {
            clearTimeout(controladorTiempo);
            controladorTiempo = setTimeout(SearchFormat, 1000);
        });
    
        function LimpiarFiltro() {
            $("#loader").removeClass("d-none");
            
            $("#codigo_ogei").val("");
            $("#nombre_eess").val("");
            $("#provincia").val("");
            $("#idregion").val("");
            $("#codigo_margesi").empty();
            $("#nombre_item").empty();
            
            SearchFormat();
                
            setTimeout(() => {
                $("#loader").addClass("d-none");
            }, 1500);
        }
        
        $(function() {
            //COMBO
            $('.js-example-basic-single#codigo_margesi').select2({
                placeholder: "Digite un Codigo",
                language: "es",
                "language": {
                    "noResults": function() {
                        return "No hay resultados";
                    },
                    searching: function() {
                        return "Buscando...";
                    },
                },
                width: '100%',
                ajax: {
                    url: "{{ route('busqueda-codigo-margesi-tablero') }}",
                    method: "POST",
                    data : function ({term, page}) {
                        debugger;
                        var queryParameters = {
                            _token : "{{ csrf_token() }}",
                            search : term??"-",
                            codigo_ogei : !!$("#codigo_ogei").val() ? $("#codigo_ogei").val() : "-",
                            idregion : !!$("#idregion").val() ? $("#idregion").val() : "0",
                        }
                        return queryParameters;
                    },
                    processResults: function (response) {
                        debugger;
                        var items = [{ 
                            text: (!!response.search && response.search != "-" ? ('Codigo Margesi que contenga: ' + response.search) : "Todos los Codigos"),
                            id: response.search??"-"
                        }];
                        $.each(response.data, function (index, value) {
                            debugger;
                            if (!!value[0]) {
                                items.push({ text: value[0].id, id: value[0].id });
                            } else {
                                items.push({ text: value.id, id: value.id });
                            }
                        });
                        debugger;
                        return {
                            results: $.map(items, function (item) {
                                return {
                                    id : item.id , 
                                    text : item.text
                                };
                            })
                        };
                    }
                }
            });
            
            regiones = JSON.parse('<?php echo json_encode($regiones); ?>');
            regiones_eess = JSON.parse('<?php echo json_encode($regiones_eess); ?>');
            debugger;
            
            //GRAFICO CIRCULAR
            google.charts.load("current", {packages:["corechart",'corechart']});
            google.charts.setOnLoadCallback(() => drawChartPie(muymalo, malo, regular, bueno));
        
            //FILTRO POR REGION
            onRegion($("#idregion").val());
             
            //COMBO
            $('.js-example-basic-single#nombre_item').select2({
                placeholder: "Selecciona un Equipo",
                language: "es",
                "language": {
                    "noResults": function() {
                        return "No hay resultados";
                    },
                    searching: function() {
                        return "Buscando...";
                    },
                },
                width: '100%',
                ajax: {
                    url: "{{ route('tablero-gerencial-list-group') }}",
                    method: "POST",
                    data : function ({term, page}) {
                        debugger;
                        var queryParameters = {
                            _token : "{{ csrf_token() }}",
                            search : term??"-",
                            idregion : !!$("#idregion").val() ? $("#idregion").val() : "0",
                            codigo_ogei : !!$("#codigo_ogei").val() ? $("#codigo_ogei").val() : "0",
                            codigo_margesi : !!$("#codigo_margesi").val() ? $("#codigo_margesi").val() : "-",
                        }
                        return queryParameters;
                    },
                    processResults: function (response) {
                        debugger;
                        var items = [{ 
                            text: (!!response.search && response.search != "-" ? ('Nombre del Equipo que contenga: ' + response.search) : "Todos los Equipos"),
                            id: response.search??"-"
                        }];
                        $.each(response.data, function (index, value) {
                            debugger;
                            items.push({ text: value.text, id: value.id });
                        });
                        debugger;
                        return {
                            results: $.map(items, function (item) {
                                return {
                                    id : item.id , 
                                    text : item.text
                                };
                            })
                        };
                    }
                }
            });
        });
    
        function drawChartPie(muy_malo, malo, regular, bueno) {
            var data = google.visualization.arrayToDataTable([
                ['Estado', 'Cantidad'],
                ['Muy Malo', muy_malo],
                ['Malo', malo],
                ['Regular', regular],
                ['Bueno', bueno],
            ]);
    
            var options = {
              title: 'Estado de Conservacion de Equipos',
              is3D: true,
              slices: {
                0: { color: 'red', offset: 0 },
                1: { color: 'orange', offset: 0 },
                2: { color: '#eeca06', offset: 0 },
                3: { color: 'green', offset: 0 },
              },
            };
    
            var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
            chart.draw(data, options);
        }
        
        function drawChartBarrasNuevo(ni_1, ni_2, ni_3, ni_4, nii_1, nii_2, nii_e, niii_1, niii_2, niii_3, n_sc, total) {
          var data = google.visualization.arrayToDataTable([
            ["Nivel", "Cantidad", { role: "style" } ],
            ["I-1", ni_1, "rgb(68, 115, 197)"],
            ["I-2", ni_2, "rgb(236, 126, 48)"],
            ["I-3", ni_3, "rgb(165, 165, 165)"],
            ["I-4", ni_4, " rgb(165, 165, 165)"],
            ["II-1", nii_1, "rgb(68, 115, 197)"],
            ["II-2", nii_2, "rgb(236, 126, 48)"],
            ["II-E", nii_e, "rgb(165, 165, 165)"],
            ["III-1", niii_1, "rgb(68, 115, 197)"],
            ["III-2", niii_2, "rgb(236, 126, 48)"],
            ["III-E", niii_e, "rgb(165, 165, 165)"],
            ["SC", n_sc, "rgb(68, 115, 197)"],
          ]);
    
          var view = new google.visualization.DataView(data);
          view.setColumns([0, 1, { calc: "stringify", sourceColumn: 1, type: "string", role: "annotation" }, 2]);
    
          var title = "TOTAL DE ESTABLECIMIENTOS" + total;
          var options = {
            title: title,
            bar: {groupWidth: "95%"},
            legend: { position: "none" },
          };
          var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
          chart.draw(view, options);
        }
        
        function drawChartBarras(ni_1, ni_2, ni_3, ni_4, nii_1, nii_2, nii_e, niii_1, niii_2, niii_e, n_sc, total) {
            var data = google.visualization.arrayToDataTable([
                ["Nivel", "Cantidad", { role: "style" } ],
                ["I-1", ni_1, "rgb(68, 115, 197)"],
                ["I-2", ni_2, "rgb(236, 126, 48)"],
                ["I-3", ni_3, "rgb(165, 165, 165)"],
                ["I-4", ni_4, " rgb(165, 165, 165)"],
                ["II-1", nii_1, "rgb(68, 115, 197)"],
                ["II-2", nii_2, "rgb(236, 126, 48)"],
                ["II-E", nii_e, "rgb(165, 165, 165)"],
                ["III-1", niii_1, "rgb(68, 115, 197)"],
                ["III-2", niii_2, "rgb(236, 126, 48)"],
                ["III-E", niii_e, "rgb(165, 165, 165)"],
                ["SC", n_sc, "rgb(68, 115, 197)"],
            ]);
        
            var view = new google.visualization.DataView(data);
            view.setColumns([0, 1, { calc: "stringify", sourceColumn: 1, type: "string", role: "annotation" }, 2]);
            var options = {
                legend: { display: 'none' },
                title: 'Total de Establecimientos: ' + total,
                bar: { groupWidth: "90%" },
                legend: { position: "none" },
            };
        
            var chart = new google.visualization.ColumnChart(document.getElementById("top_x_div"));
            chart.draw(view, options);
        }
          
        function onRegion(idregion) {
            try {
                $("#spinner-siga").css({ "display" : "flex" });
                
                debugger;
                var _regiones_eess = idregion == '0' ? regiones_eess : regiones_eess.filter((r) => r.idregion == idregion);
                var _regiones = idregion == '0' ? regiones : regiones.filter((r) => r.idregion == idregion);
                var nombre_region =  idregion == '0' ? "Todas las Regiones" : _regiones.flatMap((r) => r.nombre).join();
                $(".siga-establecimiento").html(nombre_region);
                var nombre_item = !!$("#nombre_item").val() && $("#nombre_item").val() != "-" ? $("#nombre_item").val() : "";
                $(".siga-nombre_item").html(nombre_item);
                       
                debugger;
                var nivel_i_1 = _regiones_eess.flatMap((r) => +(r.nivel_i_1)).reduce((prev, curr) => prev + curr, 0);
                var nivel_i_2 = _regiones_eess.flatMap((r) => +(r.nivel_i_2)).reduce((prev, curr) => prev + curr, 0);
                var nivel_i_3 = _regiones_eess.flatMap((r) => +(r.nivel_i_3)).reduce((prev, curr) => prev + curr, 0);
                var nivel_i_4 = _regiones_eess.flatMap((r) => +(r.nivel_i_4)).reduce((prev, curr) => prev + curr, 0);
                var nivel_ii_1 = _regiones_eess.flatMap((r) => +(r.nivel_ii_1)).reduce((prev, curr) => prev + curr, 0);
                var nivel_ii_2 = _regiones_eess.flatMap((r) => +(r.nivel_ii_2)).reduce((prev, curr) => prev + curr, 0);
                var nivel_ii_e = _regiones_eess.flatMap((r) => +(r.nivel_ii_e)).reduce((prev, curr) => prev + curr, 0);
                var nivel_iii_1 = _regiones_eess.flatMap((r) => +(r.nivel_iii_1)).reduce((prev, curr) => prev + curr, 0);
                var nivel_iii_2 = _regiones_eess.flatMap((r) => +(r.nivel_iii_2)).reduce((prev, curr) => prev + curr, 0);
                var nivel_iii_e = _regiones_eess.flatMap((r) => +(r.nivel_iii_e)).reduce((prev, curr) => prev + curr, 0);
                var nivel_sc = _regiones_eess.flatMap((r) => +(r.nivel_sc)).reduce((prev, curr) => prev + curr, 0);
                var total = nivel_i_1 + nivel_i_2 + nivel_i_3 + nivel_i_4 + nivel_ii_1 + nivel_ii_2 + nivel_ii_e + nivel_iii_1 + nivel_iii_2 + nivel_iii_e + nivel_sc;
                $(".siga-conteo-establecimientos").html(total);
                      
                google.charts.setOnLoadCallback(() => drawChartBarras(nivel_i_1, nivel_i_2, nivel_i_3, nivel_i_4, nivel_ii_1, nivel_ii_2, nivel_ii_e, nivel_iii_1, nivel_iii_2, nivel_iii_e, nivel_sc, total));
                   
                debugger;
                var codigo_ogei = !!$("#codigo_ogei").val() ? $("#codigo_ogei").val() : "0";
                var nombre_item = !!$("#nombre_item").val() ? $("#nombre_item").val() : "-";
                var codigo_margesi = !!$("#codigo_margesi").val() ? $("#codigo_margesi").val() : "-";
                
                if (codigo_ogei == "0" && nombre_item == "-" && codigo_margesi == "-") { 
                    debugger;
                    var desc_bueno = _regiones.flatMap((r) => +(r.bueno)).reduce((prev, curr) => prev + curr, 0);
                    var desc_regular = _regiones.flatMap((r) => +(r.regular)).reduce((prev, curr) => prev + curr, 0);
                    var desc_malo = _regiones.flatMap((r) => +(r.malo)).reduce((prev, curr) => prev + curr, 0);
                    var desc_muy_malo = _regiones.flatMap((r) => +(r.muy_malo)).reduce((prev, curr) => prev + curr, 0);
                    var desc_nuevo = _regiones.flatMap((r) => +(r.nuevo)).reduce((prev, curr) => prev + curr, 0);
                    var desc_total = desc_bueno + desc_regular + desc_malo + desc_muy_malo + desc_nuevo;
                    
                    if (desc_total == 0) {
                        $(".grafico-registros-vacio").show();
                        $(".grafico-registros").hide();
                    } else {
                        $(".grafico-registros-vacio").hide();
                        $(".grafico-registros").show();
                    } 
                    
                    var desc_total = desc_total <= 0 ? 1 : desc_total;
                    
                    google.charts.setOnLoadCallback(() => drawChartPie(desc_muy_malo, desc_malo, desc_regular, (desc_bueno + desc_nuevo)));
                    
                    debugger; 
                    $(".siga-desc-bueno").html((desc_bueno + desc_nuevo));
                    $(".siga-desc-bueno-porcentaje").html(Math.round((desc_bueno + desc_nuevo) / desc_total * 100));
                    $(".siga-desc-porc-bueno").html(((desc_bueno + desc_nuevo) / desc_total * 100).toFixed(2) + "%");
                    $(".siga-desc-porc-bueno").prop("aria-valuenow", Math.round((desc_bueno + desc_nuevo) / desc_total * 100));
                    $(".siga-desc-porc-bueno").css("width", Math.round(((desc_bueno + desc_nuevo) / desc_total * 100) + 25) + "%");
                        
                    $(".siga-desc-regular").html(desc_regular);
                    $(".siga-desc-regular-porcentaje").html(Math.round(desc_regular / desc_total * 100));
                    $(".siga-desc-porc-regular").html((desc_regular / desc_total * 100).toFixed(2) + "%");
                    $(".siga-desc-porc-regular").prop("aria-valuenow", Math.round(desc_regular / desc_total * 100));
                    $(".siga-desc-porc-regular").css("width", Math.round((desc_regular / desc_total * 100) + 25) + "%");
                              
                    $(".siga-desc-malo").html(desc_malo);
                    $(".siga-desc-malo-porcentaje").html(Math.round(desc_malo / desc_total * 100));
                    $(".siga-desc-porc-malo").html((desc_malo / desc_total * 100).toFixed(2) + "%");
                    $(".siga-desc-porc-malo").prop("aria-valuenow", Math.round(desc_malo / desc_total * 100));
                    $(".siga-desc-porc-malo").css("width", Math.round((desc_malo / desc_total * 100) + 25) + "%");
                              
                    $(".siga-desc-muy-malo").html(desc_muy_malo);
                    $(".siga-desc-muy-malo-porcentaje").html(Math.round(desc_muy_malo / desc_total * 100));
                    $(".siga-desc-porc-muy-malo").html((desc_muy_malo / desc_total * 100).toFixed(2) + "%");
                    $(".siga-desc-porc-muy-malo").prop("aria-valuenow", Math.round(desc_muy_malo / desc_total * 100));
                    $(".siga-desc-porc-muy-malo").css("width", Math.round((desc_muy_malo / desc_total * 100) + 25) + "%");
                              
                    debugger;
                    var activo = _regiones.flatMap((r) => +(r.activo)).reduce((prev, curr) => prev + curr, 0);
                    var baja = _regiones.flatMap((r) => +(r.baja)).reduce((prev, curr) => prev + curr, 0);
                    $("#siga-desc-estado-activo").html(activo);
                    $("#siga-desc-estado-baja").html(baja);
                } else {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('tabla-general-detalle-estado') }}",
                        data: {
                           _token : "{{ csrf_token() }}",
                           idregion: idregion,
                           codigo_ogei: codigo_ogei,
                           nombre_item: nombre_item,
                           codigo_margesi: codigo_margesi
                        },
                        success: function(result) {
                            debugger;
                            var __regiones = result.data;
                            var desc_bueno = __regiones.flatMap((r) => +(r.bueno)).reduce((prev, curr) => prev + curr, 0);
                            var desc_regular = __regiones.flatMap((r) => +(r.regular)).reduce((prev, curr) => prev + curr, 0);
                            var desc_malo = __regiones.flatMap((r) => +(r.malo)).reduce((prev, curr) => prev + curr, 0);
                            var desc_muy_malo = __regiones.flatMap((r) => +(r.muy_malo)).reduce((prev, curr) => prev + curr, 0);
                            var desc_nuevo = __regiones.flatMap((r) => +(r.nuevo)).reduce((prev, curr) => prev + curr, 0);
                            var desc_total = desc_bueno + desc_regular + desc_malo + desc_muy_malo + desc_nuevo;
                            if (desc_total == 0) {
                                $(".grafico-registros-vacio").show();
                                $(".grafico-registros").hide();
                            } else {
                                $(".grafico-registros-vacio").hide();
                                $(".grafico-registros").show();
                            } 
                            var desc_total = desc_total <= 0 ? 1 : desc_total;
                             
                            google.charts.setOnLoadCallback(() => drawChartPie(desc_muy_malo, desc_malo, desc_regular, (desc_bueno + desc_nuevo)));
                        
                            debugger; 
                            $(".siga-desc-bueno").html((desc_bueno + desc_nuevo));
                            $(".siga-desc-bueno-porcentaje").html(Math.round((desc_bueno + desc_nuevo) / desc_total * 100));
                            $(".siga-desc-porc-bueno").html(((desc_bueno + desc_nuevo) / desc_total * 100).toFixed(2) + "%");
                            $(".siga-desc-porc-bueno").prop("aria-valuenow", Math.round((desc_bueno + desc_nuevo) / desc_total * 100));
                            $(".siga-desc-porc-bueno").css("width", Math.round(((desc_bueno + desc_nuevo) / desc_total * 100) + 25) + "%");
                                
                            $(".siga-desc-regular").html(desc_regular);
                            $(".siga-desc-regular-porcentaje").html(Math.round(desc_regular / desc_total * 100));
                            $(".siga-desc-porc-regular").html((desc_regular / desc_total * 100).toFixed(2) + "%");
                            $(".siga-desc-porc-regular").prop("aria-valuenow", Math.round(desc_regular / desc_total * 100));
                            $(".siga-desc-porc-regular").css("width", Math.round((desc_regular / desc_total * 100) + 25) + "%");
                                      
                            $(".siga-desc-malo").html(desc_malo);
                            $(".siga-desc-malo-porcentaje").html(Math.round(desc_malo / desc_total * 100));
                            $(".siga-desc-porc-malo").html((desc_malo / desc_total * 100).toFixed(2) + "%");
                            $(".siga-desc-porc-malo").prop("aria-valuenow", Math.round(desc_malo / desc_total * 100));
                            $(".siga-desc-porc-malo").css("width", Math.round((desc_malo / desc_total * 100) + 25) + "%");
                                      
                            $(".siga-desc-muy-malo").html(desc_muy_malo);
                            $(".siga-desc-muy-malo-porcentaje").html(Math.round(desc_muy_malo / desc_total * 100));
                            $(".siga-desc-porc-muy-malo").html((desc_muy_malo / desc_total * 100).toFixed(2) + "%");
                            $(".siga-desc-porc-muy-malo").prop("aria-valuenow", Math.round(desc_muy_malo / desc_total * 100));
                            $(".siga-desc-porc-muy-malo").css("width", Math.round((desc_muy_malo / desc_total * 100) + 25) + "%");
                                      
                            debugger;
                            var activo = __regiones.flatMap((r) => +(r.activo)).reduce((prev, curr) => prev + curr, 0);
                            var baja = __regiones.flatMap((r) => +(r.baja)).reduce((prev, curr) => prev + curr, 0);
                            $("#siga-desc-estado-activo").html(activo);
                            $("#siga-desc-estado-baja").html(baja);
                        },
                    }); 
                }
                
                if ($("#board-rrhh").css("display") != "none") {
                    ListadoRecursos('grupoetareo', 'Grupo Etario', 1);
                }
                
                $("#spinner-siga").css({ "display" : "none" });
            } catch (error) {
                console.error(error);
                $("#spinner-siga").css({ "display" : "none" });
            }
        }
      
        function onRegionFilter(idregion) {
            $("#codigo_margesi").val("");
            $("#nombre_item").val("");
            $("#nombre_item").html("");
            $("#idregion option[value='" + idregion + "']").prop("selected", true);
            $("#nombre_item").html("");
            $("#nombre_item").val("");
            onRegion(idregion);
        }
        
        function SearchFormat() {
            debugger;
            $.ajax({
                type: "GET",
url : "/admin/establecimiento-search/" + $("#codigo_ogei").val(),
                success : function(r) {
                    debugger;
                    $("#nombre_eess").val("");
                    $("#idregion option[value='0']").prop("selected", true);
                    $('#idregion').removeAttr('disabled');
                    $("#provincia").val("");
                    $('#codigo_margesi').empty();
                    $('#nombre_item').empty();
                    if (r != null) {
                        $("#nombre_eess").val(r.nombre_eess);
                        $("#idregion option[value='" + r.idregion + "']").prop("selected", true);
                        $('#idregion').attr('disabled', true);
                        $("#provincia").val(r.provincia);
                    }
                },
            });
        }
        
        function ListadoEquipos(page = "1") {
            debugger;
            var idregion = $("#idregion").val();
            var codigo_ogei = !!$("#codigo_ogei").val()?$("#codigo_ogei").val():"0";
            var nombre_item = !!$("#nombre_item").val()?$("#nombre_item").val():"-";
            var codigo_margesi = !!$("#codigo_margesi").val()?$("#codigo_margesi").val():"-";
            $.ajax({
               type: "POST",
               url: "{{ route('tabla-general-detalle-pagination') }}",
               data: {
                  _token : "{{ csrf_token() }}",
                  idregion: idregion,
                  codigo_ogei: codigo_ogei,
                  nombre_item: nombre_item,
                  codigo_margesi: codigo_margesi,
                  page : page
               },
               beforeSend: function() {
                  $("#spinner-siga").css({ "display" : "flex" });
               },
               error: function(xhr) {
                  $("#spinner-siga").css({ "display" : "none" });
               },
               complete: function() {
                  $("#spinner-siga").css({ "display" : "none" });
               }, 
               success: function(result) {
                  debugger;
                  var datos = result.data;
                  $("#table-content-equipos").html("");
                  $.each(datos.data, function(index, item) {
                     debugger;
                     var bueno = +(item.bueno), nuevo = +(item.nuevo), regular = +(item.regular), malo = +(item.malo), muy_malo = +(item.muy_malo);
                     var total = regular + malo + muy_malo;
                     var total_general = bueno + nuevo + total;
                     $("#table-content-equipos").append('<tr>' +
                        //   '<td class="text-truncate">' + (item.nombre_eess != null ? item.nombre_eess : "") + '</td>' +
                           '<td class="text-truncate">' + item.nombre_item + '</td>' +
                           '<td class="text-center">' + (bueno + nuevo) + '</td>' +
                            '<td class="text-center">' + item.regular + '</td>' + 
                            '<td class="text-center">' + item.malo + '</td>' + 
                            '<td class="text-center">' + item.muy_malo + '</td>' + 
                            '<td class="text-center fw-bold">' + total + '</td>' + 
                            '<td class="text-center fw-bold">' + total_general + '</td>' + 
                        '</tr>');
                    });
                    $("#from").html(datos.from);
                    $("#to").html(datos.to);
                    $("#total").html(datos.total);
                    
                    $("#pagination_number").html("");
                    debugger;
                    $.each(datos.links, function (index, item) {
                        debugger;
                        if (item.active) {
                            if (isNaN(item.label) && item.label != "...") {
                                $("#pagination_number").append('<span class="sm:hidden relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5">' + item.label + '</span>');
                            } else {
                                $("#pagination_number").append('<span class="hidden sm:flex relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5">' + item.label + '</span>');
                            }
                        } else {
                            var page_number = item.url != null ? item.url.replace(/[^0-9]/g, '') : "";
                            if (isNaN(item.label) && item.label != "...") {
                                $("#pagination_number").append('<button onclick="ListadoEquipos(' + "'" + page_number + "'" + ')" type="button" class="sm:hidden relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">' + item.label + '</button>');
                            } else {
                                $("#pagination_number").append('<button onclick="ListadoEquipos(' + "'" + page_number + "'" + ')" type="button" class="hidden sm:flex relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">' + item.label + '</button>');
                            }
                        }
                    });
                    
                    if (!$('#staticBackdrop').is(':visible')) {
                        $("#staticBackdrop").modal("show");
                    }
                },
            });
        }
        
        function ListadoRecursos(nombre, titulo, tipo) {
            debugger;
            var idregion = $("#idregion").val();
            var codigo_ogei = !!$("#codigo_ogei").val()?$("#codigo_ogei").val():"0";
            $("#input-tipo-rrhh").val(nombre);
            if (nombre != "grupoetareo") {
                $("#board-rrhh").css({"display":"none"});
            }
var url = "/admin/tabla-general-personal-tipo/" + nombre + "/" + idregion + "/" + codigo_ogei;
            $.ajax({
                type: "GET",
                url: url,
                success: function(result) {
                    debugger;
                    console.log(result);
                    if (tipo == 2) {
                        $("#table-content-recursos-humanos").html("");
                        $.each(result, function(index, item) {
                            debugger;
                            $("#table-content-recursos-humanos").append('<tr>' +
                                '<td class="text-truncate">' + item.nombre + '</td>' +
                                '<td class="text-center">' + item.cantidad + '</td>' +
                            '</tr>');
                        });
                        $("#total-rrhh").html(result.length);
                        $("#tipo-rrhh").html(titulo);
                        $("#staticBackdropI").modal("show");
                    } else {
                        $("#barra-recursos-humanos").html("");
                        var total = result.flatMap((r) => +(r.cantidad)).reduce((prev, curr) => prev + curr, 0);
                        $.each(result, function(index, item) {
                            debugger; 
                            var porcentaje = Math.round(+(item.cantidad) / total * 100); 
                            porcentaje = porcentaje < 3 ? 3 : porcentaje;
                            $("#barra-recursos-humanos").append('<div class="barra">' +
                                '<div class="sub_barra" style="background-color: #4473C5;height: ' + porcentaje + "%" + ';">' +
                                '<div class="tag_g">' + item.cantidad + '</div>' +
                                '<div class="tag_leyenda" style="white-space: nowrap;">' + item.nombre + '</div>' +
                                '</div>' +
                            '</div>');
                        });
                        $("#titulo-recursos-humanos").html(titulo);
                        $("#board-rrhh").css({"display":""});
                    }
                },
            });
        }
        
        function Filtrar() {
            onRegion($("#idregion").val()??0);
        }
      
        function handleHover(evt, item, legend) {
            legend.chart.data.datasets[0].backgroundColor.forEach((color, index, colors) => {
                colors[index] = index === item.index || color.length === 9 ? color : color + '4D';
            });
            legend.chart.update();
        }
        
        function handleLeave(evt, item, legend) {
            legend.chart.data.datasets[0].backgroundColor.forEach((color, index, colors) => {
                colors[index] = color.length === 9 ? color.slice(0, -2) : color;
            });
            legend.chart.update();
        }
    
        function addData(label, data) {
            debugger;
            if (data > 0) {
                myChart.data.labels.push(label);
                myChart.data.datasets.forEach((dataset) => {
                    switch(label) {
                        case "Bueno":
                            dataset.backgroundColor.push('#198750');
                            break;
                        case "Regular":
                            dataset.backgroundColor.push('#ffd100');
                            break;
                        case "Malo":
                            dataset.backgroundColor.push('#ecaa00');
                            break;
                        case "Muy Malo":
                            dataset.backgroundColor.push('#dc3545');
                            break;
                        default:
                            dataset.backgroundColor.push('#ffd100');
                            break;
                    }
                    dataset.data.push(data);
                });
                myChart.update();
            }
        }
        
        function removeData() {
            debugger;
            for(var i = 1; i <= 4; i++) {
                myChart.data.labels.pop();
                myChart.data.datasets.forEach((dataset) => {
                    dataset.backgroundColor.pop();
                    dataset.data.pop();
                });
                myChart.update();
            }
        }
        
        function updateConfigByMutating() {
            debugger;
            var nombre_item = $("#nombre_item").val();
            if (nombre_item != "-") {
                myChart.options.plugins.title.text = 'Estado de Conservacion de Equipos: ' + nombre_item;
                myChart.update();
            }
        }
        
        function ExportarReporte() {
            var idregion = $("#idregion").val();
            var codigo_ogei = !!$("#codigo_ogei").val()?$("#codigo_ogei").val():"0";
            var nombre_item = !!$("#nombre_item").val()?$("#nombre_item").val():"-";
            var codigo_margesi = !!$("#codigo_margesi").val()?$("#codigo_margesi").val():"-";
            $.ajax({
                type: "POST",
                url: "{{ route('encode-tablero-gerencial') }}",
                data: {
                    _token : "{{ csrf_token() }}",
                    idregion: idregion,
                    codigo_ogei: codigo_ogei,
                    nombre_item: nombre_item,
                    codigo_margesi: codigo_margesi,
                },
                success: function(result) {
                    debugger;            
var url = "/admin/tabla-general-detalle-export/" + result.where;
                    var cantidad = $("#total").html() ?? "0";
                    if (cantidad > result.maximo) {
                        Swal.fire({
                            title: "IMPORTANTE",
                            html: "Debido a la cantidad de Registros para generar el reporte se tendra que coordinar con el &Aacute;rea de Sistemas.",
                            icon: "warning",
                        });
                        return false;
                    } else {
                        window.location.href = url;
                    }
                },
            }); 
        }
        
        function ExportarReporteRecursosHumanos() {
            debugger;
            var idregion = !!$("#idregion").val() ? $("#idregion").val() : "0";
            var codigo_ogei = !!$("#codigo_ogei").val() ? $("#codigo_ogei").val() : "0";
            var nombre = !!$("#input-tipo-rrhh").val() ? $("#input-tipo-rrhh").val() : "";
            $.ajax({
                type: "POST",
                url: "{{ route('encode-recursos-humanos') }}",
                data: {
                    _token : "{{ csrf_token() }}",
                    idregion: idregion,
                    codigo_ogei: codigo_ogei,
                    nombre: nombre,
                },
                success: function(result) {
                    debugger;            
            var url = "/admin/tabla-general-personal-tipo-export/" + nombre + "/" + result.where;  // ← CAMBIADO
                    if (result.cantidad > result.maximo) {
                        Swal.fire({
                            title: "IMPORTANTE",
                            html: "Debido a la cantidad de Registros para generar el reporte se tendra que coordinar con el &Aacute;rea de Sistemas.",
                            icon: "warning",
                        });
                        return false;
                    } else {
                        window.location.href = url;
                    }
                },
            });
        }
    </script>
</x-app-layout>