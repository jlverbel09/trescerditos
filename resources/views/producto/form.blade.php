<div class="row">


    <div class="col-12 mt-2">
        <label for="id producto">ID Producto</label>
        <input type="number" placeholder="ID" name="id_producto" id="id_producto"
            class="form-control dark form-control-sm shadown-sm @error('id_producto') is-invalid   @enderror"
            value="{{ old('id_producto', $producto->id_producto) }}">
        @error('id_producto')
            <span class="invalid-feedback">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="col-12 mt-2">
        <label for="nombre1">Nombre 1</label>
        <input type="text" placeholder="Nombre 1" name="nombre1" id="nombre1"
            class="form-control dark form-control-sm shadown-sm @error('nombre1') is-invalid   @enderror"
            value="{{ old('nombre1', $producto->nombre1) }}">
        @error('nombre1')
            <span class="invalid-feedback">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="col-12 mt-2">
        <label for="nombre2">Nombre 2</label>
        <input type="text" placeholder="Nombre 2" name="nombre2" id="nombre2"
            class="form-control dark form-control-sm shadown-sm @error('nombre2') is-invalid   @enderror"
            value="{{ old('nombre2', $producto->nombre2) }}">
        @error('nombre2')
            <span class="invalid-feedback">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="col-12 mt-2">
        <label for="precio">Precio</label> 
        <input type="number" onkeyup="calculoproducto()" placeholder="Precio" name="precio" id="precio"  step="0.01"
            class="form-control dark form-control-sm shadown-sm @error('precio') is-invalid   @enderror"
            value="{{ old('precio', $producto->precio) }}">
        @error('precio')
            <span class="invalid-feedback">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

        {{-- 
 
<div class="col-12 mt-2">
        <label for="iva">IVA</label>
        <input type="number" placeholder="IVA" name="iva" id="iva"
            class="form-control dark form-control-sm shadown-sm @error('iva') is-invalid   @enderror"
            value="{{ old('iva', $producto->iva) }}">
        @error('iva')
            <span class="invalid-feedback">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div> --}}

    <div class="col-12 mt-2">
        <label for="comentario">Comentario</label>
        <textarea name="comentario" placeholder="Comentario" id="comentario" cols="30" rows="4" class="form-control dark form-control-sm shadown-sm @error('comentario') is-invalid   @enderror">{{ old('comentario', $producto->comentario) }}</textarea>
        @error('comentario')
            <span class="invalid-feedback">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>


    <div class="col-12 mt-4 ">
        <input type="submit" value="{{ $btn }}" class="btn btn-{{ $btn_accion }} btn-sm w-100">
    </div>

</div>
