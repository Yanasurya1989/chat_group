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
                                    <img src="{{ asset('storage/' . $msg->file) }}" class="img-fluid mt-1"
                                        style="max-height:150px">
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
                            <input type="file" name="file" class="form-control">
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
@endsection

@vite(['resources/css/app.css', 'resources/js/app.js'])
