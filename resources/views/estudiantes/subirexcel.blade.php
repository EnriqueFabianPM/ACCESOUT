<form action="{{ route('estudiantes.import') }}" method="POST" enctype="multipart/form-data" class="mb-3">
    @csrf
    <div class="form-group">
        <label for="import_file">Subir archivo Excel (.xlsx)</label>
        <input type="file" name="import_file" id="import_file" accept=".xlsx" class="form-control">
        @error('import_file')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary">Subir</button>
</form>