<!-- Modal -->
<div class="modal fade" id="modalprincipal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="tipopago"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row m-0 p-0">
                    <div class="col-12 mb-2">
                        <input type="hidden" id="tpago" value="0">
                        <input type="hidden" id="valorFinal" value="0">
                        <input type="text" id="contenedorValor" 
                            class="form-control contenedorValor" value="-"></div>
                    <div class="col-3 "><button class="btn btn-secondary w-100 botones my-2"
                            onclick="pintarNumero('1'); btnCompletado()">1</div>
                    <div class="col-3 "><button class="btn btn-secondary w-100 botones my-2"
                            onclick="pintarNumero('2'); btnCompletado()">2</div>
                    <div class="col-3 "><button class="btn btn-secondary w-100 botones my-2"
                            onclick="pintarNumero('3'); btnCompletado()">3</div>

                    <div class="col-3 "><button class="btn btn-danger w-100 botones my-2" id="eliminarNumero" onclick="eliminarNumero(); btnCompletado()"
                            style="font-size: 14px; font-weight: bold">
                            ELIMINAR</div>

                    <div class="col-3 "><button class="btn btn-secondary w-100 botones my-2"
                            onclick="pintarNumero('4'); btnCompletado()">4</div>
                    <div class="col-3 "><button class="btn btn-secondary w-100 botones my-2"
                            onclick="pintarNumero('5'); btnCompletado()">5</div>
                    <div class="col-3 "><button class="btn btn-secondary w-100 botones my-2"
                            onclick="pintarNumero('6'); btnCompletado()">6</div>
                    <div class="col-3 "><button class="btn btn-success w-100 botones my-2" 
                            style="font-size: 14px; font-weight: bold" data-bs-dismiss="modal">
                            CANCELAR
                    </div>


                    <div class="col-3 "><button class="btn btn-secondary w-100 botones my-2"
                            onclick="pintarNumero('7'); btnCompletado()">7</div>
                    <div class="col-3 "><button class="btn btn-secondary w-100 botones my-2"
                            onclick="pintarNumero('8'); btnCompletado()">8</div>
                    <div class="col-3 "><button class="btn btn-secondary w-100 botones my-2"
                            onclick="pintarNumero('9'); btnCompletado()">9</div>

                    <div class="col-3 "><button class="btn btn-primary w-100 botones my-2"
                            style="font-size: 14px; font-weight:bold" 
                            onclick="pagar()"
                            {{-- onclick="pintarNumero(document.getElementById('valorTotalFinal').value,1)" --}}><div id="textoOk"></div></div>

                    <div class="col-3 "><button class="btn btn-secondary w-100 botones my-2"
                            onclick="pintarNumero('0'); btnCompletado()">0</div>
                    <div class="col-3 "><button class="btn btn-secondary w-100 botones my-2"
                            onclick="pintarNumero('.'); btnCompletado()">.</div>
                    <div class="col-3 "><button class="btn btn-secondary w-100 botones my-2"
                            onclick="pintarNumero('00'); btnCompletado()">00</div>



                </div>
            </div>
            {{--  <div class="modal-footer " style="display: initial">
            <div class="row p-0 m-0 ">
                <div class="col-6 ">
                    <button type="button" class="btn btn-secondary w-100" style="font-size: 18px" data-bs-dismiss="modal">CANCELAR</button>
                </div>
                <div class="col-6 p-1">
                    <button type="button" class="btn btn-primary w-100" style="font-size: 18px">COMPLETO (4.000)</button>
                </div>
                <div class="col-6  " >
                    <button type="button" class="btn btn-success w-100" style="font-size: 18px">PAGAR</button>
                </div>
            </div>
            
        </div> --}}
        </div>
    </div>
</div>
