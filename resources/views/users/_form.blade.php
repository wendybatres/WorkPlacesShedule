@csrf
<div class="mb-3">
  <label for="name" class="form-label">Nombre</label>
  <input type="name" class="form-control" name="name" id="name" value="{{ old('name', $user->name) }}">
  @error('name') <p style="color: red;">Campo es requerido</p> @enderror
</div>
<div class="mb-3">
  <label for="email" class="form-label">Email</label>
  <input type="email" class="form-control" name="email" id="email" value="{{ old('email', $user->email) }}">
  @error('email') <p style="color: red;">Campo es requerido</p> @enderror
</div>
<div class="mb-3">
  <label for="password" class="form-label">Contraseña</label>
  <input type="password" class="form-control" name="password" id="password" value="{{ old('password', $user->password) }}">
  @error('password') <p style="color: red;">Campo es requerido</p> @enderror
</div>

<div class="mb-3">
  <label for="rolId" class="form-label">Rol</label>
  <select name="rolId" class="form-control">
    @foreach($roles as $rol)
    <option value="{{ $rol->id }}"
      @selected($rol->id == $user->rolId)>{{ $rol->name }}</option>
    @endforeach
  </select>
  @error('rolId') <p style="color: red;">Campo es requerido</p> @enderror
</div>

<div class="mb-3">
  <label for="workgroupId" class="form-label">Grupo de Trabajo</label>
  <select name="workgroupId" class="form-control">
    @foreach($workgroups as $workgroup)
    <option value="{{ $workgroup->id }}"
      @selected($workgroup->id == $user->workgroupId)>{{ $workgroup->name }}</option>
    @endforeach
  </select>
  @error('workgroupId') <p style="color: red;">Campo es requerido</p> @enderror
</div>
<div class="row">
  <button type="submit" class="btn btn-primary">Guardar Usuario</button>
</div>