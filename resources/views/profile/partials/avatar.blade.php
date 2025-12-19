{{-- resources/views/profile/partials/update-avatar-form.blade.php --}}

<p class="mb-4 text-muted small">
    Upload foto profil kamu. Format yang didukung: JPG, PNG, WebP. Maksimal 2MB.
</p>

<form method="post" 
      action="{{ route('profile.avatar.update') }}" 
      enctype="multipart/form-data">
    @csrf
    @method('put')

    <div class="d-flex align-items-center gap-4 mb-4">
        {{-- Avatar Preview --}}
        <div class="position-relative">
            <img 
                id="avatar-preview" 
                class="rounded-circle border" 
                src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('images/default-avatar.png') }}" 
                alt="{{ $user->name }}"
                style="width: 100px; height: 100px; object-fit: cover;"
            >

            @if($user->avatar)
                <button 
                    type="button" 
                    onclick="if(confirm('Hapus foto profil?')) document.getElementById('delete-avatar-form').submit()" 
                    class="btn btn-danger btn-sm rounded-circle position-absolute top-0 end-0 d-flex align-items-center justify-center p-0" 
                    style="width: 24px; height: 24px; margin-top: -5px; margin-right: -5px;"
                    title="Hapus foto"
                >
                    <small>✕</small>
                </button>
            @endif
        </div>

        {{-- Upload Input --}}
        <div class="flex-grow-1">
            <label for="avatar" class="form-label d-none">Pilih Foto</label>
            <input 
                type="file" 
                name="avatar" 
                id="avatar" 
                accept="image/*" 
                onchange="previewAvatar(event)" 
                class="form-control @error('avatar') is-invalid @enderror"
            >

            @error('avatar')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <div>
        <button type="submit" class="btn btn-primary shadow-sm">
            <i class="bi bi-cloud-arrow-up me-1"></i> Simpan Foto
        </button>
    </div>
</form>

{{-- Hidden Form Delete Avatar --}}
<form id="delete-avatar-form" action="{{ route('profile.avatar.destroy') }}" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>

<script>
    function previewAvatar(event) {
        const file = event.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('avatar-preview').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
</script>