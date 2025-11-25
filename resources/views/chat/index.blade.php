@extends('layouts.app')

@section('content')
    <div class="row">

        {{-- CHAT BOX --}}
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    💬 Group Chat
                </div>

                <div id="chat-box" class="card-body" style="height: 400px; overflow-y: auto;">

                    @foreach ($messages as $msg)
                        <div class="mb-2">
                            <strong>{{ $msg->user->name }}</strong>:

                            @if ($msg->message)
                                <span>{{ $msg->message }}</span>
                            @endif

                            @if ($msg->file)
                                <br>
                                @php $ext = pathinfo($msg->file, PATHINFO_EXTENSION); @endphp

                                {{-- TAMPILKAN GAMBAR --}}
                                @if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                    <a href="{{ asset('storage/' . $msg->file) }}" data-pswp data-pswp-width="1200"
                                        data-pswp-height="1200">

                                        <img src="{{ asset('storage/' . $msg->file) }}"
                                            class="img-fluid mt-1 rounded shadow-sm"
                                            style="max-height:150px; cursor:pointer;">
                                    </a>
                                @else
                                    {{-- FILE BIASA --}}
                                    <a href="{{ asset('storage/' . $msg->file) }}" target="_blank"
                                        class="btn btn-sm btn-secondary mt-1">
                                        📎 Download File
                                    </a>
                                @endif
                            @endif
                        </div>
                    @endforeach

                </div>

                <div class="card-footer">
                    <form id="chat-form" enctype="multipart/form-data">
                        @csrf

                        <div class="input-group mb-2">
                            <input type="text" name="message" class="form-control"
                                placeholder="Ketik pesan atau pilih file...">
                        </div>

                        <div class="input-group">
                            <input type="file" name="file" id="file-input" class="form-control">
                            <!-- PREVIEW FILE AREA -->
                            <div id="file-preview" class="mt-2" style="display:none;">
                                <div class="p-2 border rounded d-flex align-items-center gap-3">
                                    <img id="preview-image" src="" class="img-thumbnail"
                                        style="max-height:120px; display:none;">
                                    <div id="preview-file" style="display:none;">
                                        📄 <span id="preview-file-name"></span>
                                    </div>

                                    <button type="button" id="preview-remove" class="btn btn-sm btn-danger ms-auto">
                                        Hapus
                                    </button>
                                </div>
                            </div>
                            <button class="btn btn-success">
                                Kirim
                            </button>
                        </div>

                    </form>

                    <form method="POST" action="{{ route('logout') }}" class="mt-3">
                        @csrf
                        <button class="btn btn-danger w-100">Logout</button>
                    </form>

                </div>
            </div>
        </div>

        {{-- ONLINE USERS --}}
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    🟢 User Online
                </div>

                <ul class="list-group list-group-flush">
                    @foreach ($users as $user)
                        <li class="list-group-item d-flex justify-content-between">
                            {{ $user->name }}
                            {!! $user->online ? '🟢' : '⚪' !!}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

    </div>

    <!-- IMAGE VIEWER MODAL -->
    <div class="modal fade" id="imageModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-dark">
                <div class="modal-body p-0 text-center">
                    <img id="modalImage" src="" class="img-fluid rounded">
                </div>
            </div>
        </div>
    </div>

    <script>
        function openImage(src) {
            const modalImage = document.getElementById("modalImage");
            modalImage.src = src;
            const modal = new bootstrap.Modal(document.getElementById('imageModal'));
            modal.show();
        }
    </script>

    <script>
        document.getElementById("file-input").addEventListener("change", function() {
            const file = this.files[0];

            const previewBox = document.getElementById("file-preview");
            const imgPreview = document.getElementById("preview-image");
            const filePreview = document.getElementById("preview-file");
            const fileNameText = document.getElementById("preview-file-name");

            if (!file) {
                previewBox.style.display = "none";
                return;
            }

            previewBox.style.display = "block";

            const extension = file.name.split('.').pop().toLowerCase();

            // Jika file adalah gambar
            if (["jpg", "jpeg", "png", "gif", "webp"].includes(extension)) {
                imgPreview.style.display = "block";
                filePreview.style.display = "none";

                // tampilkan thumbnail
                const reader = new FileReader();
                reader.onload = (e) => {
                    imgPreview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
            // FILE NON-GAMBAR (PDF, ZIP, DOCX, dll)
            else {
                imgPreview.style.display = "none";
                filePreview.style.display = "block";

                fileNameText.textContent = file.name;
            }
        });

        // TOMBOL HAPUS PREVIEW
        document.getElementById("preview-remove").addEventListener("click", function() {
            document.getElementById("file-preview").style.display = "none";
            document.getElementById("file-input").value = ""; // reset file
        });
    </script>
@endsection

@vite(['resources/css/app.css', 'resources/js/app.js'])
