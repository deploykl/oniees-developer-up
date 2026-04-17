<x-app-layout>
    <x-slot name="title">Usuarios</x-slot>
    <x-slot name="url">{{ route('users-index') }}</x-slot>
    <x-slot name="subtitle">Crear</x-slot>
    @section('plugins.Select2', true)
    @section('head')
    <style>
        #pswd_info {
            display: none;
            width: 100%;
            margin: 10px auto;
            padding: 15px;
            background: #FEFEFE;
            font-size: .875em;
            border-radius: 5px;
            box-shadow: 0 1px 3px #CCCCCC;
            border: 1px solid #DDDDDD;
        }
        #pswd_info h4 {
            margin: 0 0 10px 0;
            padding: 0;
            font-weight: normal;
        }
        .invalid {
            padding-left: 22px;
            color: #EC3F41;
        }
        .invalid > i {
            padding-right: 4px;
        }
        .valid {
            padding-left: 22px;
            line-height: 24px;
            color: #3A7D34;
        }
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
            margin: 0;
        }
        input[type=number] { 
            -moz-appearance:textfield; 
        }
    </style>
    <script>
        var style = document.createElement('style');
        style.setAttribute("id","multiselect_dropdown_styles");
        style.innerHTML = `
            .multiselect-dropdown{
              display: inline-block;
              padding: 7.5px;
              border-radius: 4px;
              border: solid 1px #ced4da;
              background-color: white;
              position: relative;
              background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
              background-repeat: no-repeat;
              background-position: right .75rem center;
              background-size: 16px 12px;
              font-size: 12px;
              font-weight: 400;
              line-height: 1.5;
              color: #212529;
              background-color: #fff;
              background-clip: padding-box;
              border: 1px solid #ced4da;
              -webkit-appearance: none;
              -moz-appearance: none;
              appearance: none;
              border-radius: 0.25rem;
              transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
            }
            .multiselect-dropdown span.optext, .multiselect-dropdown span.placeholder{
              margin-right:0.5em; 
              margin-bottom:2px;
              padding:1px 0; 
              border-radius: 4px; 
              display:inline-block;
              background: white;
            }
            .multiselect-dropdown span.optext{
              background-color:white;
              padding:1px 0.75em; 
            }
            .multiselect-dropdown span.optext .optdel {
              float: right;
              margin: 0 -6px 1px 5px;
              font-size: 0.7em;
              margin-top: 2px;
              cursor: pointer;
              color: #666;
            }
            .multiselect-dropdown span.optext .optdel:hover { color: #c66;}
            .multiselect-dropdown span.placeholder{
              color:#000000;
              padding-left: 10px;
            }
            .multiselect-dropdown-list-wrapper{
              box-shadow: gray 0 3px 8px;
              z-index: 100;
              padding:2px;
              border-radius: 4px;
              border: solid 1px #ced4da;
              display: none;
              margin: -1px;
              position: absolute;
              top:0;
              left: 0;
              right: 0;
              background: white;
            }
            .multiselect-dropdown-list-wrapper .multiselect-dropdown-search{
              margin-bottom:5px;
            }
            .multiselect-dropdown-list{
              padding:2px;
              height: 15rem;
              overflow-y:auto;
              overflow-x: hidden;
            }
            .multiselect-dropdown-list::-webkit-scrollbar {
              width: 6px;
            }
            .multiselect-dropdown-list::-webkit-scrollbar-thumb {
              background-color: #bec4ca;
              border-radius:3px;
            }
            
            .multiselect-dropdown-list div{
              padding: 5px;
            }
            .multiselect-dropdown-list input{
              height: 1.15em;
              width: 1.15em;
              margin-right: 0.35em;  
            }
            .multiselect-dropdown-list div.checked{
            }
            .multiselect-dropdown-list div:hover{
              background-color: #ced4da;
            }
            .multiselect-dropdown span.maxselected {width:100%;}
            .multiselect-dropdown-all-selector {border-bottom:solid 1px #999;}`;
        document.head.appendChild(style);
            
        function MultiselectDropdown(options){
            var config = {
                search:true,
                height:'15rem',
                placeholder:' Seleccionar',
                txtSelected:' seleccionados',
                txtAll:'Todos',
                txtRemove: 'Quitar',
                txtSearch:'Buscar',
                ...options
            };
            
            function newEl(tag,attrs) {
                var e=document.createElement(tag);
                if(attrs!==undefined) {
                    Object.keys(attrs).forEach(k => {
                        if (k==='class') { 
                            Array.isArray(attrs[k]) ? attrs[k].forEach(o=>o!==''?e.classList.add(o):0) : (attrs[k]!==''?e.classList.add(attrs[k]):0)
                        } else if (k==='style') {  
                            Object.keys(attrs[k]).forEach(ks => {
                                e.style[ks]=attrs[k][ks];
                            });
                       } else if (k==='text') {
                           attrs[k]===''?e.innerHTML='&nbsp;':e.innerText=attrs[k]
                       } else {
                           e[k]=attrs[k];
                       }
                    });
                }
                return e;
            }
            
              
            document.querySelectorAll("select[multiple]").forEach((el,k) => {
                // var div=newEl('div',{class:'multiselect-dropdown',style:{width:config.style?.width??el.clientWidth+'px',padding:config.style?.padding??''}});
                var div=newEl('div',{class:'multiselect-dropdown',style:{width:'100%',padding:config.style?.padding??''}});
                el.style.display='none';
                el.parentNode.insertBefore(div,el.nextSibling);
                var listWrap=newEl('div',{class:'multiselect-dropdown-list-wrapper'});
                var list=newEl('div',{class:'multiselect-dropdown-list',style:{height:config.height}});
                var search=newEl('input',{class:['multiselect-dropdown-search'].concat([config.searchInput?.class??'form-control']),style:{width:'100%',display:el.attributes['multiselect-search']?.value==='true'?'block':'none'},placeholder:config.txtSearch});
                listWrap.appendChild(search);
                div.appendChild(listWrap);
                listWrap.appendChild(list);
            
                el.loadOptions=()=>{
                  list.innerHTML='';
                  
                  if(el.attributes['multiselect-select-all']?.value=='true'){
                    var op=newEl('div',{class:'multiselect-dropdown-all-selector'})
                    var ic=newEl('input',{type:'checkbox'});
                    op.appendChild(ic);
                    op.appendChild(newEl('label',{text:config.txtAll}));
              
                    op.addEventListener('click',()=>{
                      op.classList.toggle('checked');
                      op.querySelector("input").checked=!op.querySelector("input").checked;
                      
                      var ch=op.querySelector("input").checked;
                      list.querySelectorAll(":scope > div:not(.multiselect-dropdown-all-selector)")
                        .forEach(i=>{if(i.style.display!=='none'){i.querySelector("input").checked=ch; i.optEl.selected=ch}});
              
                      el.dispatchEvent(new Event('change'));
                    });
                    ic.addEventListener('click',(ev)=>{
                      ic.checked=!ic.checked;
                    });
              
                    list.appendChild(op);
                  }
            
                  Array.from(el.options).map(o=>{
                    var op=newEl('div',{class:o.selected?'checked':'',optEl:o})
                    var ic=newEl('input',{type:'checkbox',checked:o.selected});
                    op.appendChild(ic);
                    op.appendChild(newEl('label',{text:o.text}));
            
                    op.addEventListener('click',()=>{
                      op.classList.toggle('checked');
                      op.querySelector("input").checked=!op.querySelector("input").checked;
                      op.optEl.selected=!!!op.optEl.selected;
                      el.dispatchEvent(new Event('change'));
                    });
                    ic.addEventListener('click',(ev)=>{
                      ic.checked=!ic.checked;
                    });
                    o.listitemEl=op;
                    list.appendChild(op);
                  });
                  div.listEl=listWrap;
            
                  div.refresh=()=>{
                    div.querySelectorAll('span.optext, span.placeholder').forEach(t=>div.removeChild(t));
                    var sels=Array.from(el.selectedOptions);
                    if(sels.length>(el.attributes['multiselect-max-items']?.value??5)){
                        //div.appendChild(newEl('span',{class:['optext','maxselected'],text:"Todos"}));          
                        div.appendChild(newEl('span',{class:['optext','maxselected'],text:sels.length+' '+config.txtSelected}));          
                    }
                    else{
                      sels.map(x=>{
                        var c=newEl('span',{class:'optext',text:x.text, srcOption: x});
                        if((el.attributes['multiselect-hide-x']?.value !== 'true'))
                          c.appendChild(newEl('span',{class:'optdel',text:'x',title:config.txtRemove, onclick:(ev)=>{c.srcOption.listitemEl.dispatchEvent(new Event('click'));div.refresh();ev.stopPropagation();}}));
            
                        div.appendChild(c);
                      });
                    }
                    if(0==el.selectedOptions.length) div.appendChild(newEl('span',{class:'placeholder',text:el.attributes['placeholder']?.value??config.placeholder}));
                  };
                  div.refresh();
                }
                el.loadOptions();
                
                search.addEventListener('input',()=>{
                  list.querySelectorAll(":scope div:not(.multiselect-dropdown-all-selector)").forEach(d=>{
                    var txt=d.querySelector("label").innerText.toUpperCase();
                    d.style.display=txt.includes(search.value.toUpperCase())?'block':'none';
                  });
                });
            
                div.addEventListener('click',()=>{
                  div.listEl.style.display='block';
                  search.focus();
                  search.select();
                });
                
                document.addEventListener('click', function(event) {
                  if (!div.contains(event.target)) {
                    listWrap.style.display='none';
                    div.refresh();
                  }
                });    
              });
        }
            
        window.addEventListener('load',()=>{
            MultiselectDropdown(window.MultiselectDropdownOptions);
        });
    </script>
    @endsection
    <div class="container">
        <div class="card  mt-3">
            <div class="card-body">
                <form id="FormUserCreate" action="{{ route('users-save') }}" method="post" class="needs-validation" novalidate>
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{ $user->id }}" />
                    <h3 class="text-center">Registro de Usuario</h3>
                    <input type="hidden" name="ministerio" id="ministerio" value="{{ $user->ministerio }}" />
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="idtiporol" class="form-label">Tipo Rol  <span class="text-danger">(*)</span></label>
                            <select class="form-control" id="idtiporol" name="idtiporol" onchange="RequiredDiris()" required>
                                <option value="" selected>Seleccione</option>
                                @if (Auth::user()->idtiporol == 1)
                                    <option value="1">Minsa-Dgos-Diem</option>
                                @endif
                                <option value="2">Diresa/Geresa/Diris</option>
                            </select>
                            <div class="invalid-feedback">Seleccione el Tipo de Usuario</div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="idtipousuario" class="form-label">Tipo Usuario  <span class="text-danger">(*)</span></label>
                            <select class="form-control" id="idtipousuario" name="idtipousuario" required>
                                <option value="">Seleccione</option>
                                @foreach($tipos as $tipo)
                                    <option value="{{ $tipo->id }}" <?php echo ($tipo->id == $user->idtipousuario ? "selected" : "") ?>>{{ $tipo->nombre }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Seleccione el Tipo de Usuario</div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="state_id" class="form-label">Estado  <span class="text-danger">(*)</span></label>
                            <select class="form-control" id="state_id" name="state_id" required>
                                <option value="2">Activo</option>
                                <option value="3">Inactivo</option>
                            </select>
                            <div class="invalid-feedback">Seleccione el Tipo de Usuario</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="name" class="form-label">Tipo Documento  <span class="text-danger">(*)</span></label>
                            <select class="form-control" name="id_tipo_documento" id="id_tipo_documento" onchange="TipoDocumentoIdentidad()" required>
                                <option value="">Seleccione</option>
                                @foreach($tipodocumentos as $tipodocumento)
                                    <option value="{{ $tipodocumento->id }}" <?php echo ($tipodocumento->id == $user->id_tipo_documento ? "selected" : "") ?>>{{ $tipodocumento->nombre }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Seleccione el Tipo de Documento</div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="lastname" class="form-label">Documento de Identidad  <span class="text-danger">(*)</span></label>
                            <input type="text" class="form-control" id="documento_identidad" onkeyup="BuscarPersona()" name="documento_identidad" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)" minlength="8" maxlength="8" value="{{ $user->documento_identidad }}" placeholder="Digite el documento" onchange="BuscarPersona()" required/>
                            <div class="invalid-feedback doc_entidad">El doc. de identidad debe contener 8 caracteres</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Nombre  <span class="text-danger">(*)</span></label>
                            <input type="text" class="form-control" id="name" name="name" maxlength="200" value="{{ $user->name }}" placeholder="Digite el Nombre" required/>
                            <div class="invalid-feedback">Digite la Nombre</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="lastname" class="form-label">Apellidos  <span class="text-danger">(*)</span></label>
                            <input type="text" class="form-control" id="lastname" name="lastname" maxlength="200" value="{{ $user->lastname }}" placeholder="Digite los Apellidos" required/>
                            <div class="invalid-feedback">Digite los Apellidos</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Correo Electronico  <span class="text-danger">(*)</span></label>
                            <input type="email" class="form-control" id="email" name="email" maxlength="200" value="{{ $user->email }}" placeholder="Digite el Correo" required/>
                            <div class="invalid-feedback">Digite un correo correcto</div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="phone" class="form-label">Celular  <span class="text-danger">(*)</span></label>
                            <input type="number" max="999999999" maxlength="9" class="form-control" id="phone" name="phone" value="{{ $user->phone }}" placeholder="Celular"
                                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)" required/>
                            <div class="invalid-feedback">El celular debe empezar con 9 y tener 9 digitos</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="cargo" class="form-label">Cargo  <span class="text-danger">(*)</span></label>
                            <input type="text" class="form-control" id="cargo" name="cargo" maxlength="200" value="{{ $user->cargo }}" placeholder="Digite el Cargo" required>
                            <div class="invalid-feedback">Digite el Cargo</div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="iddiresa" class="form-label">DIRIS <span class="text-diresa text-danger" style="display:none">(*)</span></label>
                            <select id="iddiresa" name="iddiresa[]" multiple multiselect-max-items="1" class="form-select" onchange="LimpiarDiris()">
                                @if (Auth::user()->tipo_rol == 2)
                                    <option value="{{ Auth::user()->iddiresa }}" selected>{{ Auth::user()->nombre_region }}</option>
                                @else
                                    @foreach($diresas as $diresa)
                                        <option value="{{ $diresa->id }}" <?php echo ($diresa->id == $user->iddiresa ? "selected" : ""); ?>>{{ $diresa->nombre }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <div class="invalid-feedback">Seleccione la Diresa</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="red" class="form-label">Red</label>
                            @if (Auth::user()->tipo_rol == 1 || Auth::user()->red == null || strlen(Auth::user()->red) == 0)
                                <div class="input-group">
                                    <div style="width:calc(100% - 32px)">
                                        <select class="form-control js-example-basic-single" id="red" name="red" placeholder="Seleccione la Red">
                                            <option value="">Seleccione</option>
                                        </select>
                                    </div>
                                    <div class="input-group-prepend">
                                        <button class="input-group-text" type="button" onclick="LimpiarRed()">x</button>
                                    </div>
                                </div>
                            @else
                                <select class="form-control" id="red" name="red" placeholder="Seleccione la Red">
                                    <option value="{{ Auth::user()->red }}" selected>{{ Auth::user()->red }}</option>
                                </select>
                            @endif
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="microred" class="form-label">MicroRed</label>
                            @if (Auth::user()->tipo_rol == 1 || Auth::user()->microred == null || strlen(Auth::user()->microred) == 0)
                            <div class="input-group">
                                <div style="width:calc(100% - 32px)">
                                    <select class="js-example-basic-single" id="microred" name="microred" placeholder="Seleccione la Micored">
                                        <option value="">Seleccione</option>
                                    </select>
                                </div>
                                <div class="input-group-prepend">
                                    <button class="input-group-text" type="button" onclick="LimpiarMicrored()">x</button>
                                </div>
                            </div>
                            @else
                                <select class="form-control" id="microred" name="microred" placeholder="Seleccione la Micored">
                                    <option value="{{ Auth::user()->microred }}" selected>{{ Auth::user()->microred }}</option>
                                </select>
                            @endif
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="idestablecimiento" class="form-label">Establecimiento</label>
                            <div class="input-group">
                                <div style="width:calc(100% - 32px)">
                                    <select class="js-example-basic-single" id="idestablecimiento" name="idestablecimiento" placeholder="Seleccione un Establecimiento">
                                        <option value="">Seleccione</option>
                                    </select>
                                </div>
                                <div class="input-group-prepend">
                                    <button class="input-group-text" type="button" onclick="LimpiarEstablecimiento()">x</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">Contrase&ntilde;a <span class="text-danger">(*)</span></label>
                            <div class="input-group mb-3">
                              <input type="password" class="form-control" placeholder="Contrase&ntilde;a" id="password" name="password" maxlength="200" required aria-label="password" aria-describedby="password-addon" onkeyup="PasswordValidate()" />
                              <button class="input-group-text" id="password-addon" type="button" onclick="CambiarTipo('password')">
                                  <i class="fa fa-solid fa-eye-slash"></i>
                              </button>
                            </div>
                            <div class="invalid-feedback">Digite la Contrase&ntilde;a</div>
                        </div>
                        <div class="col-md-12 d-flex justify-content-around">
                            <button type="submit" class="btn btn-guardar btn-primary">
                                <i class="fas fa-save"></i> Guardar
                            </button>
                            <a href="{{ route('users-index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Regresar
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 d-flex justify-content-around">
                            <div id="pswd_info">
                                <h6>La contrase&ntilde;a debe de cumplir con los siguientes requerimientos:</h6>
                                <ul style="list-style-type: none;padding:0px">
                                    <li id="letter" class="invalid">
                                        <i class="fas fa-times"></i> Al menos <strong>una letra</strong>
                                    </li>
                                    <li id="capital" class="invalid">
                                        <i class="fas fa-times"></i> Al menos <strong>una letra en may&uacute;scula</strong>
                                    </li>
                                    <li id="number" class="invalid">
                                        <i class="fas fa-times"></i> Al menos <strong>un n&uacute;mero</strong>
                                    </li>
                                    <li id="length" class="invalid">
                                        <i class="fas fa-times"></i> Tener al menos <strong>8 caracteres</strong>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @section('scripts')
    <style>
        .select2-selection.select2-selection--single{
            height: 38px;
            line-height: 38px!important;
            padding: 7px;
            border-color: #ced4da;
            border-radius: 4px;
            border-width: 1px;
            border-style: solid;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow{
            top: 0px;
            bottom: 0px;
            margin: auto;
        }
    </style>
    <script>
        function RequiredDiris() {
            const tipoRol = document.getElementById("idtiporol").value;
            const tipoUsuario = document.getElementById("idtipousuario");
            const labelTipoUsuario = document.querySelector("label[for='idtipousuario']");
    
            if (tipoRol == 1) {
                // Hacer que no sea obligatorio
                tipoUsuario.removeAttribute("required");
                tipoUsuario.classList.remove("is-invalid"); // Remueve el estado inválido si existe
                labelTipoUsuario.innerHTML = 'Tipo Usuario'; // Actualiza el texto del label
                $(".text-diresa").hide();
                $("#iddiresa").removeAttr('required');
            } else {
                // Hacerlo obligatorio
                tipoUsuario.setAttribute("required", "required");
                labelTipoUsuario.innerHTML = 'Tipo Usuario <span class="text-danger">(*)</span>'; // Actualiza el texto del label
                $(".text-diresa").show();
                $("#iddiresa").prop("required", true);
            }
        }
    
        function CambiarTipo(input) {
            debugger;
            var tipo = $("#" + input).prop("type");
            $("#" + input).prop("type", (tipo == "text" ? "password" : "text"));
            if (tipo == "password") {
                $("#" + input + "-addon > i").removeClass("fa-eye-slash");
                $("#" + input + "-addon > i").addClass("fa-eye");
            } else {
                $("#" + input + "-addon > i").removeClass("fa-eye");
                $("#" + input + "-addon > i").addClass("fa-eye-slash");
            }
        }
        
        $(function () {
            var forms = document.querySelectorAll('#FormUserCreate.needs-validation');
            Array.prototype.slice.call(forms).forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    event.preventDefault();
                    event.stopPropagation();
                    if (form.checkValidity()) {
                        var formData = new FormData(document.getElementById("FormUserCreate"));
                        formData.append("red", $("#red").val());
                        formData.append("microred", $("#microred").val());
                        var resultPassword = PasswordValidate();
                        if (resultPassword) {
                            $.ajax({
                                type: "POST",
                                url : "{{ route('users-save') }}",
                                data : $(this).serialize(),
                                beforeSend: function() {
                                    $(".btn-guardar").prop("disabled", true);
                                    $(".btn-guardar").html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>Loading...')
                                },
                                failure: function(jqXHR, textStatus, errorThrown){
                                    console.log(jqXHR);
                                    console.log(textStatus);
                                    console.log(errorThrown);
                                },
                                success : function(result) {
                                    debugger;
                                    Swal.fire({
                                        title: "IMPORTANTE",
                                        text: result.mensaje,
                                        icon: result.status == "OK" ? "success" : "warning",
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "#3085d6",
                                    });
                                    $(".btn-guardar").html('<i class="fas fa-save"></i> Guardar Cambios');
                                    $(".btn-guardar").prop("disabled", false);
                                    if (result.status == "OK") {
                                        window.location.href = "{{ route('users-edit') }}/" + result.id;
                                    }
                                },
                            });
                        } else {
                            Swal.fire({
                                title: "IMPORTANTE",
                                text: "La contrase\u00f1a debe de cumplir los requerimientos",
                                icon: "warning",
                                confirmButtonText: "OK",
                                confirmButtonColor: "#3085d6",  
                            });
                        }
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        });
        
        function PasswordValidate() {
            debugger;
            var result = true;
            // keyup code here
            var pswd = $("#password").val();
                
            $("#pswd_info").show();


            if ( pswd.length < 8 ) {
                $('#length').removeClass('valid').addClass('invalid');
                $('#length > i.fas').removeClass('fa-check').addClass('fa-times');
                result = false;
            } else {
                $('#length').removeClass('invalid').addClass('valid');
                $('#length > i.fas').removeClass('fa-times').addClass('fa-check');
            }
            
            //validate letter
            if (!!pswd.match(/[A-z]/) ) {
                $('#letter').removeClass('invalid').addClass('valid');
                $('#letter > i.fas').removeClass('fa-times').addClass('fa-check');
            } else {
                $('#letter').removeClass('valid').addClass('invalid');
                $('#letter > i.fas').removeClass('fa-check').addClass('fa-times');
                result = false;
            }
                
            //validate capital letter
            if (!!pswd.match(/[A-Z]/) ) {
                $('#capital').removeClass('invalid').addClass('valid');
                $('#capital > i.fas').removeClass('fa-times').addClass('fa-check');
            } else {
                $('#capital').removeClass('valid').addClass('invalid');
                $('#capital > i.fas').removeClass('fa-check').addClass('fa-times');
                result = false;
            }
                
            //validate number
            if (!!pswd.match(/\d/) ) {
                $('#number').removeClass('invalid').addClass('valid');
                $('#number > i.fas').removeClass('fa-times').addClass('fa-check');
            } else {
                $('#number').removeClass('valid').addClass('invalid');
                $('#number > i.fas').removeClass('fa-check').addClass('fa-times');
                result = false;
            }
            
            if (result) {
                $("#pswd_info").hide();
            }
            return result;
        }
        
        function TipoDocumentoIdentidad() {
            debugger;
            var tipodocumentos = JSON.parse('<?php echo (json_encode($tipodocumentos)) ?>');
            var tipodocumento = tipodocumentos.find(t=>t.id==$("#id_tipo_documento").val());
            var maxlength = !!tipodocumento ? tipodocumento.longitud : 15;
            var minlength = !!tipodocumento && tipodocumento.exacto == "1" ? tipodocumento.longitud : 1;
            $("#documento_identidad").prop('maxlength', maxlength);  
            $("#documento_identidad").prop('minlength', minlength);
            var mensaje = maxlength == minlength ? "El doc. de identidad debe contener " + maxlength + " caracteres" : 
                "El doc. de identidad debe contar desde " + minlength + " o hasta " + maxlength + " caracteres";
            $(".invalid-feedback.documento_identidad").html(mensaje);
            
            var input = $("#documento_identidad");
            input.val(input.val().length > maxlength ? input.val().slice(0, maxlength) : input.val());
            
            if ($("#id_tipo_documento").val() != "1") {
                $("#name").prop("readonly", false);
                $("#lastname").prop("readonly", false);
                $("#name").val("");
                $("#lastname").val("");
            } else {
                $("#name").prop("readonly", true);
                $("#lastname").prop("readonly", true);
            }
            BuscarPersona();
        }
        
        function BuscarPersona() {
            debugger;
            var id_tipo_documento = $("[name=id_tipo_documento]");
            var documento_identidad = $("[name=documento_identidad]");
            if (documento_identidad.val().length == 8 && id_tipo_documento.val() == "1") {
                BuscarDocumento(documento_identidad, $("#name"), $("#lastname"));
            }
        }
        
        function BuscarDocumento(nroDocumento, nombre_registrador, apellidos_registrador) {
            try {
                try {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('search-dni') }}/" + nroDocumento.val(),
                        success: function(result) {
                            debugger;
                            if (result.status == "OK" && result.data != null) {
                                var person = result.data;
                                if (!!person.nombres) {
                                    nombre_registrador.val(person.nombres);
                                }
                                if (!!person.apellidoPaterno && !!person.apellidoMaterno) {
                                    apellidos_registrador.val(person.apellidoPaterno + " " + person.apellidoMaterno);
                                } else if (!!person.apellidoPaterno) {
                                    apellidos_registrador.val(person.apellidoPaterno);
                                } else if (!!person.apellidoMaterno) {
                                    apellidos_registrador.val(person.apellidoMaterno);
                                }
                            } else {
                                nombre_registrador.val("");
                                apellidos_registrador.val("");
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
    </script>
    <script>
        //COMBO
        $('.js-example-basic-single#red').select2({
            placeholder: "Seleccione la Red",
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
                url: "{{ route('users-listado-red') }}",
                method: "POST",
                data : function ({term, page}) {
                    debugger;
                    var queryParameters = {
                        _token : "{{ csrf_token() }}",
                        search : term??"",
                        iddiresa : !!$("#iddiresa").val() && $("#iddiresa").val().length > 0 ? $("#iddiresa").val().join() : "0",
                    };
                    return queryParameters;
                },
                processResults: function (response) {
                    debugger;
                    var items = [];
                    $.each(response.data, function (index, value) {
                        debugger;
                        if (!!value[0]) {
                            items.push({ text: value[0].nombre, id: value[0].id });
                        } else {
                            items.push({ text: value.nombre, id: value.id });
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
        }).on("change", function (e) {
            debugger;
            $("#microred").val("");
            $("#microred").html("");
            debugger;
            $("#idestablecimiento").val("");
            $("#idestablecimiento").html("");
        });
        //COMBO
        $('.js-example-basic-single#microred').select2({
            placeholder: "Seleccione la Microred",
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
                url: "{{ route('users-listado-microred') }}",
                method: "POST",
                data : function ({term, page}) {
                    debugger;
                    var queryParameters = {
                        _token : "{{ csrf_token() }}",
                        search : term??"",
                        iddiresa : !!$("#iddiresa").val() && $("#iddiresa").val().length > 0 ? $("#iddiresa").val().join() : "0",
                        nombre_red : !!$("#red").val() ? $("#red").val() : "",
                    };
                    return queryParameters;
                },
                processResults: function (response) {
                    debugger;
                    var items = [];
                    $.each(response.data, function (index, value) {
                        debugger;
                        if (!!value[0]) {
                            items.push({ text: value[0].nombre, id: value[0].id });
                        } else {
                            items.push({ text: value.nombre, id: value.id });
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
        }).on("change", function (e) {
            debugger;
            $("#idestablecimiento").val("");
            $("#idestablecimiento").html("");
        });
        //COMBO
        $('.js-example-basic-single#idestablecimiento').select2({
            placeholder: "Seleccione el Establecimiento",
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
                url: "{{ route('users-listado-establecimiento') }}",
                method: "POST",
                data : function ({term, page}) {
                    debugger;
                    var queryParameters = {
                        _token : "{{ csrf_token() }}",
                        search : term??"",
                        iddiresa : !!$("#iddiresa").val() && $("#iddiresa").val().length > 0 ? $("#iddiresa").val().join() : "0",
                        nombre_red : !!$("#red").val() ? $("#red").val() : "",
                        nombre_microred : !!$("#microred").val() ? $("#microred").val() : "",
                    };
                    return queryParameters;
                },
                processResults: function (response) {
                    debugger;
                    var items = [];
                    $.each(response.data, function (index, value) {
                        debugger;
                        if (!!value[0]) {
                            items.push({ text: value[0].nombre, id: value[0].id });
                        } else {
                            items.push({ text: value.nombre, id: value.id });
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
        
        function LimpiarDiris() {
            debugger;
            $("#red").val("");
            $("#red").html("");
            $("#microred").val("");
            $("#microred").html("");
            $("#idestablecimiento").val("");
            $("#idestablecimiento").html("");
        }
        
        function LimpiarRed() {
            debugger;
            $("#red").val("");
            $("#red").html("");
            $("#microred").val("");
            $("#microred").html("");
            $("#idestablecimiento").val("");
            $("#idestablecimiento").html("");
        } 
        
        function LimpiarMicrored() {
            debugger;
            $("#microred").val("");
            $("#microred").html("");
            $("#idestablecimiento").val("");
            $("#idestablecimiento").html("");
        } 
        
        function LimpiarEstablecimiento() {
            debugger;
            $("#idestablecimiento").val("");
            $("#idestablecimiento").html("");
        }
    </script>
    @endsection
</x-app-layout>