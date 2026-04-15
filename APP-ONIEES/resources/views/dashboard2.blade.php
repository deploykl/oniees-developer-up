<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="py-7">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">        
                <div id="departamento_title" style="z-index: 1;position: absolute;display:none;color: white;background: blue;padding: 1px 5px;border-radius: 10px;font-size: 11px;font-weight: 900;font-family: monospace;"></div>
                <div class="row p-4 m-0" style="background:#96B3FF;color:#FFFFFF">
                   <div class="col-md-9">
                      <div class="row">
                         <div class="col-sm-4">
                            <img src="{{ asset('img/logo_dgos.jpg') }}" style="width:100%;margin:auto">
                         </div>
                         <div class="col-sm-8">
                            <p class="h3 text-center">ONIEES - DIEM</p>
                         </div>
                      </div>
                      <div class="row">
                         <div class="col-sm-4"></div>
                         <div class="col-md-8 col-sm-12">
                            <img src="{{ asset('img/icon-one.png') }}" style="width:100%;max-width:250px;margin:auto">
                         </div>
                      </div>
                   </div>
                   <div class="col-md-3 d-md-block d-sm-none d-none">
                      <div class="row">
                         <div class="col-sm-12">
                            <img src="{{ asset('img/portada1png-min.png') }}" class="xs:hidden" style="margin:auto;max-height: 300px;width: auto;">
                         </div>
                      </div>
                   </div>
                   <div class="col-12 mt-3">
                       <p class="h5 text-center">
                           {{$nombre_eess}}
                        </p>
                   </div>
                   <!--<div class="col-12 mt-3">-->
                   <!--     <p class="h5 text-center">BIENVENIDO AL APLICATIVO ONIEES {{ Auth::user()->lastname }} {{ Auth::user()->name }}</p>-->
                   <!--</div>-->
                </div>
            </div>
            <div class="row text-center mt-3">
                <div class="col-sm--12">
                    <h5>* La informaci&oacute;n ser&aacute; actualizada de forma semestral(6 meses).</h5>
                    <h5>* Dado un PIP y/o IOARR la informaci&oacute;n sera actualizada al finalizar.</h5>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
