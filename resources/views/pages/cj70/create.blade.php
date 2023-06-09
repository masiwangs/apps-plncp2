@extends('layouts.app')

@section('title') Tambah CJ70 @endsection

@section('content')
    <div>
        <h3><i class="bi bi-file-earmark-ruled"></i> Tambah CJ70</h3>
        <nav aria-label="breadcrumb mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                <li class="breadcrumb-item">CJ70</li>
                <li class="breadcrumb-item active" aria-current="page">Tambah CJ70</li>
            </ol>
        </nav>

        <div class="card mb-4">
            <div class="card-body">
                @if (session('message'))
                    <x-alert message="{{ session('message') }}" level="{{ session('level') }}" />
                @endif
                <form method="POST" action="{{ route('cj70.store') }}">
                    @csrf
                    <div class="table-responsive mb-2">
                        <table id="table-form" class="table">
                            <tbody>
                                <tr>
                                    <th width="20%">Nomor SPK</th>
                                    <td>
                                        <select class="form-control select2 w-100" name="nomor_spk">
                                            <option value="" selected="">Pilih SPK</option>
                                            @foreach ($spk as $value)
                                                <option value="{{ $value->id }}">{{ $value->spk_number }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Nomor TUG</th>
                                    <td><input type="text" class="form-control" name="nomor_tug"></td>
                                </tr>
                                <tr>
                                    <th>GL Account</th>
                                    <td><input type="text" class="form-control" name="gl_account"></td>
                                </tr>
                                <tr>
                                    <th>Nomor WBS</th>
                                    <td><input type="text" class="form-control" name="nomor_wbs"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <h5 class="mb-2">Material</h5>
                    <div class="table-responsive mb-3">
                        <table class="table">
                            <thead>
                                <tr>
                                    <td style="font-weight: bold;background: var(--bs-table-striped-bg);" class="text-center">#</td>
                                    <td style="font-weight: bold;background: var(--bs-table-striped-bg);">Master Asset</td>
                                    <td style="font-weight: bold;background: var(--bs-table-striped-bg);">No. Material</td>
                                    <td style="font-weight: bold;background: var(--bs-table-striped-bg);">Nama Pekerjaan Material</td>
                                    <td style="font-weight: bold;background: var(--bs-table-striped-bg);">Gardu</td>
                                    <td style="font-weight: bold;background: var(--bs-table-striped-bg);">Alamat</td>
                                    <td style="font-weight: bold;background: var(--bs-table-striped-bg);">Penyulang</td>
                                    <td style="font-weight: bold;background: var(--bs-table-striped-bg);">Quantity</td>
                                    <td style="font-weight: bold;background: var(--bs-table-striped-bg);">Satuan</td>
                                    <td style="font-weight: bold;background: var(--bs-table-striped-bg);">Nilai Pekerjaan</td>
                                    <td style="font-weight: bold;background: var(--bs-table-striped-bg);">Nilai Material</td>
                                    <td style="font-weight: bold;background: var(--bs-table-striped-bg);">Nilai Overhead</td>
                                </tr>
                            </thead>
                            <tbody id="dynamic_form">
                                <tr>
                                    <td class="text-center"><a href="#" class="btn btn-primary btn-sm btn-tambah"><i class="bi bi-plus"></i> Tambah</a></td>
                                    <td><input type="text" class="form-control" name="master_asset[]" style="width: 100px;"></td>
                                    <td>
                                        <select class="form-control material select2 w-100" name="material[]" style="width: 120px;">
                                            <option value="" selected="">Pilih No. Material</option>
                                        </select>
                                    </td>
                                    <td><input type="text" class="form-control bg-white nama_material" readonly style="width: 200px;"></td>
                                    <td><input type="text" class="form-control" name="gardu[]" style="width: 50px;"></td>
                                    <td><input type="text" class="form-control" name="alamat[]" style="width: 300px;"></td>
                                    <td><input type="text" class="form-control" name="penyulang[]" style="width: 80px;"></td>
                                    <td><input type="number" class="form-control" name="qty[]" style="width: 70px;"></td>
                                    <td><input type="text" class="form-control bg-white satuan" readonly style="width: 50px;"></td>
                                    <td><input type="text" class="form-control numbering" name="nilai_pekerjaan[]" style="width: 100px;"></td>
                                    <td><input type="text" class="form-control numbering" name="nilai_material[]" style="width: 100px;"></td>
                                    <td><input type="text" class="form-control numbering" name="nilai_overhead[]" style="width: 100px;"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-white btn-sm ms-2" type="button"><i class="bi bi-arrow-clockwise"></i> Reset</button>
                        <button class="btn btn-primary btn-sm ms-2" type="submit"><i class="bi bi-cloud-arrow-up-fill"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        // $(document).on('click', '.chip:not(.remove-tag)', function(e){
        // });
        InitializeInput();
        function InitializeInput(){
            const numeralMask = document.querySelectorAll('.numbering');
            if (numeralMask.length) {
                numeralMask.forEach(e => {
                    new Cleave(e, {
                        numeral: true,
                        numeralDecimalMark: ',',
                        numeralDecimalScale: 0,
                        delimiter: '.'
                    });
                });
            }
            $(".material").select2({
                ajax: {
                    url: "{{ route('cj70.material') }}",
                    dataType: 'json',
                    delay: 250,
                    type: 'GET',
                    data: function (params) {
                        return {
                            code: params.term, // search term
                        };
                    },
                    processResults: function (data) {
                        var arr = []
                        $.each(data, function (index, value) {
                            arr.push({
                                id: value.id,
                                text: value.code + ' - ' + value.material_description,
                                name: value.material_description,
                                unit: value.base_unit_of_measure,
                            })
                        })
                        return {
                            results: arr
                        };
                    },
                    cache: true
                },
                escapeMarkup: function (markup) { return markup; },
                minimumInputLength: 1,
                language: {
                    inputTooShort: function() {
                        return 'Masukkan 1 karakter atau lebih';
                    }
                }
            }).on("select2:select", function(e) { 
                $(this).parent().parent().children().children('.nama_material').val(e.params.data.name);
                $(this).parent().parent().children().children('.satuan').val(e.params.data.unit);
            });
        };

        function addForm(){
            $("#dynamic_form").append(`
                <tr class="new-form">
                    <td class="text-center"><a class="btn btn-danger btn-sm btn-hapus" href="#"><i class="bi-trash-fill"></i> Hapus</a></td>
                    <td><input type="text" class="form-control" name="master_asset[]" style="width: 100px;"></td>
                    <td>
                        <select class="form-control material select2-form w-100" name="material[]" style="width: 120px;">
                            <option value="" selected="">Pilih No. Material</option>
                        </select>
                    </td>
                    <td><input type="text" class="form-control bg-white nama_material" readonly style="width: 200px;"></td>
                    <td><input type="text" class="form-control" name="gardu[]" style="width: 50px;"></td>
                    <td><input type="text" class="form-control" name="alamat[]" style="width: 300px;"></td>
                    <td><input type="text" class="form-control" name="penyulang[]" style="width: 80px;"></td>
                    <td><input type="number" class="form-control" name="qty[]" style="width: 70px;"></td>
                    <td><input type="text" class="form-control bg-white satuan" readonly style="width: 50px;"></td>
                    <td><input type="text" class="form-control numbering" name="nilai_pekerjaan[]" style="width: 100px;"></td>
                    <td><input type="text" class="form-control numbering" name="nilai_material[]" style="width: 100px;"></td>
                    <td><input type="text" class="form-control numbering" name="nilai_overhead[]" style="width: 100px;"></td>
                </tr>
            `);
            $('.select2-form').select2();
            InitializeInput();
        }

        $("#dynamic_form").on("click", ".btn-tambah", function(){
            addForm()
        })

        $("#dynamic_form").on("click", ".btn-hapus", function(){
            $(this).parent().parent('.new-form').remove();
        });

    </script>
@endsection