@extends('admin.layout.master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="text-center">
                                    <img src="{{ asset('assets/image/defaultmenu.jpg') }}" alt="menu image" id="thumbnail"
                                        class="img-lg rounded mb-3 object-fit-cover">
                                    <button class="btn btn-primary mt-2" id="btnUpload">
                                        Upload Foto
                                    </button>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="row">
                                    <div class="col-md-6">
                                        <form action="{{ route('admin.user.store') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input type="file" name="avatar" id="avatar" class="d-none">
                                            <x-input id="name" name="name" type="text" label="Nama" required/>
                                            <x-input id="email" name="email" type="email" label="Email" required/>

                                            <div class="form-group">
                                                <label for="category">Jenis Kelamin</label>
                                                <div class="form-group row">
                                                    <div class="col-sm-4">
                                                        <div class="form-check">
                                                            <label class="form-check-label">
                                                            <input type="radio" id="Pria" name="sex" value="1" class="form-check-input">
                                                            Pria
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-5">
                                                        <div class="form-check">
                                                            <label class="form-check-label">
                                                            <input type="radio" id="Wanita" name="sex" value="2" class="form-check-input">
                                                            Wanita
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                    <div class="col-md-6">
                                        <x-input id="phone" name="phone" type="number" label="No. HP" required/>
                                        <x-input id="address" name="address" type="text" label="Alamat" required/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-end">
                                <button type="submit" class="btn btn-primary">
                                    Simpan
                                </button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('js-internal')
        <script>
            $(function() {
                $('#btnUpload').on('click', function(e) {
                    e.preventDefault();
                    $('#avatar').trigger('click');

                    $('#avatar').on('change', function() {
                        let file = $(this).prop('files')[0];
                        let reader = new FileReader();
                        reader.onload = function(e) {
                            $('#thumbnail').attr('src', e.target.result);
                            $('#btnUpload').text('Ubah Foto');
                        }
                        reader.readAsDataURL(file);
                    });
                });
            });

            @if (Session::has('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '{{ Session::get('success') }}',
                })
            @endif

            @if (Session::has('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: '{{ Session::get('error') }}',
                })
            @endif
        </script>
    @endpush
@endsection
