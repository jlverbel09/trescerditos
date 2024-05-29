<div class="row">
 
    <div class="col-12 mt-2">
        <label for="ticket">Ticket</label>
        <input type="text" readonly placeholder="Ticket" name="ticket" id="ticket"
            class="form-control form-control-sm shadown-sm @error('ticket') is-invalid   @enderror"
            value="@if (!empty($venta->ticket)) {{ old('ticket', str_pad($venta->ticket, 6, '0', STR_PAD_LEFT)) }} @else {{ str_pad($ticket, 6, '0', STR_PAD_LEFT) }} @endif">
        @error('ticket')
            <span class="invalid-feedback">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>


    <div class="col-12 mt-2">
        <label for="id_mesa">Mesa</label>
        <select name="id_mesa" id="id_mesa"
            class="form-control form-control-sm shadown-sm @error('id_mesa') is-invalid   @enderror">
            <option value="">Seleccionar</option>
            @foreach ($mesas as $mesa)
                <option value="{{ $mesa->numero }}" @if (in_array($mesa->numero, $mesaSelect) or $mesa->numero == request()->idmesa) selected @endif>
                    {{ $mesa->numero }} {{ $mesa->descripcion }}</option>
            @endforeach
        </select>
        @error('id_mesa')
            <span class="invalid-feedback">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>



    <div class="col-12 mt-2">
        <label for="id_producto" style="width: 100%">Producto</label>
        <select name="id_producto" style="width: 100%" class="select2" id="id_producto" onchange="calcularVenta()"
            autofocus class="form-control form-control-sm shadown-sm @error('id_producto') is-invalid   @enderror">
            <option value="">Seleccionar</option>
            @foreach ($listProducto as $producto)
                <option value="{{ $producto->id_producto }}" @if (in_array($producto->id_producto, $ventaSelect)) selected @endif>
                    {{ $producto->id_producto }} {{ $producto->nombre1 }}</option>
            @endforeach
        </select>
        @error('id_producto')
            <span class="invalid-feedback">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>


    {{-- $venta->cantidad --}}

    <div class="col-12 row p-0 m-0 mt-2">
        <label for="cantidad">Cantidad</label>
        <div class="col-4 pr-0">
            <button type="button" class="btn btn-danger w-100" onclick="calcularcantidad('-')">-</button>
        </div>
        <div class="col-4 p-0">
            <input type="number" style="font-size:18px" onkeyup="calcularVenta()" placeholder="Cantidad" name="cantidad" id="cantidad"
                class="form-control m-0 h-100 text-center form-control-sm shadown-sm @error('cantidad') is-invalid   @enderror"
                value="{{ old('cantidad', 1) }}">
            @error('cantidad')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="col-4 pr-0">
            <button type="button" class="btn btn-success m-0  w-100" onclick="calcularcantidad('+')">+</button>
        </div>
    </div>
  

    <div class="col-12 mt-2">


    </div>


    <div class="col-12 mt-2">
        <label for="precio">Precio</label>
        <input type="number" onkeyup="calculoproducto()" placeholder="Precio" name="precio" id="precio"
            class="form-control form-control-sm shadown-sm @error('precio') is-invalid   @enderror" step="0.01"
            value="{{ old('precio', $venta->precio) }}">
        @error('precio')
            <span class="invalid-feedback">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="col-12 mt-2">
        <label for="precio total">Precio Total</label>
        <input type="number" readonly placeholder="Precio Total" name="precio_total" id="precio_total"
            class="form-control form-control-sm shadown-sm @error('precio_total') is-invalid   @enderror" step="0.01"
            value="{{ old('precio_total', $venta->precio_total) }}">
        @error('precio_total')
            <span class="invalid-feedback">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="col-12 mt-2">
        <label for="observacion">Observación</label>
        <textarea name="observacion" placeholder="Observación" id="observacion" cols="30" rows="3"
            class="form-control form-control-sm shadown-sm @error('comentario') is-invalid   @enderror">{{ old('comentario', $venta->observacion) }}</textarea>
        @error('observacion')
            <span class="invalid-feedback">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>




    <div class="col-12 mt-4 ">
        <input type="submit" value="{{ $btn }}" class="btn btn-{{ $btn_accion }} btn-sm w-100">
    </div>

</div>


<script>
    $('.select2').select2();
</script>
