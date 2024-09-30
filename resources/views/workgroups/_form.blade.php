@csrf
<div class="mb-3">
  <label for="name" class="form-label">Nombre</label>
  <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $workgroup->name) }}">
  @error('name') <p style="color: red;">Campo es requerido</p> @enderror
</div>
<div class="mb-3">
  <label for="description" class="form-label">Descripcion</label>
  <textarea name="description" id="description" class="form-control">{{ old('description', $workgroup->description) }}</textarea>
  @error('description') <p style="color: red;">Campo es requerido</p> @enderror
</div>
<div class="row">
  <button type="submit" class="btn btn-primary">Guardar Grupo de Trabajo</button>
</div>