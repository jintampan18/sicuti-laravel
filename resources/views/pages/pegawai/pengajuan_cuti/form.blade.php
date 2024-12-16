@extends('layouts.template')

@section('title', '- Form Pengajuan Cuti')

@section('konten')
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Form Pengajuan Cuti</h4>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <form class="form" action="{{ route('post.pengajuan-cuti') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        {{-- Nama Pegawai --}}
                        <div class="form-group row">
                            <label for="example-email-input" class="col-2 col-form-label">
                                Nama Pegawai <span style="color: red;">*</span>
                            </label>
                            <div class="col-10">
                                <input class="form-control" name="name_pegawai" type="text"
                                    value="{{ Auth::user()->name }}" id="example-email-input" disabled>
                            </div>
                        </div>

                        <!-- Pilih Jenis Cuti -->
                        <div class="form-group row">
                            <label for="jenis_cuti_id" class="col-2 col-form-label">
                                Jenis Cuti <span style="color: red;">*</span>
                            </label>
                            <div class="col-10">
                                <select class="form-control" name="jenis_cuti_id" id="jenis_cuti_id" required>
                                    <option value="" disabled selected>Pilih Jenis Cuti</option>
                                    @foreach ($jenisCuti as $item)
                                        <option value="{{ $item->id }}">{{ $item->name_jenis_cuti }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Input Mulai Cuti -->
                        <div class="form-group row">
                            <label for="mulai_cuti" class="col-2 col-form-label">
                                Mulai Cuti <span style="color: red;">*</span>
                            </label>
                            <div class="col-10">
                                <input class="form-control date-input" name="mulai_cuti" type="text" id="mulai_cuti"
                                    placeholder="DD/MM/YYYY" required>
                            </div>
                        </div>

                        <!-- Input Selesai Cuti -->
                        <div class="form-group row">
                            <label for="selesai_cuti" class="col-2 col-form-label">
                                Selesai Cuti <span style="color: red;">*</span>
                            </label>
                            <div class="col-10">
                                <input class="form-control date-input" name="selesai_cuti" type="text" id="selesai_cuti"
                                    placeholder="DD/MM/YYYY" required>
                            </div>
                        </div>

                        {{-- Input Alasan Cuti --}}
                        <div class="form-group row">
                            <label for="example-email-input" class="col-2 col-form-label">Alasan Cuti</label>
                            <div class="col-10">
                                <textarea class="form-control" name="alasan" type="text" value="" id="example-email-input" rows="3"
                                    required></textarea>
                            </div>
                        </div>

                        <!-- Upload Dokumen Pendukung -->
                        <div class="form-group row">
                            <label for="dokumen_pendukung" class="col-2 col-form-label">Dokumen Pendukung</label>
                            <div class="col-10">
                                <input class="form-control-file" name="dokumen_pendukung[]" type="file"
                                    id="dokumen_pendukung" accept="application/pdf" multiple>
                                <small class="text-muted">Bisa mengunggah lebih dari satu file, hanya format PDF yang
                                    diperbolehkan.</small>
                            </div>
                        </div>

                        <!-- File yang Diunggah -->
                        <div class="form-group row">
                            <div class="col-12">
                                <label for="dokumen_pendukung" class="col-form-label">File yang diunggah</label>
                                <div id="uploaded-files" class="row">
                                    <!-- Card akan ditambahkan di sini melalui JavaScript -->
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <button class="btn btn-primary btn-block" type="submit">Buat</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dokumenPendukung = document.getElementById('dokumen_pendukung');
            const uploadedFilesContainer = document.getElementById('uploaded-files');

            // Menyimpan daftar file yang valid
            let selectedFiles = [];

            dokumenPendukung.addEventListener('change', function() {
                const files = Array.from(dokumenPendukung.files);
                selectedFiles = [...selectedFiles, ...files]; // Tambahkan file baru ke daftar

                // Clear container
                uploadedFilesContainer.innerHTML = '';

                // Render ulang semua file dalam daftar
                selectedFiles.forEach((file, index) => {
                    // Generate a unique ID for each file card
                    const fileId = `file-${index}`;

                    // Create card
                    const card = document.createElement('div');
                    card.className = 'col-md-4';
                    card.id = fileId;
                    card.innerHTML = `
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">${file.name}</h5>
                        <p class="card-text">Ukuran: ${(file.size / 1024).toFixed(2)} KB</p>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <button type="button" class="btn btn-danger btn-sm mt-2 delete-file" data-index="${index}">Hapus</button>
                    </div>
                </div>
            `;

                    // Append card to container
                    uploadedFilesContainer.appendChild(card);

                    // Simulate upload progress
                    const progressBar = card.querySelector('.progress-bar');
                    let progress = 0;
                    const interval = setInterval(() => {
                        if (progress >= 100) {
                            clearInterval(interval);
                        } else {
                            progress += 10;
                            progressBar.style.width = `${progress}%`;
                            progressBar.setAttribute('aria-valuenow', progress);
                        }
                    }, 300);

                    // Add delete functionality
                    const deleteButton = card.querySelector('.delete-file');
                    deleteButton.addEventListener('click', function() {
                        // Remove file from selectedFiles
                        const fileIndex = parseInt(deleteButton.getAttribute('data-index'));
                        selectedFiles.splice(fileIndex, 1);

                        // Re-render the file cards
                        renderFileCards();
                    });
                });
            });

            function renderFileCards() {
                uploadedFilesContainer.innerHTML = ''; // Clear existing cards
                selectedFiles.forEach((file, index) => {
                    const fileId = `file-${index}`;

                    // Create card
                    const card = document.createElement('div');
                    card.className = 'col-md-4';
                    card.id = fileId;
                    card.innerHTML = `
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">${file.name}</h5>
                        <p class="card-text">Ukuran: ${(file.size / 1024).toFixed(2)} KB</p>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <button type="button" class="btn btn-danger btn-sm mt-2 delete-file" data-index="${index}">Hapus</button>
                    </div>
                </div>
            `;

                    // Append card to container
                    uploadedFilesContainer.appendChild(card);

                    // Add delete functionality
                    const deleteButton = card.querySelector('.delete-file');
                    deleteButton.addEventListener('click', function() {
                        const fileIndex = parseInt(deleteButton.getAttribute('data-index'));
                        selectedFiles.splice(fileIndex, 1);

                        // Re-render the file cards
                        renderFileCards();
                    });
                });

                // Update input files
                updateInputFiles();
            }

            function updateInputFiles() {
                const dataTransfer = new DataTransfer();
                selectedFiles.forEach(file => dataTransfer.items.add(file));
                dokumenPendukung.files = dataTransfer.files; // Set ulang isi input
            }
        });
    </script>
@endsection
